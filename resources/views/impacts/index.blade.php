@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">📊 Impact Statistics</h2>

    @if($impact)
        <div class="card p-4 mb-4 shadow-sm rounded">
            <p><strong>Total People:</strong> {{ $impact->total_people }}</p>
            <p><strong>Total Events:</strong> {{ $impact->total_events }}</p>
            <p><strong>Total Trainings:</strong> {{ $impact->total_trainings }}</p>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('impacts.edit', $impact->id) }}" class="btn btn-warning d-flex align-items-center gap-2">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('impacts.destroy', $impact->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger d-flex align-items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    @else
        <a href="{{ route('impacts.create') }}" class="btn btn-primary d-flex align-items-center gap-2" style="width: 200px;">
            <i class="fas fa-plus-circle"></i> Add Impact Stats
        </a>
    @endif
</div>
@endsection
