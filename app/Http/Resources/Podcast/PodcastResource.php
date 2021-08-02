<?php

namespace App\Http\Resources\Podcast;

use Illuminate\Http\Resources\Json\JsonResource;

class PodcastResource extends JsonResource
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
            'body' => $this->body,
            'is_public' => $this->is_public,
            'filename' => $this->filename,
            'fileUrl' => $this->file_url,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}