<html>

<head>
    <style>
        #map-layer {

            min-height: 430px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="map-layer"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var markers = [];
        var order_lat = '23.0234892';
        var order_lon = '72.5075943';
        var map;
        var user_latitude = '23.0234867';
        var user_longitude = '72.5075947';

        $(function() {
            initMap();
        });
        window.initMap = function() {
            markers = [{
                'latitude': parseFloat(order_lat),
                'longitude': parseFloat(order_lon),
                'timestamp': 'Delivery Boy',

            }, {
                'latitude': parseFloat(user_latitude),
                'longitude': parseFloat(user_longitude),
                'timestamp': 'Destination',

            }];
            var mapOptions = {
                center: new google.maps.LatLng(markers[0].latitude, markers[0].longitude),
                zoom: 22,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-layer"), mapOptions);
            var infoWindow = new google.maps.InfoWindow();
            var lat_lng = new Array();
            var latlngbounds = new google.maps.LatLngBounds();
            for (i = 0; i < markers.length; i++) {
                var data = markers[i]
                var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
                lat_lng.push(myLatlng);
                if (data.timestamp == 'Delivery Boy') {
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        icon: {
                            url: "<?php echo base_url() . 'assets/img/Rider_Dark.png'; ?>",
                            scaledSize: new google.maps.Size(22, 48)
                        },
                        title: 'timestamp'
                    });
                } else {
                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        icon: {
                            url: "<?php echo base_url() . 'assets/img/destination.png'; ?>",
                            scaledSize: new google.maps.Size(10, 10)
                        },
                        title: 'timestamp'
                    });
                }

                latlngbounds.extend(marker.position);
                (function(marker, data) {
                    google.maps.event.addListener(marker, "click", function(e) {
                        infoWindow.setContent(data.timestamp);
                        infoWindow.open(map, marker);
                    });
                })(marker, data);
            }
            map.setCenter(latlngbounds.getCenter());
            map.fitBounds(latlngbounds);

            //***********ROUTING****************/
            //Initialize the Direction Service
            var service = new google.maps.DirectionsService();
            //Loop and Draw Path Route between the Points on MAP
            for (var i = 0; i < lat_lng.length; i++) {
                if ((i + 1) < lat_lng.length) {
                    var src = lat_lng[i];
                    var des = lat_lng[i + 1];
                    // path.push(src);
                    service.route({
                        origin: src,
                        destination: des,
                        travelMode: google.maps.DirectionsTravelMode.WALKING
                    }, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            //Initialize the Path Array
                            var path = new google.maps.MVCArray();
                            //Set the Path Stroke Color
                            var poly = new google.maps.Polyline({
                                map: map,
                                strokeColor: '#009243',
                                strokeOpacity: 1.0,
                                strokeWeight: 2
                            });
                            poly.setPath(path);
                            for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                                path.push(result.routes[0].overview_path[i]);
                            }

                            var distance = 0;
                            for (var i = 0; i < path.getLength() - 1; i++) {

                                distance += google.maps.geometry.spherical.computeDistanceBetween(path.getAt(i),
                                    path.getAt(i + 1));

                                // console.log(distance);
                            }

                        }
                    });
                }
            }
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap">
    </script>
    
<!-- For Socket implitation Start -->
    <script src="<?php echo base_url(); ?>node_modules/socket.io-client/dist/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/push.min.js"></script>
    <script src="<?php echo base_url(); ?>serviceWorker.js"></script>
    <script>
        var url = window.location.origin;
        var socket = io.connect(url + ':<?php echo SOCKETIO_PORT; ?>');  //Socket Port : 5000
        $(document).ready(function() {
            socket.on('track_live_location', function(data) {
                   order_lat = data.lat;
                   order_lon = data.lng;
                   initMap();
            });
        });
    </script>
<!--      For Socket implitation End  -->
</body>

</html>
