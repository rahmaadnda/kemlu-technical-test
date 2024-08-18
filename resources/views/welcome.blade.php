<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <a href="{{ route('geomap') }}" class="btn btn-warning btn-lg button-spacing">Lihat Geomap</a>
        <a href="{{ route('datatable') }}" class="btn btn-warning btn-lg">Lihat Daftar Negara</a>
    </div>
</body>
</html>
