@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Card with margin-left for spacing -->
        <div class="card" style="margin-left: 0px; width: 1100px; top: 40px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Resources</h5>
            <a href="{{ route('resources.create') }}" class="btn btn-primary"> <i class="fas fa-plus"></i>Add New Resource</a>
        </div>
        <div class="card-body">
            <!-- Table Design with Borders and Divided Columns -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th> <!-- Row number -->
                        <th>Title</th>
                        <th>Description</th>
                        <th>File Path</th>
                        <th>Price</th>
                        <th>Actions</th> <!-- Actions for each row -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resources as $resource)
                    <tr id="row-{{ $resource->ID }}">
                        <!-- Display row number -->
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $resource->TITLE }}</td>
                        <td>
                            <!-- Truncated description with Read More link -->
                            <div id="description-{{ $resource->ID }}" class="description">
                                {{ Str::limit($resource->DESCRIPTION, 100) }}
                                @if(strlen($resource->DESCRIPTION) > 100)
                                    <a href="javascript:void(0);" onclick="toggleDescription({{ json_encode($resource->ID) }})"
                                    class="text-info" id="read-more-{{ $resource->ID }}">... Read More</a>
                                @endif
                            </div>

                            <!-- Full description that appears when toggled -->
                            <div id="full-description-{{ $resource->ID }}" class="full-description" style="display: none; opacity: 0; transition: opacity 0.5s;">
                                {{ $resource->DESCRIPTION }}
                                <a href="javascript:void(0);" onclick="toggleDescription({{ json_encode($resource->ID) }})"
                                class="text-info" id="read-more-{{ $resource->ID }}"> Read Less</a>
                            </div>
                        </td>
                        <td>
                            <img src="{{ asset($resource->FILE_PATH) }}" alt="Resource Image" width="100">
                        </td>
                        <td>{{ $resource->PRICE }}</td>
                        <td>
                            <!-- Card for Action Buttons (View, Edit, Delete) -->
                            <div class="card" style="padding: 10px;">
                                <!-- Use flexbox to align buttons horizontally -->
                                <div class="d-flex justify-content-start gap-2">
                                    <a href="{{ route('resources.view', $resource->ID) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('resources.edit', $resource->ID) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('resources.destroy', $resource->ID) }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Function to toggle the visibility of the full description with animation
function toggleDescription(resourceId) {
    // Get the full description, read more link, and truncated description for the clicked resource
    var fullDescription = document.getElementById('full-description-' + resourceId);
    var readMoreLink = document.getElementById('read-more-' + resourceId);
    var description = document.getElementById('description-' + resourceId);

    // Check if the full description is currently hidden
    if (fullDescription.style.display === 'none') {
        // Show the full description with fade-in animation
        fullDescription.style.display = 'block';
        setTimeout(function() {
            fullDescription.style.opacity = 1; // Fade-in effect
        }, 10); // Small delay to ensure transition
        description.style.display = 'none';
        readMoreLink.innerHTML = 'Read Less'; // Change link text to 'Read Less'
    } else {
        // Hide the full description with fade-out animation
        fullDescription.style.opacity = 0; // Fade-out effect
        setTimeout(function() {
            fullDescription.style.display = 'none';
        }, 500); // Delay before hiding to allow the fade-out effect
        description.style.display = 'block';
        readMoreLink.innerHTML = 'Read More'; // Change link text back to 'Read More'
    }
}
</script>
@endsection
