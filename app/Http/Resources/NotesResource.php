<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>(string)$this->id,
            'attributes'=>[
                'title'=>$this->title,
                'description'=>$this->description,
                'isFavorite'=>$this->isFavorite,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ],
            'relationships'=>[
                'id'=>(string)$this->user_id,
                'user name'=>$this->user->name,
                'user email'=>$this->user->email,
            ],
            
        ];
    }
}