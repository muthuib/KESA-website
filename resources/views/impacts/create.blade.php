@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Add Impact Stats</h2>

    <form action="{{ route('impacts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Events Held</label>
            <input type="number" name="total_people" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>People Reached</label>
            <input type="number" name="total_events" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Certified Leadership Fellows</label>
            <input type="number" name="total_trainings" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
