function initialize() {
var myLatLng = new google.maps.LatLng
 (35.372035, 139.415223);var myOptions = {
  zoom: 18,
  center: myLatLng,
  mapTypeId: google.maps.MapTypeId.SATELLITE
};

var bermudaTriangle;

var map = new google.maps.Map
 (document.getElementById("map_canvas"),
    myOptions);

var triangleCoords = [
    new google.maps.LatLng(35.369566, 139.416746),
    new google.maps.LatLng(35.36966533, 139.4167575),
    new google.maps.LatLng(35.36964839, 139.4153388),
    new google.maps.LatLng(35.36976777, 139.4153676),
    new google.maps.LatLng(35.36976467, 139.4167691),
    new google.maps.LatLng(35.369864, 139.4167806),
    new google.maps.LatLng(35.36988716,139.4153964),
    new google.maps.LatLng(35.37000654, 139.4154252),
    new google.maps.LatLng(35.36996333, 139.4167921),
    new google.maps.LatLng(35.37006267, 139.4168037),
    new google.maps.LatLng(35.37012593, 139.415454),
    new google.maps.LatLng(35.37024532, 139.4154827),
    new google.maps.LatLng(35.370162, 139.4168152),
    new google.maps.LatLng(35.37026133, 139.4168267),
    new google.maps.LatLng(35.3703647, 139.4155115),
    new google.maps.LatLng(35.37048409, 139.4155403),
    new google.maps.LatLng(35.37036066, 139.4168382),
    new google.maps.LatLng(35.37046, 139.4168498),
    new google.maps.LatLng(35.37060347, 139.4155691),
    new google.maps.LatLng(35.37072286, 139.4155979),
    new google.maps.LatLng(35.37055933, 139.4168613),
    new google.maps.LatLng(35.37065866, 139.4168728),
    new google.maps.LatLng(35.37084224, 139.4156267),
    new google.maps.LatLng(35.37096163, 139.4156555),
    new google.maps.LatLng(35.370758, 139.4168844),
    new google.maps.LatLng(35.37085733, 139.4168959),
    new google.maps.LatLng(35.37108102, 139.4156843),
    new google.maps.LatLng(35.3712004, 139.4157131),
    new google.maps.LatLng(35.37095666, 139.4169074)
];

var triangleCoords1 = [

    new google.maps.LatLng(35.369566, 139.416746),
    new google.maps.LatLng(35.370953, 139.416907),
    new google.maps.LatLng(35.371196, 139.415712),
    new google.maps.LatLng(35.369529, 139.41531)

];

// Construct the polygon
bermudaTriangle = new google.maps.Polygon({
  paths: triangleCoords1,
  strokeColor: "#FF0000",
  strokeOpacity: 0.8,
  strokeWeight: 2,
  fillColor: "#FF0000",
  fillOpacity: 0.35
});



bermudaTriangle.setMap(map);
}