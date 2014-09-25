/**
 * @file   map.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Components
 *
 * @type {Object}
 */
Barpedia.Components = Barpedia.Components || {};

/**
 * Map
 *
 * @type {Object}
 */
Barpedia.Components.Map = (function () {

    'use strict';
    var

        /**
         * Styles for the map
         *
         * @type  {Array}
         */
        styleGray = [{
            "featureType": "water",
            "elementType": "all",
            "stylers": [
                { "hue": "#bbbbbb"   },
                { "saturation": -100 },
                { "lightness": -4    },
                { "visibility": "on" }
            ]
        }, {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [
                { "hue": "#999999"   },
                { "saturation": -100 },
                { "lightness": -33   },
                { "visibility": "on" }
            ]
        }, {
            "featureType": "road",
            "elementType": "all",
            "stylers": [
                { "hue": "#999999"   },
                { "saturation": -100 },
                { "lightness": -6    },
                { "visibility": "on" }
            ]
        }, {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
                { "hue": "#aaaaaa"   },
                { "saturation": -100 },
                { "lightness": -15   },
                { "visibility": "on" }
            ]
        }],

        /**
         * Loads the map with Google Maps API.
         *
         * @return {void}
         */
        loadMap = function (map_canvas, callback) {

            if (map_canvas === undefined) map_canvas = $('#map_canvas');

            var i,
                marker,
                listener,
                latitude,
                longitude,
                locations     = [],
                infowindow    = new google.maps.InfoWindow(),
                bounds        = new google.maps.LatLngBounds(),
                markers       = map_canvas.siblings('#markers').find('span'),
                enable_scroll = map_canvas.data('scroll')    === true,
                enable_drag   = map_canvas.data('draggable') === true,
                options;

            // Get markers from #markers container
            for (i = 0; i < markers.length; i++) {
                marker = markers[i];

                locations.push({
                    id :   marker.id,
                    lat:   marker.dataset.lat,
                    lng:   marker.dataset.lng,
                    title: marker.dataset.title
                });
            }

            // Setting options
            // If scroll is enabled, set default options
            latitude  = parseFloat(locations[0].lat) + 0.0004;
            longitude = locations[0].lng;

            if (enable_scroll) {

                options = {
                    streetViewControl: true,
                    scrollwheel      : true,
                    navigationControl: true,
                    mapTypeControl   : true,
                    scaleControl     : true,
                    draggable        : true,
                    disableDefaultUI : false,

                    center: new google.maps.LatLng(latitude, longitude),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    //styles: styleGray
                };

            // Disabling all control options
            } else {

                options = {
                    scrollwheel      : false,
                    navigationControl: false,
                    mapTypeControl   : false,
                    scaleControl     : false,
                    draggable        : false,
                    disableDefaultUI : true,

                    center: new google.maps.LatLng(latitude, longitude),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    //styles: styleGray
                };
            }

            // Loading Google Map on div #map_canvas
            window.map = new google.maps.Map(
                document.getElementById(map_canvas.attr('id')),
                options
            );

            // For each marker from locations, pin it on the map
            for (i = 0; i < locations.length; i++) {

                latitude  = locations[i].lat;
                longitude = locations[i].lng;

                // Create new marker
                marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(latitude, longitude),
                    icon: '/assets/images/icons/pin.png',

                    // Drag
                    draggable: enable_drag,
                    animation: google.maps.Animation.DROP
                });

                // Drag/Drop pin marker, if is enable
                if( enable_drag ) {
                    google.maps.event.addListener(marker, 'dragend', dragendCallback(locations[i].id));
                }

                // Extends bounds to contain the given point (marker position)
                bounds.extend(marker.position);

                // When click on the pin marker, open popup
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i].title);
                        infowindow.open(map, marker);
                    };
                })(marker, i));
            }

            // Sets the viewport to contain the given bounds
            if (locations.length > 1) {
                map.fitBounds(bounds);
            }

            // Initial zoom
            // This event is fired when the map becomes idle after panning or zooming
            listener = google.maps.event.addListener(map, 'idle', function () {
                var zoom  = map_canvas.data('zoom'),
                    value = (zoom === undefined) ? 16 : zoom;

                // Zooming
                map.setZoom(value);

                // Remove listener to ensure that we will call it just once
                google.maps.event.removeListener(listener);
            });

            // Callback
            if (typeof callback == "function") {
                callback(true)
            };
        },

        clickCallback = function (marker, i) {
            console.log(marker, i);

            /*if (marker.getAnimation() != null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }*/
        },

        /**
         * On drag a pin marker, update the relative <span> marker in #markers
         * @param  {[type]} id [description]
         * @return {[type]}    [description]
         */
        dragendCallback = function (id) {
            return function (event) {

                var marker = document.querySelector('#' + id),
                    lat    = event.latLng.k,
                    lon    = (event.latLng.A === undefined)
                        ? event.latLng.B
                        : event.latLng.A;

                marker.dataset.lat = lat;
                marker.dataset.lng = lon;

                /**
                 * Trigger. Fire event eventMarkerMove whatever
                 * the pin marker has its coordinates changed
                 */
                var eventOnMarkerMove = new CustomEvent('eventMarkerMove', {
                    detail: '#' + id
                });

                window.document.getElementById('map_canvas').dispatchEvent(eventOnMarkerMove);
            }
        },

        /**
         * Fire some internal event
         * @return {string} Id of the pinmarker which we will get the coordinates
         */
        trigger = {

            eventMarkerMove: function (target, event) {
                // Default for eventOnMarkerMove event
                var eventOnMarkerMove = new CustomEvent('eventMarkerMove', {
                        detail: '#' + target
                });

                window.document.getElementById('map_canvas').dispatchEvent(eventOnMarkerMove);

                return true;
            }
        },

        /**
         * Expande ou contrai o mapa da página de Bares.
         *
         * {{AQUI}} Must smooth the map resize and remove the glitches
         * when loading it.
         *
         * @return {void}
         */
        showMap = (function () {
            var show_map      = $('#show-map'),
                show_map_text = $('#show-map-text'),
                hide_map_text = $('#hide-map-text'),
                map_wrap      = $('.map-wrap'),
                map           = $('#map_canvas');

            show_map.on('click', function () {
                var is_expanded = map.hasClass('map-lg');

                // Hiding map
                if (is_expanded) {

                    // Disables scroll as zoom
                    map.data('scroll', false);

                    // Reducing map
                    map.removeClass('map-lg');

                    // Reducing to the original height
                    map.animate({ height: '94px'}, 400, function () {
                        loadMap(map);
                    });
                    map_wrap.animate( { height: '94px'}, 400);

                    // Changing texts
                    hide_map_text.addClass('hidden');
                    show_map_text.removeClass('hidden');

                // Showing map
                } else {

                    // Enable scroll as zoom
                    map.data('scroll', true);

                    // Expanding map
                    map.addClass('map-lg');

                    // Using viewport value to expand the map
                    var h = Math.max(
                            document.documentElement.clientHeight,
                            window.innerHeight || 0
                        ),
                        // Header height
                        header_h = 213,
                        // Viewport proportion
                        viewport = (1 - 213/h) * 100 + 'vh';

                    // Map size
                    map.css({ height: viewport });

                    // Wrap animation after map loads
                    loadMap(map, function (response) {
                        map_wrap.animate({ height: viewport}, 400);
                    });

                    // Changing texts
                    hide_map_text.removeClass('hidden');
                    show_map_text.addClass('hidden');

                }
            });
        }()),

        geocoder,

        /**
         * [googleMapsInitialize description]
         *
         * @return {void}
         */
        googleMapsInitialize = function () {
            var map_canvas = $('#map_canvas'),
                title = map_canvas.data('title'),
                lat = map_canvas.data('latitude'),
                lng = map_canvas.data('longitude'),
                latLng = new google.maps.LatLng(lat, lng),
                map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 15,
                    center: latLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }),
                marker = new google.maps.Marker({
                    position: latLng,
                    title: title,
                    map: map,
                    draggable: true
                });

            geocoder = new google.maps.Geocoder();

            // Update current position info.
            updateMarkerPosition(latLng);
            geocodePosition(latLng);

            // Add dragging event listeners.
            google.maps.event.addListener(marker, 'dragstart', function () {
                updateMarkerAddress('Obtendo endereço...');
            });

            google.maps.event.addListener(marker, 'drag', function () {
                updateMarkerPosition(marker.getPosition());
            });

            google.maps.event.addListener(marker, 'dragend', function () {
                geocodePosition(marker.getPosition());
            });
        },

        /**
         * [geocodePosition description]
         *
         * @param  {void} position [description]
         * @return {void}
         */
        geocodePosition = function (position) {
            geocoder.geocode({
                latLng: position
            }, function (response) {
                if (response && response.length > 0) {
                    updateMarkerAddress(response[0]);
                } else {
                    updateMarkerAddress('Impossível determinar o endereço deste local.');
                }
            });
        },

        /**
         * [getAddress description]
         * @return {[type]} [description]
         */
        getAddress = function (coord, callback) {
            var geocoder = new google.maps.Geocoder(),
                position = new google.maps.LatLng(coord.lat, coord.lon),
                has_address = false,
                response = [],
                data     = [],
                response = {
                    street: {
                        value : "",
                        types : ["street_address", "route", "intersection"]
                    },
                    district: {
                        value : "",
                        types : ["administrative_area_level_3", "sublocality", "neighborhood"]
                    },
                    city: {
                        value : "",
                        types : ["locality", "administrative_area_level_2"]
                    },
                    region: {
                        value : "",
                        types : ["administrative_area_level_1"]
                    },
                    country: {
                        value : "",
                        types : ["country"]
                    },
                    zip: {
                        value : "",
                        types : ["postal_code"]
                    },
                    street_number: {
                        value : "",
                        types : ["street_number"]
                    },
                    // formatted { value: ""} // Will be added later
                },
                types        = [],
                has_longname = false,
                found        = false;

            geocoder.geocode({ latLng: position }, function (dataset, status) {

                // Check if dataset returned street_address (most complete address) field.
                // If not get the last.
                for (var i = 0; i < dataset.length; i++) {
                    data        = dataset[i];
                    has_address = data.types.indexOf("street_address") !== -1;

                    // Finish search
                    if (has_address) break;
                };

                // Formatting response
                $.each(response, function(id, field) {
                    types = field.types;

                    // For each field from data,
                    // check if has a properly datatype for response
                    for (var i = 0; i < data.address_components.length; i++) {

                        // Organizing response by verifying the
                        // data.address_components[i].types and
                        // putting in their respectives fields
                        for (var j = 0; j < field.types.length; j++) {

                            // If current data.address_component[i]
                            // has a type that matches with field.types
                            if(data.address_components[i].types.indexOf(field.types[j]) !== -1) {

                                // Preference for long_name field.
                                // If not, use the short one.
                                has_longname = data.address_components[i].long_name !== undefined;

                                // Copying value
                                response[id].value = (has_longname)
                                    ? data.address_components[i].long_name
                                    : data.address_components[i].short_name;

                                // Signing boolean
                                found = true;

                                // Finish loop
                                break;
                            }
                        };

                        // If found some data, we dont need to look forward.
                        // Finish loop (get just the first element) and reset
                        // boolean
                        if(found) {
                            found = false;
                            break;
                        }
                    };
                });

                // Adding field with complete address (formatted address)
                response.formatted = {
                    value : data.formatted_address
                };

                // Callback
                if (typeof callback == "function") callback(response, status);
            });
        },

        /**
         * [updateMarkerPosition description]
         *
         * @param  {void} latLng [description]
         * @return {void}
         */
        updateMarkerPosition = function (latLng) {
            $('#deci_latitude_bar').val(latLng.lat());
            $('#deci_longitude_bar').val(latLng.lng());
        },

        /**
         * [updateMarkerAddress description]
         *
         * @param  {void} str [description]
         * @return {void}
         */
        updateMarkerAddress = function (response) {
            var address = response.address_components,
                cep = $('#char_zip_bar'),
                numero,
                endereco = $('#char_endereco_bar');

            if (response.address_components !== undefined) {

                address = [
                    response.address_components[1].long_name + ', ',
                    response.address_components[0].long_name + ', ',
                    response.address_components[2].long_name
                ].join('');

                endereco.val(address);

                numero = response.address_components.slice(-1)[0].long_name;
                cep.val((numero.length < 6) ? numero + '-000' : numero);
            } else {
                endereco.val('');
                cep.val('');
            }
        };

    return {
        loadMap: loadMap,
        showMap: showMap,
        getAddress: getAddress,
        trigger: trigger
    };

}());
