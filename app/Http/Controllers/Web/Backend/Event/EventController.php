<?php

namespace App\Http\Controllers\Web\Backend\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('backend.layouts.event.index', compact('events'));
    }

    public function create()
    {
        return view('backend.layouts.event.create'); // The view to create an event
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'nullable|date_format:Y-m-d\TH:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $event = Event::create($request->all());

        return redirect()->route('event.index')
            ->with('success', 'Event created successfully.');
    }

    public function googleLink($id)
    {
        $event = Event::findOrFail($id);

        $googleLink = 'https://www.google.com/calendar/render';
        $queryParams = [
            'action' => 'TEMPLATE',
            'text' => $event->title,
            'dates' => Carbon::parse($event->start_time)->format('Ymd\THis\Z') . '/' . Carbon::parse($event->end_time)->format('Ymd\THis\Z'),
            'details' => $event->description,
            'location' => $event->location,
        ];

        $googleLink .= '?' . http_build_query($queryParams);

        return redirect($googleLink);
    }

    public function downloadICS($id)
    {
        $event = Event::findOrFail($id);
        $startTime = Carbon::parse($event->start_time)->format('Ymd\THis\Z');

        $content = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\n";
        $content .= "SUMMARY:" . $event->title . "\r\n";
        $content .= "DTSTART:" . $startTime . "\r\n";
        $content .= "DTEND:" . Carbon::parse($event->end_time)->format('Ymd\THis\Z') . "\r\n";
        $content .= "LOCATION:" . $event->location . "\r\n";
        $content .= "DESCRIPTION:" . $event->description . "\r\n";
        $content .= "END:VEVENT\r\nEND:VCALENDAR";

        return response($content)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'inline; filename="event.ics"');
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if ($event) {
            $event->delete();
            return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
        }

        return redirect()->route('event.index')->with('error', 'Event not found.');
    }
}
