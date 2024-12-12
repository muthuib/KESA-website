<form action="{{ route('subscribe') }}" method="POST">
    @csrf
    <label for="EMAIL">Subscribe to our Newsletter:</label>
    <input type="EMAIL" name="EMAIL" required>
    <button type="submit">Subscribe</button>
</form>
