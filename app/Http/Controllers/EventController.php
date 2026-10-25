<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'dibuka')->orderBy('tanggal_mulai', 'asc')->get();
        return view('tenant.event', compact('events'));
    }
}