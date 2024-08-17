// public/js/scripts.js
$(document).ready(function () {
  loadNegaraData(); 
  
  function loadNegaraData() {
    $('#negara-table').bootstrapTable('destroy');
    $('#loading').show(); 

    $.getJSON('/api/negara', function (negaraData) {
      const kawasanPromises = [];
      const direktoratPromises = [];

      negaraData.forEach(function (negara) {
        negara.created_at = formatLocalTime(negara.created_at);
        kawasanPromises.push(
          $.getJSON(`/api/kawasan/${negara.id_kawasan}`).then(function (kawasanData) {
            negara.nama_kawasan = kawasanData.nama_kawasan;
          })
        );

        direktoratPromises.push(
          $.getJSON(`/api/direktorat/${negara.id_direktorat}`).then(function (direktoratData) {
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
        url: `/api/negara/${negaraId}`,
        type: 'DELETE',
        success: function (result) {
          alert('Negara berhasil dihapus!')
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
