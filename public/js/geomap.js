document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([20, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var colorScale;

    function getColor(d) {
        return colorScale(d) || '#ffffff';
    }

    $.getJSON('/api/negara', function (negaraData) {
        var directorateIds = [...new Set(negaraData.map(d => d.id_direktorat))];
        
        colorScale = d3.scaleOrdinal(d3.schemeCategory10).domain(directorateIds);

        negaraData.forEach(function (d) {
            $.when(
                $.getJSON(`/api/kawasan/${d.id_kawasan}`),
                $.getJSON(`/api/direktorat/${d.id_direktorat}`)
            ).then(function (kawasanData, direktoratData) {
                d.nama_kawasan = kawasanData[0].nama_kawasan;
                d.nama_direktorat = direktoratData[0].nama_direktorat;

                getCountryData(d.kode_negara)
                    .then(countryData => {
                        var country = countryData[0] || { latlng: [0, 0], flags: { svg: '' } };
                        L.circleMarker([country.latlng[0], country.latlng[1]], {
                            color: getColor(d.id_direktorat),
                            radius: 10
                        }).addTo(map)
                        
                        .bindTooltip(`<b>${d.nama_negara}</b><br>Kawasan: ${d.nama_kawasan}<br>Direktorat: ${d.nama_direktorat}<br><img src="${country.flags.svg}" width="20" height="10">`);
                    });
            });
        });
    });

    function getCountryData(code) {
        return fetch(`https://restcountries.com/v3.1/alpha/${code}`)
            .then(response => response.json())
            .catch(() => ({ latlng: [0, 0], flags: { svg: '' } }));
    }
});