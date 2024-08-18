<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualisasi Geomap</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        .tooltip {
            background: white;
            border-radius: 4px;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script> 

    <script>
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
    </script>
</body>
</html>
