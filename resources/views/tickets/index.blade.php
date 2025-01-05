@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .action-buttons a, .action-buttons form {
            margin-right: 10px;
        }

        .btn-create {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-create i {
            margin-right: 8px;
        }

        .alert-success {
            color: green;
            margin-bottom: 20px;
        }

        .pagination {
            justify-content: center;
        }

        table {
            border-collapse: separate; /* Ensure the borders are visible */
            border-spacing: 0; /* Remove any extra spacing between rows */
        }

        th, td {
            border: 1px solid #ddd !important; /* Force border visibility */
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 style="margin-left: 10px;">Event Tickets</h1>
        <a href="{{ route('tickets.create') }}" class="btn-create">
            <i class="fas fa-plus-circle"></i> Create New Ticket
        </a>
    </div>
    <table style="margin-left: 10px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Price (KES)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Display row number -->
                    <td>{{ $ticket->name }}</td>
                    <td>{{ number_format($ticket->price, 2) }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this ticket?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No tickets available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="pagination">
        {{ $tickets->links() }}
    </div>

</body>
</html>
@endsection
