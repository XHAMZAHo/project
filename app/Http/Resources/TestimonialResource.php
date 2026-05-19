<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_name' => $this->client_name,
            'client_position' => $this->client_position,
            'client_company' => $this->client_company,
            'content' => $this->content,
            'rating' => $this->rating,
            'avatar_url' => $this->avatar_url,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
