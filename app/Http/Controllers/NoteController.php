<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\NotesResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;

class NoteController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NotesResource::collection(
            Note::where('user_id',Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoteRequest $request)
    {
       $request->validated($request->all());

       $note = Note::create([
           'user_id'=>Auth::user()->id,
           'title'=>$request->title,
           'description'=>$request->description,
           'isFavorite'=>$request->isFavorite,
       ]);

       return new NotesResource($note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     // search notes by id where user_id = Auth::user()->id
    public function show(Note $note)
    {
        
       return $this->isNotAuthorized($note ) ? $this->isNotAuthorized($note) : new NotesResource($note);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        if(Auth::user()->id !== $note->user_id){
            return response()->json([
                'message'=>'You are not authorized to update this note'
            ],403);
        }
        $note->update($request->all());
        return new NotesResource($note);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {

        
        return $this->isNotAuthorized($note) ? $this->isNotAuthorized($note) : $note->delete();
    }

    /**
     * Search for a title.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        return Note::where('title','like','%'.$title.'%')->get();
        
    }

    private function isNotAuthorized(Note $note){
        if (Auth::user()->id !==$note->user_id) {
            return response()->json(['message'=>'You are not authorized to request this note'],403);
        }
    }
}