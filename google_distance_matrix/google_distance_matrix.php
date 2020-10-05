<?php
class DistanceMatrix
{
    private $apiKey = "";

    function getDistance($origin, $destination)
    {
        if($origin == "" ||$destination ==""){
            $distance = ""; 
        }
        else{
            $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($origin).'&destinations='.urlencode($destination).'&key='.$this->apiKey);
            $distance_arr = json_decode($distance_data);
             
             foreach($distance_arr->rows[0]->elements as $x) {
                $distance =  $x->distance->text;
                }
                //print_r($distance_arr);  
                //echo "distance=".$distance;
        }
        return $distance;
    }

    function getDestinationAddress($origin, $destination)
    {
        if($origin == "" ||$destination ==""){
            $distance = ""; 
        }
        else{
            $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins='.urlencode($origin).'&destinations='.urlencode($destination).'&key='.$this->apiKey);
            $distance_arr = json_decode($distance_data);

             //$orgin_address = $distance_arr->origin_addresses[0];
             $destination_address = $distance_arr->destination_addresses[0];
        }
        return $destination_address;
    }
}
?>