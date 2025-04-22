<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    /** @use HasFactory<\Database\Factories\TicketResponseFactory> */
    use HasFactory;

    protected $fillable = ['ticket_id', 'user_id', 'admin_id', 'response_body', 'parent_response_id', 'status'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function parentResponse()
    {
        return $this->belongsTo(TicketResponse::class, 'parent_response_id');
    }
}
