@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Impact Stats</h2>

    <form action="{{ route('impacts.update', $impact->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Total People</label>
            <input type="number" name="total_people" class="form-control" value="{{ $impact->total_people }}" required>
        </div>
        <div class="mb-3">
            <label>Total Events</label>
            <input type="number" name="total_events" class="form-control" value="{{ $impact->total_events }}" required>
        </div>
        <div class="mb-3">
            <label>Total Trainings</label>
            <input type="number" name="total_trainings" class="form-control" value="{{ $impact->total_trainings }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
