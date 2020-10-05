<?php
                                   
include_once('google_distance_matrix.php');

$dm = new DistanceMatrix();
$origin = "50, collingwood gardens, brroklands, milton keynes";
$destination = "NE1 1EN";
$distance = $dm->getDistance($origin, $destination);
$address = $dm->getDestinationAddress($origin, $destination);
echo "$distance";
echo "$address";

?>