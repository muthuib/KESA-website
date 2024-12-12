@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Card to encapsulate the newsletter content -->
    <div class="card">
        <div class="card-header">
            <!-- Title for the newsletters section -->
            <h1>Newsletters</h1>
        </div>
        <div class="card-body">
            <!-- Button to add a new newsletter, aligned to the right -->
            <div class="mb-3 text-end">
                <a href="{{ route('send.newsletter') }}" class="btn btn-primary">Add Newsletter</a>
            </div>
            <!-- Table to display newsletters -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th> <!-- Index number -->
                        <th>Subject</th> <!-- Newsletter subject -->
                        <th>Message</th> <!-- Newsletter message -->
                        <th>Created At</th> <!-- Timestamp -->
                        <th>Action</th> <!-- Action buttons -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($newsletters as $newsletter)
                        <tr>
                            <td>{{ $loop->iteration }}</td> <!-- Display the current row number -->
                            <td>{{ $newsletter->SUBJECT }}</td> <!-- Display the newsletter subject -->
                            <td>
                                <!-- Container for short and full messages -->
                                <div>
                                    <!-- Truncated message displayed by default -->
                                    <span class="short-message">
                                        {{ Str::limit($newsletter->MESSAGE, 50) }}
                                    </span>
                                    <!-- Full message hidden by default -->
                                    <span class="full-message d-none">
                                        {{ $newsletter->MESSAGE }}
                                    </span>
                                    <!-- Button to toggle between truncated and full message -->
                                    @if (strlen($newsletter->MESSAGE) > 50)
                                        <button class="btn btn-link btn-sm toggle-message" type="button">Read More</button>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $newsletter->CREATED_AT }}</td> <!-- Display the creation timestamp -->
                            <td>
                                <!-- Card for organizing action buttons -->
                                <div class="card" style="width: 180px;">
                                    <div class="card-body p-2">
                                        <!-- Button to view the newsletter -->
                                        <a href="{{ route('newsletters.show', $newsletter->ID) }}" class="btn btn-primary btn-sm mb-1">View</a>
                                        <!-- Button to edit the newsletter -->
                                        <a href="{{ route('newsletters.edit', $newsletter->ID) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                                        <!-- Form to delete the newsletter -->
                                        <form action="{{ route('newsletters.destroy', $newsletter->ID) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Message displayed if no newsletters are found -->
                        <tr>
                            <td colspan="5" class="text-center">No newsletters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle the "Read More" and "Read Less" functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Select all toggle buttons and add a click event listener
        document.querySelectorAll('.toggle-message').forEach(button => {
            button.addEventListener('click', function () {
                // Find the parent row of the clicked button
                const row = this.closest('div');
                // Get the short and full message elements
                const shortMessage = row.querySelector('.short-message');
                const fullMessage = row.querySelector('.full-message');
                // Toggle between showing and hiding the messages
                if (shortMessage.classList.contains('d-none')) {
                    shortMessage.classList.remove('d-none'); // Show the truncated message
                    fullMessage.classList.add('d-none'); // Hide the full message
                    this.textContent = 'Read More'; // Update button text
                } else {
                    shortMessage.classList.add('d-none'); // Hide the truncated message
                    fullMessage.classList.remove('d-none'); // Show the full message
                    this.textContent = 'Read Less'; // Update button text
                }
            });
        });
    });
</script>
@endsection
