<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAngkot</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">   -->
    
    <?php include_once 'layouts/head.php'; ?>
</head>
<body class="font-sans">
    <!-- NAVBAR START -->
    <?php include_once 'layouts/navbar.php'; ?>
    <!-- NAVBAR END -->

    <!-- CONTENT START -->
    <div class="max-w-7xl m-auto pt-12 px-4 pt-[116px]">
        <!-- <p class="mb-5 text-xl mb-8">Untuk melihat rute dan perkiraan tarif Angkot silahkan klik nomor angkot di bawah ini</p> -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-4">
                <!-- <h2 class="font-bold text-gray-700 mb-4">Pilih Rute</h2> -->
                <p class="mb-4">Pilih rute untuk melihat detail rute angkot</p>
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
            <div class="col-span-12 md:col-span-8">
                <h2 class="font-bold text-gray-700 mb-4">Peta Seluruh Rute Angkutan Kota Bogor</h2>
                <div id="map" class="w-100 h-[calc(100vh-196px)] z-10 outline-none rounded-md"></div>
            </div>
            
        </div>
    </div>
    
    <!-- CONTENT END -->

    <!-- FOOTER START -->
    <?php include_once 'layouts/footer.php'; ?>
    <!-- FOOTER END -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const map = L.map('map', {
            center: [-6.596645, 106.797313],
            zoom: 14,
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: 'bottomright'
            },
            forceSeparateButton: true,
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

        fetchData().then(data => {

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
                        <div class="flex items-center px-2 py-0.5 bg-white rounded border-b-4 border-b-[${colorStyle[koridor]}]">
                            <img src="assets/vector_angkot.png" class="me-2 w-4" alt="icon angkot">
                            <h3 class="m-0 font-bold text-[#4983C7]">${koridor}</h3>
                        </div>
                        <div class="flex justify-end items-center flex-grow text-white">
                            <p class="m-0 me-4 fs-4 align-middle lh-1 hidden md:block">Lihat rute</p>
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

        // map.locate({watch: false});

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
            // alert(e.message);

            console.warn('Gagal mendapatkan lokasi.')

            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                var latlng = [lat, lng];
                var radius = 0;

                L.marker(latlng).addTo(map)
                    .bindPopup("Lokasi Anda saat ini").openPopup();

                L.circle(latlng, radius).addTo(map);
            });
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
                findRoutes(pointA, pointB);
                // L.Routing.control({
                //     waypoints: [
                //         L.latLng(pointA),
                //         L.latLng(pointB)
                //     ],
                //     fitSelectedRoutes: true,
                //     draggableWaypoints: false,
                //     routeWhileDragging: false,
                //     lineOptions: {
                //         addWaypoints: false,
                //     }
                // }).addTo(map);
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

            var routeInfo = routes.map(feature => feature.properties.koridor).join(", ");
            alert("Untuk menuju titik tujuan dari titik berangkat yang dipilih, Anda dapat menaiki angkot dengan nomor: " + routeInfo);

            var routeLayer = L.geoJson(routes, {
                style: function(feature) {
                    return {
                        color: colorStyle[feature.properties.koridor],
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