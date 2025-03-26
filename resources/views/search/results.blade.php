@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Search Results</h2>

    @if(isset($searchTerm))
        <p>Showing results for: <strong>{{ $searchTerm }}</strong></p>
    @endif

    @if($results->isEmpty())
        <p style="text-align: center;">No results found.</p>
    @else
        <ul>
            @foreach($results as $result)
                <!-- <li>
                    @if(isset($result->name))
                        {{ $result->name }}
                    @elseif(isset($result->title))
                        {{ $result->title }}
                    @elseif(isset($result->organization_name))
                        {{ $result->organization_name }}
                    @else
                        Result found
                    @endif
                </li> -->
                <li>
                    @if(isset($result->name))
                        <!-- {{ $result->name }}
                    @elseif(isset($result->title))
                        {{ $result->title }}
                    @elseif(isset($result->organization_name))
                        {{ $result->organization_nam }} -->
                    @else
                     Please enter word in search bar
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
