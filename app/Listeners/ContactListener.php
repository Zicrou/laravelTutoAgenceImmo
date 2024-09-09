<?php

namespace App\Listeners;

use App\Events\ContactRequestEvent;
use App\Mail\PropertyContactMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class ContactListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private Mailer $mailer)
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(ContactRequestEvent $event): void
    {
        sleep(3);
        $this->mailer->send(new PropertyContactMail($event->property, $event->data));
    }
}
