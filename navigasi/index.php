<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAngkot</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">   -->
    
    <?php include_once '../layouts/head.php'; ?>
</head>
<body class="font-sans">
    <!-- NAVBAR START -->
    <?php include_once '../layouts/navbar.php'; ?>
    <!-- NAVBAR END -->

    <!-- CONTENT START -->
    <div class="max-w-7xl m-auto pt-12 px-4 pt-[116px]">
        <!-- <p class="mb-5 text-xl mb-8">Untuk melihat rute dan perkiraan tarif Angkot silahkan klik nomor angkot di bawah ini</p> -->
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 md:col-span-4">
                <!-- <h2 class="font-bold text-gray-700 mb-4">Pilih Rute</h2> -->
                <p class="mb-4">Pilih titik awal dan destinasi pada peta untuk mencari angkot yang bisa digunakan.</p>
                <div id="koridors" class="flex flex-col gap-4 no-scrollbar overflow-y-scroll">
                    <p class="text-md" id="info"></p>
                    <button class="border rounded-lg p-2.5 " id="starting-point">Pilih titik awal</button>
                    <button class="border rounded-lg p-2.5 " id="current-location">Gunakan lokasi saat ini</button>
                    <button class="border border-red-500 rounded-lg p-2.5 hidden text-red-500" id="batal">Batal</button>
                    <button class="border rounded-lg p-2.5 hidden" id="reset">Reset</button>
                </div>
            </div>
            <div class="col-span-12 md:col-span-8">
                <!-- <h2 class="font-bold text-gray-700 mb-4">Peta Seluruh Rute Angkutan Kota Bogor</h2> -->
                <div id="map" class="w-100 h-[calc(100vh-196px)] z-10 outline-none rounded-md"></div>
            </div>
            
        </div>
    </div>
    
    <!-- CONTENT END -->

    <!-- FOOTER START -->
    <?php include_once '../layouts/footer.php'; ?>
    <!-- FOOTER END -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const map = L.map('map', {
            center: [-6.596645, 106.797313],
            zoom: 14,
            fullscreenControl: true,
            fullscreenControlOptions: {
                position: 'topright'
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
                const res = await fetch("/data/rute.geojson");
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

        var geoJsonLayer;

        function eachFeature(feature, layer) {
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

            // layer.on('click', function(e) {
            //     var koridor = feature.properties.koridor;
            //     window.location.href = `/rute/${koridor}`;
            // });
        }

        fetchData().then(data => {

            data.features.forEach(feature => {
                if (!koridorList.includes(feature.properties.koridor)) {
                    koridorList.push(feature.properties.koridor);
                }
            });

            // add GeoJSON layer to the map once the file is loaded
            geoJsonLayer = L.geoJson(data, {
                style: function(feature) {
                    return {
                        color: colorStyle[feature.properties.koridor],
                        // weight: 1
                    } 
                },
                onEachFeature: eachFeature,
                pointToLayer: function (feature, latlng) {
                    return L.circleMarker(latlng, geojsonMarkerOptions);
                }
            });

            // geoJsonLayer.addTo(map);

            if (geoJsonLayer.getLayers().length > 0) {
                var bounds = geoJsonLayer.getBounds();
                map.fitBounds(bounds);
            }

        });

        function centerRoute() {
            if (geoJsonLayer && geoJsonLayer.getLayers().length > 0) {
                var bounds = geoJsonLayer.getBounds();
                map.fitBounds(bounds);
            }
        }

        // Tambahkan tombol ke peta
        L.Control.CenterRoute = L.Control.extend({
            onAdd: function(map) {
                var div = L.DomUtil.create('div', 'leaflet-control-center-route');
                div.innerHTML = `<svg class="w-[21.5px] h-[21.5px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"/>
                            </svg>
                            `;
                div.style.backgroundColor = 'white';
                div.style.padding = '5px';
                div.style.border = '2px solid rgba(0, 0, 0, 0.2)';
                div.style.borderRadius = '3px';
                div.style.cursor = 'pointer';
                div.onclick = centerRoute;
                return div;
            },
            onRemove: function(map) {
                // Tidak perlu melakukan apa-apa saat kontrol dihapus
            }
        });

        L.control.centerRoute = function(opts) {
            return new L.Control.CenterRoute(opts);
        }

        // Tambahkan kontrol kustom ke peta
        L.control.centerRoute({ position: 'topright' }).addTo(map);

        // map.locate({watch: false});

        async function onLocationFound(e) {
            var radius = 50;

            L.marker(e.latlng).addTo(map)
                .bindPopup("Lokasi Anda saat ini").openPopup();

            L.circle(e.latlng, radius).addTo(map);

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

        // map.on('locationfound', function(e) {
        //     onLocationFound(e);
        // });

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
        var routeLayer;
        var select_start = false;

        $('#starting-point').on('click', function(e) {
            // console.log('pilih titik');
            select_start = true;
            $(this).toggleClass('hidden');
            $('#batal').toggleClass('hidden');
            $('#current-location').toggleClass('hidden');
        });

        $('#current-location').on('click', function(){
            $(this).toggleClass('hidden');
            $('#batal').toggleClass('hidden');
            $('#starting-point').toggleClass('hidden');

            select_start = true;

            navigator.geolocation.getCurrentPosition((position) => {
                pointA = {
                    lat: position.coords.latitude, 
                    lng: position.coords.longitude
                };
                // console.log(pointA);
                markerA = L.marker(pointA).addTo(map).bindPopup("Titik Awal").openPopup();
            });

        });

        $('#reset, #batal').on('click', function(e) {
            pointA = null;
            pointB = null;

            select_start = false;

            $(this).toggleClass('hidden');
            $('#starting-point').toggleClass('hidden');
            $('#current-location').toggleClass('hidden');

            map.removeLayer(markerA);
            map.removeLayer(markerB);
            map.removeLayer(routeLayer);

            // geoJsonLayer.addTo(map);

            $('#info').addClass('hidden');

            map.fitBounds(geoJsonLayer.getBounds());
        });

        map.on('click', function(e){
            if (select_start) {
                if (!pointA) {
                    pointA = e.latlng;
                    // console.log(pointA);
                    markerA = L.marker(pointA).addTo(map).bindPopup("Titik Awal").openPopup();
                } else if (!pointB) {
                    pointB = e.latlng;
                    markerB = L.marker(pointB).addTo(map).bindPopup("Titik Tujuan").openPopup();
                    
                    // Setelah kedua titik dipilih, cari rute
                    findRoutes(pointA, pointB);
                }
            }

        });

        async function findRoutes(pointA, pointB) {
            var routeGraph = {};
            let data = await fetchData();

            // Membangun buffer untuk setiap rute dan graf keterhubungan
            data.features.forEach(function(feature, index) {
                if (feature.geometry.type === "MultiLineString") {
                    var bufferDistance = 0.5; // 500 meter
                    var buffer = turf.buffer(turf.multiLineString(feature.geometry.coordinates), bufferDistance, { units: 'kilometers' });

                    feature.buffer = buffer;
                    feature.index = index;

                    // Menambahkan node ke graf
                    routeGraph[index] = {
                        feature: feature,
                        neighbors: [],
                        distances: {}
                    };
                }
            });

            // Menambahkan edge antar node dalam graf berdasarkan interseksi buffer
            data.features.forEach(function(routeA, i) {
                data.features.forEach(function(routeB, j) {
                    if (i !== j) {
                        if (turf.intersect(routeA.buffer, routeB.buffer)) {
                            routeGraph[routeA.index].neighbors.push(routeB.index);
                            routeGraph[routeB.index].neighbors.push(routeA.index);
                            routeGraph[routeA.index].distances[routeB.index] = 1;
                            routeGraph[routeB.index].distances[routeA.index] = 1;
                        }
                    }
                });
            });

            // Menentukan rute yang berdekatan dengan titik A dan titik B
            var startNodes = data.features.filter(route => turf.booleanPointInPolygon(turf.point([pointA.lng, pointA.lat]), route.buffer)).map(route => route.index);
            var endNodes = data.features.filter(route => turf.booleanPointInPolygon(turf.point([pointB.lng, pointB.lat]), route.buffer)).map(route => route.index);

            // Menambahkan node dummy start dan end ke graf
            var dummyStartNode = "start";
            var dummyEndNode = "end";
            routeGraph[dummyStartNode] = { neighbors: startNodes, distances: {} };
            routeGraph[dummyEndNode] = { neighbors: endNodes, distances: {} };
            startNodes.forEach(node => {
                routeGraph[dummyStartNode].distances[node] = 1;
                routeGraph[node].neighbors.push(dummyStartNode);
                routeGraph[node].distances[dummyStartNode] = 1;
            });
            endNodes.forEach(node => {
                routeGraph[dummyEndNode].distances[node] = 1;
                routeGraph[node].neighbors.push(dummyEndNode);
                routeGraph[node].distances[dummyEndNode] = 1;
            });

            // Menemukan jalur dari dummyStartNode ke dummyEndNode menggunakan algoritme Dijkstra
            var path = dijkstra(routeGraph, dummyStartNode, dummyEndNode);

            if (path) {
                var routeFeatures = path.slice(1, -1).map(index => routeGraph[index].feature);
                displayRoutes(routeFeatures);
            } else {
                displayRoutes([]);
            }
        }

        // Algoritme Dijkstra
        function dijkstra(graph, startNode, endNode) {
            var distances = {};
            var prev = {};
            var pq = new PriorityQueue();

            for (var node in graph) {
                if (node === startNode) {
                    distances[node] = 0;
                    pq.enqueue(node, 0);
                } else {
                    distances[node] = Infinity;
                    pq.enqueue(node, Infinity);
                }
                prev[node] = null;
            }

            while (!pq.isEmpty()) {
                var minNode = pq.dequeue().element;

                if (minNode === endNode) {
                    var path = [];
                    var currentNode = endNode;
                    while (currentNode !== null) {
                        path.push(currentNode);
                        currentNode = prev[currentNode];
                    }
                    return path.reverse();
                }

                graph[minNode].neighbors.forEach(neighbor => {
                    var alt = distances[minNode] + graph[minNode].distances[neighbor];
                    if (alt < distances[neighbor]) {
                        distances[neighbor] = alt;
                        prev[neighbor] = minNode;
                        pq.enqueue(neighbor, alt);
                    }
                });
            }

            return null;
        }

        // Kelas PriorityQueue untuk Algoritme Dijkstra
        class PriorityQueue {
            constructor() {
                this.items = [];
            }

            enqueue(element, priority) {
                var qElement = { element, priority };
                var added = false;
                for (var i = 0; i < this.items.length; i++) {
                    if (this.items[i].priority > qElement.priority) {
                        this.items.splice(i, 1, qElement);
                        added = true;
                        break;
                    }
                }
                if (!added) {
                    this.items.push(qElement);
                }
            }

            dequeue() {
                return this.items.shift();
            }

            isEmpty() {
                return this.items.length === 0;
            }
        }

        function displayRoutes(routes) {
            if (routes.length === 0) {
                // alert("Tidak ada rute yang tersedia antara titik A dan titik B.");
                // return;

                $('#info').removeClass('hidden');
                $('#info').html('Tidak ada rute yang tersedia antara titik awal dan titik tujuan');
            }

            else {
                map.removeLayer(geoJsonLayer);

                var routeInfo = routes.map(feature => feature.properties.koridor).join(", ");
                // alert("Untuk menuju titik tujuan dari titik berangkat yang dipilih, Anda dapat menaiki angkot dengan nomor: " + routeInfo);
            
                $('#info').removeClass('hidden');
                $('#info').html("Untuk menuju titik tujuan dari titik berangkat yang dipilih, Anda dapat menaiki angkot dengan nomor: " + "<span class='font-bold'>" + routeInfo + "</span>");

                routeLayer = L.geoJson(routes, {
                    style: function(feature) {
                        return {
                            color: colorStyle[feature.properties.koridor],
                            // weight: 1
                        } 
                    },
                    onEachFeature: eachFeature,
                }).addTo(map);

                // Atur zoom fit ke rute yang ditemukan
                map.fitBounds(routeLayer.getBounds());
            }

            
            $('#reset, #batal').toggleClass('hidden');
        }
    </script>
</body>
</html>