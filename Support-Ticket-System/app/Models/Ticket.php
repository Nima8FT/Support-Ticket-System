<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'status', 'category', 'priority'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
