@extends('layouts.app')

@section('content')
<div class="container">
    <h5 style="margin-top: 50px;">Assign Role to {{ "{$user->FIRST_NAME} {$user->LAST_NAME}" }}</h5>

    <!-- Back button with a backward icon -->
    <div class="mb-3 text-end">
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>

    <!-- Form to assign role -->
    <form action="{{ route('users.assignRoles', $user->ID) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="fw-bold mb-2">Select Role</label>
            <div class="form-check">
                @foreach($roles as $role)
                    <div class="mb-2">
                      <input
                            type="radio"
                            name="role"
                            value="{{ $role->id }}"
                            id="role-{{ $role->id }}"
                            class="form-check-input"
                            {{ $user->role && $user->role->id === $role->id ? 'checked' : '' }}>
                        <label for="role-{{ $role->id }}" class="form-check-label">
                            {{ ucfirst($role->name) }}
                        </label>

                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save"></i> Update Role
        </button>
    </form>
</div>
@endsection
