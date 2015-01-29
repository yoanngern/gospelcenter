var geocoder;
var map;
var marker = null;

$(document).ready(function () {

    initialize();

    $("#gospelcenter_locationbundle_location_address1, #gospelcenter_locationbundle_location_address2, #gospelcenter_locationbundle_location_postalCode, #gospelcenter_locationbundle_location_city, #gospelcenter_locationbundle_location_country").on("input", function () {
        codeAddress();

    });


    if ($("#gospelcenter_locationbundle_location_latitude").val() !== "" &&
        $("#gospelcenter_locationbundle_location_longitude").val() !== "") {

        var latlng = new google.maps.LatLng($("#gospelcenter_locationbundle_location_latitude").val(), $("#gospelcenter_locationbundle_location_longitude").val());

        marker = new google.maps.Marker({
            map: map,
            position: latlng,
            draggable: true
        });

        setLatLng(marker.getPosition().k, marker.getPosition().D);

    } else {
        codeAddress();
    }


});


function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(46.5701302, 6.82015709999996);
    var mapOptions = {
        zoom: 8,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
}

function codeAddress() {
    var address = $("#gospelcenter_locationbundle_location_address1").val() + " "
        + $("#gospelcenter_locationbundle_location_address2").val() + " "
        + $("#gospelcenter_locationbundle_location_postalCode").val() + " "
        + $("#gospelcenter_locationbundle_location_city").val() + " "
        + $("#gospelcenter_locationbundle_location_country").val() + " ";
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {

            map.setCenter(results[0].geometry.location);


            if (marker === null) {
                marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    draggable: true
                });

                google.maps.event.addListener(marker, 'drag', function () {
                    setLatLng(marker.getPosition().k, marker.getPosition().D);
                });
            }

            marker.setMap(map);
            marker.setPosition(results[0].geometry.location);

            setLatLng(marker.position.k, marker.position.D);

        } else {

        }
    });
}

function setLatLng(lat, lng) {

    $('input[data-geo="lat"]').val(lat);
    $('input[data-geo="long"]').val(lng);

    $('div#geo-data div.lat').text("Lat. " + lat);
    $('div#geo-data div.long').text("Long. " + lng);

}





