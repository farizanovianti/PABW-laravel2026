<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Input Mahasiswa</title>
</head>
<body>
    <h2>Input Data Mahasiswa</h2>

    <form action="/simpan" method="POST">
        @csrf
        <label>Nama:</label>
        <input type="text" id="nama" name="nama"><br><br>

        <label>Email:</label>
        <input type="text" id="email" name="email"><br><br>

        <label>Jurusan:</label>
        <input type="text" id="jurusan" name="jurusan"><br><br>

        <label>Umur:</label>
        <input type="text" id="umur" name="umur"><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>

