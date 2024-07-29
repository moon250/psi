<?php

namespace App\Listeners;

use Illuminate\Http\Client\Events\RequestSending;

class HttpRequestSent
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
    public function handle(RequestSending $event): void
    {
        \Debugbar::startMeasure("{$event->request->url()}");
    }
}
