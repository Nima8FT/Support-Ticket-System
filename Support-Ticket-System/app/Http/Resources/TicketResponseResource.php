<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'response_id' => $this->id,
            'response_body' => $this->response_body,
            'status' => $this->status,
            'is_reply' => !is_null($this->parent_response_id),

            'ticket' => [
                'id' => $this->ticket->id,
                'title' => $this->ticket->title,
                'creator' => [
                    'id' => $this->ticket->user->id,
                    'name' => $this->ticket->user->name,
                    'email' => $this->ticket->user->email
                ]
            ],

            'responder' => $this->user ? [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'role' => $this->user->is_admin ? 'admin' : 'user'
            ] : null,

            'admin' => $this->admin ? [
                'id' => $this->admin->id,
                'name' => $this->admin->name,
                'email' => $this->admin->email
            ] : null,

            'parent_response' => $this->parentResponse ? [
                'id' => $this->parentResponse->id,
                'response_body' => $this->parentResponse->response_body,
                'created_at' => $this->parentResponse->created_at->format('Y-m-d H:i:s'),
                'responder' => $this->parentResponse->user ? [
                    'name' => $this->parentResponse->user->name,
                    'email' => $this->parentResponse->user->email
                ] : null
            ] : null,

            'dates' => [
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
