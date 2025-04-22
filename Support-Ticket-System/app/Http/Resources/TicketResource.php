<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->id,
            'ticket_title' => $this->title,
            'ticket_category' => $this->category,
            'ticket_content' => $this->body,
            'priority_level' => $this->priority,
            'current_status' => $this->status,
            'user' => [
                'user_id' => $this->user->id,
                'user_email' => $this->user->email,
                'user_name' => $this->user->name
            ],
            'created_date' => $this->created_at->format('Y-m-d H:i:s'),
            'last_updated' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
