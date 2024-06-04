<?php
    if (isset($_GET['koridor'])) {
        $koridor = $_GET['koridor'];
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAngkot</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">   -->
    
    <?php include '../layouts/head.php'; ?>

</head>
<body class="font-sans">
    <!-- NAVBAR START -->
    <?php include '../layouts/navbar.php'; ?> 
    <!-- NAVBAR END -->

    <!-- CONTENT START -->
    <div class="max-w-7xl m-auto p-6 pt-12 min-h-screen">
        <?php
        if (isset($_GET['koridor'])) :
        ?>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <a href="/" class="flex gap-2 item-center text-lg font-semibold">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                    </svg>
                    <span>
                    Lihat rute lain
                    </span> 
                </a>
            </div>
            <div class="col-span-4 flex flex-col gap-4">
                <p class="">Angkot <span id="koridor_angkot">24</span> melewati <span id="total_wilayah">32</span> jalan/wilayah. Berangkat dari <span id="asal_rute"></span> dan berakhir di <span id="tujuan_rute"></span>. Rute Ankot ini memilki total panjang rute <span id="panjang_rute"></span> km.</p>
                <div class="text-decoration-none bg-[#4983C7] p-8 rounded-lg overflow-y-scroll max-h-[calc(100vh-314px)] no-scrollbar cursor-grab">
                    <ol id="lintasan" class="relative border-s border-[#EAD7BB]">
                        
                    </ol> 
                </div>      
            </div>
            <div class="col-span-8 ">
                <h2 class="font-bold text-gray-700 mb-4">Peta rute Angkutan Kota Bogor <span id="map-title"></span></h2>
                <div id="map" class="w-100 h-[calc(100vh-242px)] rounded-lg"></div>
                <!-- <div id="route-length" class="mt-3">Jarak rute: <span id="length"></span> km</div> -->
            </div>
        </div>
        <?php
        else :
        require_once "rute.php";
        endif;
        ?>
    </div>
    
    <!-- CONTENT END -->

    <!-- FOOTER START -->
    <?php include '../layouts/footer.php'; ?>
    <!-- FOOTER END -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
         <?php
        if (isset($_GET['koridor'])) :
        ?>
        $(document).ready(function(){

            const koridor = "<?= $_GET['koridor'] ?>";

            $('#koridor_angkot').text(koridor)

            $.getJSON('/data/lintasan.json', function(data){
                let lintasan = data[koridor];
                let jumlahWilayah = lintasan.lintasan.length - 1;
                $('#total_wilayah').text(jumlahWilayah);
                $.each(lintasan.lintasan, function(index, tempat){
                    let timeline = `<li class="mb-4 ms-4">
                                <div class="absolute w-3 h-3 bg-[#EAD7BB] rounded-full mt-1.5 -start-1.5 border border-[#EAD7BB]"></div>
                                <time class="mb-1 text-sm font-normal leading-none text-[#EAD7BB]">${tempat}</time>
                            </li>`;
                    $('#lintasan').append(timeline);
                });
            });

            const map = L.map('map', {
                center: [-6.596645, 106.797313],
                zoom: 14,
            });

            let colorStyle = {
                '01': "#1abc9c",
                '02': "#2ecc71",
                '03': "#3498db",
                '04': "#9b59b6",
                '05': "#34495e",
                '06': "#16a085",
                '07': "#27ae60",
                '08': "#2980b9",
                '09': "#8e44ad",
                '10': "#2c3e50",
                '24': "#e67e22",
            }

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            async function fetchData() {
                try {
                    const res = await fetch("../data/rute.geojson");
                    const data = await res.json();
                    ruteData = data;
                    return data;
                } catch (error) {
                    console.error('Error fetching the GeoJSON data:', error);
                    throw error;
                }
            }

            function configureLeaflet(data) {
                let totalLength = 0;
                var geoJsonLayer = L.geoJson(data, {
                    filter: function(feature, layer) {
                        if (feature.properties.koridor == koridor) {
                            $('#map-title').text(feature.properties.koridor + " : " + feature.properties.asalTujuan);
                            let asalTujuan = feature.properties.asalTujuan
                            let asalTujuanArray = feature.properties.asalTujuan.split(" - ");
                            console.log(asalTujuanArray);
                            let asal_rute = asalTujuanArray[0];
                            let tujuan_rute = asalTujuanArray[1];
                            $('#asal_rute').html(asal_rute);
                            $('#tujuan_rute').html(tujuan_rute);
                        }
                        return feature.properties.koridor == koridor;
                    },
                    style: function(feature) {
                        return {
                            color: colorStyle[feature.properties.koridor],
                            // weight: 1
                        }
                    },
                    arrowheads: {
                        frequency: '150px',
                        size: '12px'
                    },
                    onEachFeature: function(feature, layer) {
                        if (feature.properties.length) {
                            var lineLength = turf.length(feature);
                            layer.bindPopup(`Panjang rute: ${lineLength.toFixed(2)} km`);
                        }
                    }
                }).addTo(map);

                if (geoJsonLayer.getLayers().length > 0) {
                    var bounds = geoJsonLayer.getBounds();
                    map.fitBounds(bounds);
                }

                data.features.forEach(feature => {
                    if (feature.properties.koridor == koridor) {
                        totalLength += turf.length(feature);
                    }
                });

                $("#length").text(totalLength.toFixed(2));
                $("#panjang_rute").text(totalLength.toFixed(2));
            }

            async function initializeMap() {
                try {
                    const geojsonData = await fetchData();
                    configureLeaflet(geojsonData);
                } catch (error) {
                    console.error('Failed to initialize map:', error);
                }
            }

            initializeMap();

            map.locate({watch: false});

            async function onLocationFound(e) {
                var radius = 0;

                L.marker(e.latlng).addTo(map)
                    .bindPopup("Lokasi Anda saat ini").openPopup();

                L.circle(e.latlng, radius).addTo(map);

                let ruteData = await fetchData();

                // Temukan titik terdekat pada rute angkot
                if (ruteData) {
                    let userLocation = [e.latlng.lng, e.latlng.lat];
                    let nearestPoint = findNearestRoute(userLocation, ruteData);

                    if (nearestPoint) {
                        L.Routing.control({
                            waypoints: [
                                L.latLng(e.latlng.lat, e.latlng.lng),
                                L.latLng(nearestPoint[1], nearestPoint[0])
                            ],
                            fitSelectedRoutes: true,
                            draggableWaypoints: false,
                            routeWhileDragging: false,
                            lineOptions: {
                                addWaypoints: false,
                            }
                        }).addTo(map);
                    }
                }
            }

            function findNearestRoute(userLocation, routes) {
                let nearestPoint = null;
                let shortestDistance = Infinity;

                routes.features.forEach(function(route) {
                    if (route.properties.koridor == koridor) {
                        route.geometry.coordinates.forEach(function(lineString) {
                            var line = turf.lineString(lineString);
                            var nearest = turf.nearestPointOnLine(line, userLocation, { units: 'kilometers' });
                            var distance = turf.distance(userLocation, nearest, { units: 'kilometers' });
                            if (distance < shortestDistance) {
                                shortestDistance = distance;
                                nearestPoint = nearest.geometry.coordinates;
                            }
                        });
                    }
                });

                return nearestPoint;
            }

            map.on('locationfound', function(e) {
                onLocationFound(e);
            });

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationerror', onLocationError);

        })
        <?php
        else :
        ?>
        $(document).ready(function(){
            $.getJSON('/data/lintasan.json', function(data){
                $('#daftar-rute').empty();
                $.each(data, function(index, lintasans) {
                    let lintas = `
                    <div class="w-full lintasan-card col-auto">
                        <div class="bg-white shadow-md border rounded-lg p-4 h-full">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="flex flex-col">
                                        <div class="w-full flex justify-between">
                                            <h2 class="text-lg font-semibold">Rute ${index}</h2>
                                            <a href="/rute/${index}" class="text-blue-500">Lihat peta</a>
                                        </div>
                                        <p class="text-sm text-gray-900 tracking-tight font-medium mb-2">${lintasans.asalTujuan}</p>
                                        <p class="text-sm text-gray-700 line-clamp-1 flex-grow mb-2" id="lintasan">${lintasans.lintasan.join(" - ")}</p>
                                        <button class="text-sm text-start read-more">Lebih lanjut</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    `;
                    $('#daftar-rute').append(lintas);
                });
            });

            $(document).on('click', '.read-more', function(){
                console.log('read more');
                let lintasan = $(this).siblings('#lintasan');
                if (lintasan.hasClass('line-clamp-1')) {
                    lintasan.removeClass('line-clamp-1');
                    $(this).text('Lebih sedikit');
                } else {
                    lintasan.addClass('line-clamp-1');
                    $(this).text('Lebih lanjut');
                }
                $(this).closest('.lintasan-card').toggleClass('col-span-3');
            });
        });
        <?php
        endif;
        ?>
    </script>

</body>
</html>