<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event; // Import the Event model
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return View
     */
    public function index(): View
    {
        // Fetch the total number of events
        $totalEvents = Event::count();

        // Pass the totalEvents to the Blade view
        return view('backend.layouts.dashboard.index', compact('totalEvents'));
    }
}
