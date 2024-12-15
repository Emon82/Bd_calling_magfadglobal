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
        return view('backend.layouts.event.index');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Create and store the event in the database
        $event = Event::create($request->all());

        // Generate the ICS file content
        $startTime = Carbon::parse($event->start_time)->format('Ymd\THis\Z');

        $content = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\n";
        $content .= "SUMMARY:" . $event->title . "\r\n";
        $content .= "DTSTART:" . $startTime . "\r\n";
        $content .= "LOCATION:" . $event->location . "\r\n";
        $content .= "DESCRIPTION:" . $event->description . "\r\n";
        $content .= "END:VEVENT\r\nEND:VCALENDAR";

        // Return the ICS file as a downloadable response
        return response($content, 200)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="event.ics"');
    }

    public function googleLink($id)
    {
        $event = Event::findOrFail($id);

        $googleLink = 'https://www.google.com/calendar/render';
        $queryParams = [
            'action' => 'TEMPLATE',
            'text' => $event->title,
            'dates' => Carbon::parse($event->start_time)->format('Ymd\THis\Z'),
            'details' => $event->description,
            'location' => $event->location,
        ];
        $googleLink .= '?' . http_build_query($queryParams);

        return view('google', compact('googleLink'));
    }

    public function downloadICS($id)
    {
        $event = Event::findOrFail($id);

        $startTime = Carbon::parse($event->start_time)->format('Ymd\THis\Z');

        $content = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nBEGIN:VEVENT\r\n";
        $content .= "SUMMARY:" . $event->title . "\r\n";
        $content .= "DTSTART:" . $startTime . "\r\n";
        $content .= "LOCATION:" . $event->location . "\r\n";
        $content .= "DESCRIPTION:" . $event->description . "\r\n";
        $content .= "END:VEVENT\r\nEND:VCALENDAR";

        return response($content)
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'inline; filename="event.ics"');
    }
}
