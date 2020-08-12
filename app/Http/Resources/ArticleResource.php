<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'content' => html_entity_decode($this->content),
            'likeNum' => $this->like,
            'isLiked' => $this->liked,
            'image' => $this->when(($this->image != null), Storage::disk('public')->url($this->image), null),
            'author' => (new MemberResource($this->whenLoaded('author')))
        ];
    }
}