
var map;
var infowindow;
var initialLocation;
var bounds;
function callajax(initialLocation) {
    $.ajax({
        type: "POST",
        url: "/app_dev.php/gui/places",
        data: {
            "lat": initialLocation.lat,
            "lng": initialLocation.lng,
        },
        async: false,
        dataType: "json",
        success: function (response) {
            response.forEach(function (bar) {
                var myLatLng = {lat: bar.coordinates.latitude, lng: bar.coordinates.longitude};
                var name = bar.name;
                var address = bar.address;
                createMarker(myLatLng, name, address);
            });
        }
    });
}

function initMap() {
    bounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15
    });
    // Try W3C Geolocation (Preferred)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(initialLocation);
            callajax(initialLocation);
        }, function () {
            initialLocation = {lat: 54.348545, lng: 18.653226};
            map.setCenter(initialLocation);
            callajax(initialLocation);
        });
    }
// Browser doesn't support Geolocation
    else {
        initialLocation = {lat: 54.348545, lng: 18.653226};
        map.setCenter(initialLocation);
        callajax(initialLocation);
    }

    infowindow = new google.maps.InfoWindow();
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });
    searchBox.addListener('places_changed', function () {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }

        // For each place, get the icon, name and location.
        bounds = new google.maps.LatLngBounds();
        places.forEach(function (place) {

            map.setCenter(place.geometry.location);
            callajax(place.geometry.location);
        });
    });
}

function createMarker(myLatLng, name, address) {

    var marker = new google.maps.Marker({
        map: map,
        position: myLatLng
    });
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.setContent(name);
        infowindow.open(map, this);
    });
    bounds.extend(marker.getPosition());
    map.fitBounds(bounds);
}


