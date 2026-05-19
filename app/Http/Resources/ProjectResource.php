<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'client_name' => $this->client_name,
            'image_url' => $this->image_url,
            'url' => $this->url,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'completed_at' => $this->completed_at?->format('Y-m-d'),
            'technologies' => $this->whenLoaded('technologies', function () {
                return $this->technologies->map(fn ($tech) => [
                    'id' => $tech->id,
                    'name' => $tech->name,
                    'slug' => $tech->slug,
                ]);
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
