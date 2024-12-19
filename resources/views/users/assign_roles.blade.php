@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Roles to {{ $user->USERNAME }}</h1>

         <!-- Back button with a backward icon -->
         <div class="mb-3 text-end">
        <a href="{{ route('users.index') }}" class="btn btn-outline-dark">
            <i class="fa fa-backward"></i> Back
        </a>
    </div>
    <!-- Display success message if available -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Display error messages if validation fails -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to assign roles -->
    <form action="{{ route('users.assignRoles', $user->ID) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Roles</label>
            <div class="form-check">
                @foreach($roles as $role)
                    <div>
                        <input 
                            type="checkbox" 
                            name="roles[]" 
                            value="{{ $role->id }}" 
                            id="role-{{ $role->id }}"
                            class="form-check-input"
                            {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}>
                        <label for="role-{{ $role->id }}" class="form-check-label">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i>Update Roles</button>
    </form>
</div>
@endsection
