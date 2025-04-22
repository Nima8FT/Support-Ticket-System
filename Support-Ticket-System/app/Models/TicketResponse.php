<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    /** @use HasFactory<\Database\Factories\TicketResponseFactory> */
    use HasFactory;

    protected $fillable = ['ticket_id', 'user_id', 'admin_id', 'response_body', 'parent_response_id', 'status'];
}
