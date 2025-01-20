@extends('layouts.app')

@section('content')
<div style="background-color: #f3f4f6; font-family: Arial, sans-serif; padding: 20px; margin-left: 0; display: flex; justify-content: flex-start; align-items: flex-start; min-height: 100vh;">
    <div style="background: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 1000px; margin-top: 70px;">
        <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 0px; color: #111827; text-align: center;">Submit Feedback</h1>
        <!-- Display success message -->
         @guest
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif
        @endguest

        <form action="{{ url('/feedback') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            @csrf
            <div>
                <label for="email" style="display: block; font-size: 14px; color: #374151; margin-bottom: 5px;">Email</label>
                <input type="email" name="email" id="email" required 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px;">
            </div>

            <div>
                <label for="message" style="display: block; font-size: 14px; color: #374151; margin-bottom: 5px;">Message</label>
                <textarea name="message" id="message" required rows="4" 
                          style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px;"></textarea>
            </div>

            <div>
                <label for="rating" style="display: block; font-size: 14px; color: #374151; margin-bottom: 5px;">Rating</label>
                <select name="rating" id="rating" required 
                        style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; font-size: 14px;">
                    <option value="" disabled selected>Select Rating -......-</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>

            <button type="submit" 
                    style="background-color: #2563eb; color: #ffffff; padding: 10px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; text-align: center;">
                Submit Feedback
            </button>
        </form>
    </div>
</div>

@endsection