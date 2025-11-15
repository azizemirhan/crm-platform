<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'display_name' => $this->display_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'title' => $this->title,
            'department' => $this->department,
            'status' => $this->status,
            'avatar_url' => $this->avatar_url,
            'initials' => $this->initials,
            'engagement_score' => $this->engagement_score,
            'account' => new AccountResource($this->whenLoaded('account')),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'activities' => ActivityResource::collection($this->whenLoaded('activities')),
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'last_contacted_at' => $this->last_contacted_at?->toIso8601String(),
            'last_activity_at' => $this->last_activity_at?->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}