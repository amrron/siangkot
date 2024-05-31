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
    <script src="scripts/leaflet.geometryutil.js"></script>
    <script src="scripts/leaflet-arrowheads.js"></script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Style -->
    <link rel="stylesheet" href="style.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'Montserrat', 'Roboto'],
                    },
                },
            },
            darkMode: 'false',
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
                <img src="assets/logo_kotabogor.png" alt="logo_kotabogor">
            </div>
        </div>
    </header> -->
    <nav class="border-gray-200 bg-[#4983C7]">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
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
    <div class="max-w-7xl m-auto pt-12 px-4">
        <!-- <p class="mb-5 text-xl mb-8">Untuk melihat rute dan perkiraan tarif Angkot silahkan klik nomor angkot di bawah ini</p> -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4">
                <h2 class="font-bold text-gray-700 mb-4">Pilih Trayek untuk melihat rute</h2>
                <div id="koridors" class="flex flex-col gap-4 no-scrollbar overflow-y-scroll h-[calc(100vh-196px)]">
                    <a href="#" class="text-decoration-none">
                        <div id="rute_btn" class="p-4 flex justify-between rounded-md bg-[#AEC8E6]">
                            <div class="flex items-center">
                                <img src="assets/vector_angkot.png" class="me-3" alt="icon angkot">
                                <h3 class="m-0 font-medium text-white">01</h3>
                            </div>
                            <div class="flex justify-end items-center flex-grow text-white">
                                <p class="m-0 me-4 fs-4 align-middle lh-1">Lihat rute</p>
                                <img src="assets/arrow.png" class="h-5" alt="arrow" >
                            </div>
                        </div> 
                    </a>      
                </div>
            </div>
            <div class="col-span-8">
                <h2 class="font-bold text-gray-700 mb-4">Peta gabungan seluruh rute Angkutan kota Bogor</h2>
                <div id="map" class="w-100 h-[calc(100vh-196px)]"></div>
            </div>
            
        </div>
    </div>
    
    <!-- CONTENT END -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <div id="map"></div>
    <script>
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

        async function fetchData() {
            try {
                const res = await fetch("data/rute.geojson");
                const data = await res.json();
                ruteData = data;
                return data;
            } catch (error) {
                console.error('Error fetching the GeoJSON data:', error);
                throw error;
            }
        }

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let koridorList = [];

        fetch("data/rute.geojson").then(res => res.json()).then(data => {

            data.features.forEach(feature => {
                
                if (!koridorList.includes(feature.properties.koridor)) {
                    koridorList.push(feature.properties.koridor);
                }
            });

            $('#koridors').empty();

            koridorList.sort();
            
            koridorList.forEach(koridor => {
                $('#koridors').append(`
                <a href="rute/${koridor}" class="text-decoration-none">
                    <div id="rute_btn" class="p-4 flex justify-between rounded-md bg-[#AEC8E6]">
                        <div class="flex items-center">
                            <img src="assets/vector_angkot.png" class="me-3" alt="icon angkot">
                            <h3 class="m-0 font-bold text-[#4983C7]">${koridor}</h3>
                        </div>
                        <div class="flex justify-end items-center flex-grow text-white">
                            <p class="m-0 me-4 fs-4 align-middle lh-1">Lihat rute</p>
                            <img src="assets/arrow.png" class="h-5" alt="arrow" >
                        </div>
                    </div> 
                </a>  
                `);
            })

            // add GeoJSON layer to the map once the file is loaded
            var geoJsonLayer = L.geoJson(data, {
                style: function(feature) {
                    return {
                        color: colorStyle[feature.properties.koridor],
                        // weight: 1
                    } 
                },
                onEachFeature: function(feature, layer) {
                    layer.on('mouseover', function(e) {
                        var popupContent = feature.properties.koridor + " " + feature.properties.asalTujuan;
                        var popup = L.popup()
                            .setLatLng(e.latlng)
                            .setContent(popupContent)
                            .openOn(map);

                            layer.on('mouseout', function(e) {
                                map.closePopup(popup);
                            });
                    });

                    // layer.on('mouseout', function(e) {
                    //     e.target.closePopup();
                    // });

                    layer.on('click', function(e) {
                        var koridor = feature.properties.koridor;
                        window.location.href = `/rute/${koridor}`;
                    });
                },
                pointToLayer: function (feature, latlng) {
                    return L.circleMarker(latlng, geojsonMarkerOptions);
                }
            }).addTo(map);

            if (geoJsonLayer.getLayers().length > 0) {
                var bounds = geoJsonLayer.getBounds();
                map.fitBounds(bounds);
            }

        });

        map.locate({watch: false});

        async function onLocationFound(e) {
            var radius = 50;

            L.marker(e.latlng).addTo(map)
                .bindPopup("Lokasi Anda saat ini").openPopup();

            L.circle(e.latlng, radius).addTo(map);

            // let ruteData = await fetchData();

            // // Temukan titik terdekat pada rute angkot
            // if (ruteData) {
            //     let userLocation = [e.latlng.lng, e.latlng.lat];
            //     let nearestPoint = findNearestRoute(userLocation, ruteData);

            //     if (nearestPoint) {
            //         nearestPoint.forEach( point => {
            //             L.Routing.control({
            //                 waypoints: [
            //                     L.latLng(e.latlng.lat, e.latlng.lng),
            //                     L.latLng(point[1], point[0])
            //                 ],
            //                 fitSelectedRoutes: true,
            //                 draggableWaypoints: false,
            //                 routeWhileDragging: false,
            //                 lineOptions: {
            //                     addWaypoints: false,
            //                 }
            //             }).addTo(map);
            //         })
            //     }
            // }
        }

        function findNearestRoute(userLocation, routes) {
            let nearestPoint = [];
            let shortestDistance = Infinity;

            routes.features.forEach(function(route) {
                route.geometry.coordinates.forEach(function(lineString) {
                    var line = turf.lineString(lineString);
                    var nearest = turf.nearestPointOnLine(line, userLocation, { units: 'kilometers' });
                    var distance = turf.distance(userLocation, nearest, { units: 'kilometers' });
                    if (distance < shortestDistance) {
                        shortestDistance = distance;
                        nearestPoint.push(nearest.geometry.coordinates);
                    }
                });
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

        var pointA, pointB;
        var markerA, markerB;

        map.on('click', function(e) {
            if (!pointA) {
                pointA = e.latlng;
                markerA = L.marker(pointA).addTo(map).bindPopup("Titik A").openPopup();
            } else if (!pointB) {
                pointB = e.latlng;
                markerB = L.marker(pointB).addTo(map).bindPopup("Titik B").openPopup();
                
                // Setelah kedua titik dipilih, cari rute
                // findRoutes(pointA, pointB);
                L.Routing.control({
                    waypoints: [
                        L.latLng(pointA),
                        L.latLng(pointB)
                    ],
                    fitSelectedRoutes: true,
                    draggableWaypoints: false,
                    routeWhileDragging: false,
                    lineOptions: {
                        addWaypoints: false,
                    }
                }).addTo(map);
            }
        });

        async function findRoutes(pointA, pointB) {
            var availableRoutes = [];

            let data = await fetchData();

            data.features.forEach(function(feature) {
                if (feature.geometry.type === "MultiLineString") {
                    var isNearA = false;
                    var isNearB = false;
                    var bufferDistance = 0.5;
                    
                    feature.geometry.coordinates.forEach(function(lineString) {
                        var line = turf.lineString(lineString);
                        
                        // Buat buffer di sekitar garis
                        var buffered = turf.buffer(line, bufferDistance, { units: 'kilometers' });

                        // Periksa apakah titik berada dalam buffer
                        if (turf.booleanPointInPolygon(turf.point([pointA.lng, pointA.lat]), buffered)) {
                            isNearA = true;
                        }
                        if (turf.booleanPointInPolygon(turf.point([pointB.lng, pointB.lat]), buffered)) {
                            isNearB = true;
                        }

                    });
                    
                    if (isNearA && isNearB) {
                        availableRoutes.push(feature);
                    }
                }
            });

            displayRoutes(availableRoutes);
        }

        function displayRoutes(routes) {
            if (routes.length === 0) {
                alert("Tidak ada rute yang tersedia antara titik A dan titik B.");
                return;
            }

            if (routes.length == 1) {
                console.log("Utuk menuju titik tujuan dari titik berangkat yang dipilih, anda dapat menaiki angkot dengan nomer " + routes[0].properties.koridor);
            }

            else {
                console.log("Utuk menuju titik tujuan dari titik berangkat yang dipilih, anda dapat menaiki angkot dengan nomer " + routes.forEach(feature => {
                    feature.properties.koridor + ",";
                }));
            }

            console.log(routes);

            var routeLayer = L.geoJson(routes, {
                style: function(feature) {
                    return {
                        color: '#eb4034'
                        // color: colorStyle[feature.properties.koridor],
                        // weight: 1
                    }
                },
                onEachFeature: function(feature, layer) {
                    layer.bindPopup(feature.properties.koridor + " " + feature.properties.asalTujuan);
                }
            }).addTo(map);

            // Atur zoom fit ke rute yang ditemukan
            map.fitBounds(routeLayer.getBounds());
        }
    </script>
</body>
</html>