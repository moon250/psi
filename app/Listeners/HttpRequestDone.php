<?php

namespace App\Listeners;

use Illuminate\Http\Client\Events\ResponseReceived;

class HttpRequestDone
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
    public function handle(ResponseReceived $event): void
    {
        \Debugbar::stopMeasure("{$event->request->url()}");
    }
}
