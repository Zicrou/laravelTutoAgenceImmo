<?php

namespace App\Listeners;

use App\Events\ContactRequestEvent;
use App\Mail\PropertyContactMail;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer;

class ContactEventSubscriber
{
    public function __construct(private Mailer $mailer)
    {

    }

    public function sendEmailForContact(ContactRequestEvent $event)
    {
        $this->mailer->send(new PropertyContactMail($event->property, $event->data));
    }
    public function subscribe(Dispatcher $dispatcher)
    {
        return[
            ContactRequestEvent::class => 'sendEmailForContact'
        ];
    }
}