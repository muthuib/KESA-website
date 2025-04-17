@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Add Impact Stats</h2>

    <form action="{{ route('impacts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Total People</label>
            <input type="number" name="total_people" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total Events</label>
            <input type="number" name="total_events" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total Trainings</label>
            <input type="number" name="total_trainings" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
