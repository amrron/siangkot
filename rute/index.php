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
    
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/@turf/turf/turf.min.js"></script>
    <script src="../scripts/leaflet.geometryutil.js"></script>
    <script src="../scripts/leaflet-arrowheads.js"></script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Style -->
    <link rel="stylesheet" href="../style.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'Montserrat', 'Roboto'],
                    },
                },
            }
        }
    </script>
</head>
<body class="font-sans">
     <!-- NAVBAR START -->
     <header class="bg-[#4983C7]">
        <div class="container max-w-7xl m-auto py-6 px-4">
            <h1 class="pb-10 text-[#EAD7BB] font-semibold text-3xl">SiAngkot</h1>
            <div class="flex justify-between"> <!-- Membuat container baru untuk mengatur float -->
                <h3 class="text-[#EAD7BB;] text-2xl font-semibold">Informasi Rute <br> Angkutan Kota Bogor</h3>
                <img src="../assets/logo_kotabogor.png" alt="logo_kotabogor">
            </div>
        </div>
    </header>
    <!-- NAVBAR END -->

    <!-- CONTENT START -->
    <div class="max-w-7xl m-auto p-6">
        <!-- <p class="mb-5 text-xl mb-8">Untuk melihat rute dan perkiraan tarif Angkot silahkan klik nomor angkot di bawah ini</p> -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 flex flex-col gap-4">
                <div class="text-decoration-none bg-[#4983C7] p-8 rounded-lg overflow-y-scroll h-[calc(100vh-32px)] no-scrollbar cursor-grab">
                    <ol id="lintasan" class="relative border-s border-[#EAD7BB]">
                        
                    </ol> 
                </div>      
            </div>
            <div class="col-span-8 ">
                <div id="map" class="w-100 h-[calc(100vh-32px)] rounded-lg"></div>
                <div id="route-length" class="mt-3">Jarak rute: <span id="length"></span> km</div>
            </div>
            
        </div>
    </div>
    
    <!-- CONTENT END -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const koridor = "<?= $_GET['koridor'] ?>";

        $.getJSON('../data/lintasan.json', function(data){
            let lintasan = data[koridor];
            $.each(lintasan, function(index, tempat){
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
            L.geoJson(data, {
                filter: function(feature, layer) {
                    return feature.properties.koridor == koridor;
                },
                style: function(feature) {
                    return {
                        color: colorStyle[feature.properties.koridor],
                        weight: 5
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

            data.features.forEach(feature => {
                if (feature.properties.koridor == koridor) {
                    totalLength += turf.length(feature);
                }
            });

            $("#length").text(totalLength.toFixed(2));
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

        map.locate({setView: true, maxZoom: 14});

        async function onLocationFound(e) {
            var radius = 50;

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
    </script>

</body>
</html>