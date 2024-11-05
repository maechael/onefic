<?php
/* @var $this yii\web\View */
?>
<h1>MAP<h1>
        <style>
            #map {
                height: 650px;
                width: 100%;
            }
        </style>



        <body>
            <div id="map"></div>
            <script>
                function initMap() {
                    //map option
                    var options = { 
                        zoom: 6,
                        center: {
                            lat: 12.879721,
                            lng: 121.774017
                        }
                    }
                    //new map
                    var map = new
                    google.maps.Map(document.getElementById('map'), options);

                    // //add marker
                    // var marker = new google.maps.Marker({
                    //     position: {
                    //         lat: 6.900556019669149,
                    //         lng: 122.08335044131792
                    //     },
                    //     map: map
                    // });
                    // var infoWindow = new google.maps.InfoWindow({
                    //     content: 'FIC REGION 9'
                    // });
                    // marker.addListner('click', function() {
                    //     infoWindow.open(map, marker);

                    // })


                    //region10
                    addMarker({
                        lat: 8.485066313265502,
                        lng: 124.65673825482072
                    })
                    //region 9
                    addMarker({
                        lat: 6.900556019669149,
                        lng: 122.08335044131792
                    })

                    function addMarker(coords) {
                        var marker = new google.maps.Marker({
                            position: coords,
                            map: map,
                        });


                    }


                }
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyu32__RveppSiotUc54Cn_1hEkjCbWws&callback=initMap&v=weekly" defer></script>
        </body>