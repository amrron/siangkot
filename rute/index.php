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
     <!-- <header class="bg-[#4983C7]">
        <div class="container max-w-7xl m-auto py-6 px-4">
            <h1 class="pb-10 text-[#EAD7BB] font-semibold text-3xl">SiAngkot</h1>
            <div class="flex justify-between">
                <h3 class="text-[#EAD7BB;] text-2xl font-semibold">Informasi Rute <br> Angkutan Kota Bogor</h3>
                <img src="../assets/logo_kotabogor.png" alt="logo_kotabogor">
            </div>
        </div>
    </header> -->
    <nav class="border-gray-200 bg-[#4983C7]">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="">
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="/assets/logo_singkot.png" class="h-8" alt="Flowbite Logo" />
                </a>
                <div class="">
                    <h1 class="text-[#EAD7BB] text-lg">
                        Informasi Rute Angkutan Kota Bogor
                    </h1>
                </div>
            </div>
            <button data-collapse-toggle="navbar-solid-bg" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-solid-bg" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent ">
                    <li>
                    <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white" aria-current="page">Home</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Rute</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Tentang</a>
                    </li>
                    <!-- <li>
                    <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Pricing</a>
                    </li>
                    <li>
                    <a href="#" class="block py-2 px-3 md:p-0 text-[#EAD7BB] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-white">Contact</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- NAVBAR END -->

    <!-- CONTENT START -->
    <div class="max-w-7xl m-auto p-6 pt-12">
        <!-- <p class="mb-5 text-xl mb-8">Untuk melihat rute dan perkiraan tarif Angkot silahkan klik nomor angkot di bawah ini</p> -->
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
    </div>
    
    <!-- CONTENT END -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const koridor = "<?= $_GET['koridor'] ?>";

        $('#koridor_angkot').text(koridor)

        $.getJSON('../data/lintasan.json', function(data){
            let lintasan = data[koridor];
            let jumlahWilayah = lintasan.length - 1;
            $('#total_wilayah').text(jumlahWilayah);
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
    </script>

</body>
</html>