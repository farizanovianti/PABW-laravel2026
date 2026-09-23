<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Mahasiswa</title>
</head>
<body>
    <h1>Form Input Data Mahasiswa</h1>
    <form action="{{ route('mahasiswa.proses') }}" method="POST">
        @csrf
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" required>
        <br><br>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required>
        <br><br>
        <label for="prodi">Program Studi:</label>
        <input type="text" name="prodi" id="prodi" required>
        <br><br>
        <label for="semester">Semester:</label>
        <input type="number" name="semester" id="semester" required>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>