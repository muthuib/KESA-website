@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 90px;">
        <!-- Back Button -->
        <a href="{{ route('about.index') }}" class="btn btn-dark" style="position: absolute; top: 20px; right: 20px; z-index: 10; padding: 10px;">
            <i class="fas fa-backward" style="font-size: 18px; color: white;"></i> Back
        </a>

        <h2>Add About Us</h2>

        <!-- Form to Add About Us -->
        <form action="{{ route('about.store') }}" method="POST">
            @csrf

            <!-- About Milestones Consultancy Field -->
            <div class="mb-3">
                <label for="about" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">About Milestones Consultancy</label>
                <div id="about" class="quill-editor" style="min-height: 200px;">{!! old('about') !!}</div>
                <input type="hidden" name="about" id="about-hidden">
                @error('about')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Vision Field -->
            <div class="mb-3">
                <label for="vision" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">Vision</label>
                <div id="vision" class="quill-editor" style="min-height: 150px;">{!! old('vision') !!}</div>
                <input type="hidden" name="vision" id="vision-hidden">
                @error('vision')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mission Field -->
            <div class="mb-3">
                <label for="mission" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">Mission</label>
                <div id="mission" class="quill-editor" style="min-height: 150px;">{!! old('mission') !!}</div>
                <input type="hidden" name="mission" id="mission-hidden">
                @error('mission')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Objectives Field -->
            <div class="mb-3">
                <label for="objectives" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">Objectives</label>
                <div id="objectives" class="quill-editor" style="min-height: 150px;">{!! old('objectives') !!}</div>
                <input type="hidden" name="objectives" id="objectives-hidden">
                @error('objectives')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Motto Field -->
            <div class="mb-3">
                <label for="motto" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">Motto</label>
                <div id="motto" class="quill-editor" style="min-height: 100px;">{!! old('motto') !!}</div>
                <input type="hidden" name="motto" id="motto-hidden">
                @error('motto')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Belief Field -->
            <div class="mb-3">
                <label for="belief" class="form-label" style="color: brown; font-size: 20px; font-weight: bold;">Values</label>
                <div id="belief" class="quill-editor" style="min-height: 100px;">{!! old('belief') !!}</div>
                <input type="hidden" name="belief" id="belief-hidden">
                @error('belief')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
               <!-- Add About Us Image slides -->
                <a href="{{ route('about-slides.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Add About Us Slides
                </a>
            </div>
        
            <button type="submit" class="btn btn-success">Submit and Save</button>
        </form>
    </div>

    <!-- Add Quill Editor Styles & Scripts -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    
    <script>
        function initializeQuill(editorId, hiddenInputId, initialValue) {
            const editor = new Quill(editorId, {
                theme: 'snow',
                placeholder: 'Enter text...',
                modules: {
                    toolbar: [
                        [{ 'font': [] }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link'],
                        ['clean']
                    ]
                }
            });
            if (initialValue.trim() !== '') {
                editor.root.innerHTML = initialValue;
                document.querySelector(hiddenInputId).value = initialValue;
            }
            editor.on('text-change', function () {
                document.querySelector(hiddenInputId).value = editor.root.innerHTML.trim();
            });
            return editor;
        }

        // Get initial values from Laravel old() helper
        const initialAbout = `{!! old('about', '') !!}`;
        const initialVision = `{!! old('vision', '') !!}`;
        const initialMission = `{!! old('mission', '') !!}`;
        const initialObjectives = `{!! old('objectives', '') !!}`;
        const initialMotto = `{!! old('motto', '') !!}`;
        const initialBelief = `{!! old('belief', '') !!}`;

        // Initialize Quill editors for each field
        const aboutEditor = initializeQuill('#about', '#about-hidden', initialAbout);
        const visionEditor = initializeQuill('#vision', '#vision-hidden', initialVision);
        const missionEditor = initializeQuill('#mission', '#mission-hidden', initialMission);
        const objectivesEditor = initializeQuill('#objectives', '#objectives-hidden', initialObjectives);
        const mottoEditor = initializeQuill('#motto', '#motto-hidden', initialMotto);
        const beliefEditor = initializeQuill('#belief', '#belief-hidden', initialBelief);

        // Update hidden inputs before form submission
        document.querySelector('form').addEventListener('submit', function (event) {
            document.querySelector('#about-hidden').value = aboutEditor.root.innerHTML.trim();
            document.querySelector('#vision-hidden').value = visionEditor.root.innerHTML.trim();
            document.querySelector('#mission-hidden').value = missionEditor.root.innerHTML.trim();
            document.querySelector('#objectives-hidden').value = objectivesEditor.root.innerHTML.trim();
            document.querySelector('#motto-hidden').value = mottoEditor.root.innerHTML.trim();
            document.querySelector('#belief-hidden').value = beliefEditor.root.innerHTML.trim();

            if (
                document.querySelector('#about-hidden').value.trim() === '' ||
                document.querySelector('#vision-hidden').value.trim() === '' ||
                document.querySelector('#mission-hidden').value.trim() === '' ||
                document.querySelector('#objectives-hidden').value.trim() === '' ||
                document.querySelector('#motto-hidden').value.trim() === '' ||
                document.querySelector('#belief-hidden').value.trim() === ''
            ) {
                event.preventDefault();
                alert("All fields are required!");
            }
        });
    </script>
@endsection
