<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => html_entity_decode($this->content),
            'isDeleted' => isset($this->deleted_at),
            'author' => (new MemberResource($this->whenLoaded('author')))
        ];
    }
}
