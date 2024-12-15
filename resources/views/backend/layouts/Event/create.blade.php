@extends('backend.app')

@section('title', 'Event Settings')

@section('content')
{{-- PAGE-HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Event Settings</h1>
    </div>
    <div class="ms-auto pageheader-btn">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Event Settings</li>
        </ol>
    </div>
</div>

{{-- FORM TO CREATE EVENT --}}
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card box-shadow-0">
            <div class="card-body">
                <form method="post" action="{{ route('event.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Event Title -->
                    <div class="row mb-4">
                        <label for="title" class="col-md-3 form-label">Event Title</label>
                        <div class="col-md-9">
                            <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                   placeholder="Enter event title" type="text" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Start Time -->
                    <div class="row mb-4">
                        <label for="start_time" class="col-md-3 form-label">Start Time</label>
                        <div class="col-md-9">
                            <input class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                                   name="start_time" placeholder="Enter start time" type="datetime-local"
                                   value="{{ old('start_time') }}">
                            @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- End Time -->
                    <div class="row mb-4">
                        <label for="end_time" class="col-md-3 form-label">End Time</label>
                        <div class="col-md-9">
                            <input class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                                   name="end_time" placeholder="Enter end time" type="datetime-local"
                                   value="{{ old('end_time') }}">
                            @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="row mb-4">
                        <label for="location" class="col-md-3 form-label">Location</label>
                        <div class="col-md-9">
                            <input class="form-control @error('location') is-invalid @enderror" id="location"
                                   name="location" placeholder="Enter location" type="text" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-4">
                        <label for="description" class="col-md-3 form-label">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>

                @isset($googleLink)
                <p>
                    <a href="{{ $googleLink }}" target="_blank" class="btn btn-success mt-3">Add to Google Calendar</a>
                </p>
                @endisset

                @isset($downloadICSLink)
                <p>
                    <a href="{{ $downloadICSLink }}" target="_blank" class="btn btn-info mt-3">Download ICS File</a>
                </p>
                @endisset

            </div>
        </div>
    </div>
</div>
@endsection
