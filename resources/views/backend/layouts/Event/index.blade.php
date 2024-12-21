@extends('backend.app')

@section('title', 'Event Settings')

@section('content')
<div class="page-header">
    <h1 class="page-title">Event Management</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>Upcoming Events</h2>
    </div>
    <div class="mb-3" style="display: flex; justify-content:end;margin:0 20px">
        <a href="{{ route('event.create') }}" class="btn btn-primary">Add Event</a>
    </div>
    <div class="card-body">
        @if($events->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td>{{ $event->location }}</td>
                    <td>
                        <a href="{{ route('event.googleLink', $event->id) }}" target="_blank" class="btn btn-info btn-sm">Google Calendar</a>
                        <a href="{{ route('event.downloadICS', $event->id) }}" class="btn btn-success btn-sm">Download ICS</a>
                        <form action="{{ route('event.destroy', $event->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>No events available.</p>
        @endif
    </div>
</div>
@endsection