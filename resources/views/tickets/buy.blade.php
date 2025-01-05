@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Ticket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }

        .card-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        button#buyTicket {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button#buyTicket:hover {
            background-color: #0056b3;
        }

        .swal2-styled {
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="card" style="margin-top: 70px;">
        <div class="card-header">Purchase Ticket</div>

        <form action="{{ route('mpesa.initiate') }}" method="POST" id="mpesaForm">
            @csrf
            <div class="form-group">
                <label for="ticket">Select Ticket:</label>
                <select name="ticket_id" id="ticket" class="form-control" required>
                    <option value="">-- Select Ticket --</option>
                    @foreach ($tickets as $ticket)
                        <option value="{{ $ticket->id }}" data-price="{{ $ticket->price }}">
                            {{ $ticket->name }} - KES {{ number_format($ticket->price, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="amount" id="amount" value="">
            
            <div class="form-group">
                <label for="phone">Phone Number (Start with 254):</label>
                <input type="text" name="phone" id="phone" class="form-control" required placeholder="2547XXXXXXXX">
            </div>

            <button type="button" id="buyTicket">Buy Ticket</button>
        </form>
    </div>

    <script>
       document.getElementById('buyTicket').addEventListener('click', function() {
    const ticketElement = document.getElementById('ticket');
    const ticketId = ticketElement.value;
    const ticketPrice = parseInt(ticketElement.options[ticketElement.selectedIndex].getAttribute('data-price')); // Ensure integer
    const phone = document.getElementById('phone').value;

    if (!ticketId || !phone) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Fields',
            text: 'Please select a ticket and enter your phone number.'
        });
        return;
    }

    // Confirm the payment
    Swal.fire({
        title: 'Confirm Payment',
        text: `Proceed to pay KES ${ticketPrice}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Pay Now!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Append the amount to the form (if required)
            const form = document.getElementById('mpesaForm');
            const amountInput = document.createElement('input');
            amountInput.type = 'hidden';
            amountInput.name = 'amount';
            amountInput.value = ticketPrice;
            form.appendChild(amountInput);
            form.submit();
        }
    });
});

    </script>

</body>
</html>

@endsection
