<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Jobs\SendTicketCreationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketCreationMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        SendTicketCreationEmail::dispatch($event->ticket->user->email);
    }
}
