<form action="/resources" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="TITLE" placeholder="Title" required>
    <textarea name="DESCRIPTION" placeholder="Description"></textarea>
    <input type="file" name="FILE" required>
    <input type="number" name="PRICE" placeholder="Price (0 for free)" min="0">
    <button type="submit">Upload</button>
</form>
