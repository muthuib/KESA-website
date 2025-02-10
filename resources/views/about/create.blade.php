@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
            <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back <!-- Arrow Icon -->
        </a>

        <h2>Add About Us</h2>

        <!-- Form to Add About Us -->
        <form action="{{ route('about.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="vision" class="form-label">Vision</label>
                <!-- Quill Editor for Vision -->
                <div id="vision" class="quill-editor">{!! old('vision') !!}</div>
                <input type="hidden" name="vision" id="vision-hidden">
                @error('vision')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="mission" class="form-label">Mission</label>
                <!-- Quill Editor for Mission -->
                <div id="mission" class="quill-editor">{!! old('mission') !!}</div>
                <input type="hidden" name="mission" id="mission-hidden">
                @error('mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="objectives" class="form-label">Objectives</label>
                <!-- Quill Editor for Objectives -->
                <div id="objectives" class="quill-editor">{!! old('objectives') !!}</div>
                <input type="hidden" name="objectives" id="objectives-hidden">
                @error('objectives')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Submit and Save</button>
        </form>
    </div>

    <!-- Add Quill Editor Styles & Scripts -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    
    <script>
    function initializeQuill(editorId, hiddenInputId, initialValue) {
        // Initialize Quill with text color & background color support
        const editor = new Quill(editorId, {
            theme: 'snow',
            placeholder: 'Enter text...',
            modules: {
                toolbar: [
                    [{ 'font': [] }], // Font selection
                    [{ 'size': ['small', false, 'large', 'huge'] }], // Text size
                    ['bold', 'italic', 'underline', 'strike'], // Text styles
                    [{ 'color': [] }, { 'background': [] }], // Text & background color
                    [{ 'script': 'sub' }, { 'script': 'super' }], // Subscript & superscript
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }], // Lists
                    [{ 'align': [] }], // Text alignment
                    ['link'], // Links
                    ['clean'] // Remove formatting button
                ]
            }
        });

        // Set initial value if it exists
        if (initialValue.trim() !== '') {
            editor.root.innerHTML = initialValue;
            document.querySelector(hiddenInputId).value = initialValue; // Ensure hidden input has content
        }

        // Update hidden input field when content changes
        editor.on('text-change', function () {
            document.querySelector(hiddenInputId).value = editor.root.innerHTML.trim();
        });

        return editor;
    }

    // Get initial values from PHP variables (handling potential empty values)
    const initialVision = `{!! old('vision', '') !!}`;
    const initialMission = `{!! old('mission', '') !!}`;
    const initialObjectives = `{!! old('objectives', '') !!}`;

    // Initialize Quill Editors
    const visionEditor = initializeQuill('#vision', '#vision-hidden', initialVision);
    const missionEditor = initializeQuill('#mission', '#mission-hidden', initialMission);
    const objectivesEditor = initializeQuill('#objectives', '#objectives-hidden', initialObjectives);

    // Ensure values are updated before form submission
    document.querySelector('form').addEventListener('submit', function (event) {
        document.querySelector('#vision-hidden').value = visionEditor.root.innerHTML.trim();
        document.querySelector('#mission-hidden').value = missionEditor.root.innerHTML.trim();
        document.querySelector('#objectives-hidden').value = objectivesEditor.root.innerHTML.trim();

        // Debugging: Check if inputs are actually being set before submission
        console.log("Vision:", document.querySelector('#vision-hidden').value);
        console.log("Mission:", document.querySelector('#mission-hidden').value);
        console.log("Objectives:", document.querySelector('#objectives-hidden').value);

        // If any field is empty, prevent submission and alert the user
        if (
            document.querySelector('#vision-hidden').value.trim() === '' ||
            document.querySelector('#mission-hidden').value.trim() === '' ||
            document.querySelector('#objectives-hidden').value.trim() === ''
        ) {
            event.preventDefault();
            alert("All fields are required!");
        }
    });
</script>

@endsection
