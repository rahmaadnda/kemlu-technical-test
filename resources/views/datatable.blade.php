<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tabel Data</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">

  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <div class="container mt-50">
    <h1 class="text text-center">Daftar Negara</h1>
    <div id="loading" class="text-center" style="display: none;">
        <div class="spinner-border" role="status">
            <span class="sr-only">Memuat...</span>
        </div>
    </div>

    <table id="negara-table" class="table table-striped border-warning"
           data-pagination="true"
           data-search="true">
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>

  <script src="{{ asset('js/datatable.js') }}"></script>
</body>
</html>
