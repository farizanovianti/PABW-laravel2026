<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Form</title>
</head>
<body>
    <h1>Form Input Data</h1>
    <form action="{{ route('form.submit') }}" method="POST">
        @csrf
        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" required>
        <br><br>
        <label for="umur">Umur:</label>
        <input type="number" name="umur" id="umur" required>
        <br><br>
        <label for="alamat">Alamat:</label>
        <textarea name="alamat" id="alamat" required></textarea>
        <br><br>
        <button type="submit">Submit</button>
</body>
</html>