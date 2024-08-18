<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tabel Data</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
</head>
<body>
  <div class="container" style="margin-top: 40px; margin-bottom: 20px;">
    <h1 class="text text-center">Daftar Negara</h1>
    
    <div id="loading" class="text-center" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
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

  <script>
    $(document).ready(function () {
      loadNegaraData(); 
      
      function loadNegaraData() {
        $('#negara-table').bootstrapTable('destroy');
        $('#loading').show(); 

        $.getJSON('/api/api/negara', function (negaraData) {
          const kawasanPromises = [];
          const direktoratPromises = [];

          negaraData.forEach(function (negara) {
            negara.created_at = formatLocalTime(negara.created_at);
            kawasanPromises.push(
              $.getJSON(`/api/api/kawasan/${negara.id_kawasan}`).then(function (kawasanData) {
                negara.nama_kawasan = kawasanData.nama_kawasan;
              })
            );

            direktoratPromises.push(
              $.getJSON(`/api/api/direktorat/${negara.id_direktorat}`).then(function (direktoratData) {
                negara.nama_direktorat = direktoratData.nama_direktorat;
              })
            );
          });

          Promise.all([...kawasanPromises, ...direktoratPromises]).then(function () {
            $('#negara-table').bootstrapTable({
              data: negaraData,
              columns: [{
                field: 'id_negara',
                title: 'Nomor',
                formatter: nomorFormatter  
              }, {
                field: 'nama_negara',
                title: 'Nama Negara'
              }, {
                field: 'nama_kawasan',
                title: 'Nama Kawasan'
              }, {
                field: 'nama_direktorat',
                title: 'Nama Direktorat'
              }, {
                field: 'created_at',
                title: 'Waktu Dibuat'
              }, {
                field: 'actions',
                title: 'Aksi',
                formatter: actionFormatter,
                events: actionEvents
              }]
            });

            $('#loading').hide(); 
          }).catch(function (error) {
            console.error("Error fetching kawasan or direktorat data:", error);
            $('#loading').hide();
          });
        }).fail(function () {
          $('#loading').hide(); 
        });
      }

      function nomorFormatter(value, row, index) {
        return index + 1; 
      }

      function actionFormatter(value, row, index) {
        return `<button class="btn btn-danger btn-sm delete-button" data-id="${row.id_negara}">Hapus</button>`;
      }

      window.actionEvents = {
        'click .delete-button': function (e, value, row, index) {
          const negaraId = row.id_negara;

          $.ajax({
            url: `/api/api/negara/${negaraId}`,
            type: 'DELETE',
            success: function (result) {
              alert('Negara berhasil dihapus!');
              loadNegaraData(); 
            },
            error: function (xhr, status, error) {
              console.error('Failed to delete negara:', error);
            }
          });
        }
      };

      function formatLocalTime(utcDate) {
        const date = new Date(utcDate);  
        return date.toLocaleString(); 
      }
    });
  </script>
</body>
</html>
