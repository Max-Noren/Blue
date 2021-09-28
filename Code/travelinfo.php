<?php

#____________________
#Function that calculates and returnes the distance and time given coordinates for a start and end position and transportation mode.
#Coordinates must be input like this: '11.966954,57.706818' (the format for the coordinates are: long,lat) 
#Different modes of transportations are: 'foot-walking', 'driving-car', 'wheelchair','cyckling-road', 'cykling-regular' or 'cykling-electric'.
#Returns result in an array, first array element[0] is distance in km, the second array element[1] is time in minutes for the route.  
#____________________
function getDistanceAndTime($coordinatesFrom, $coordinatesTo, $transportationMode){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/" . $transportationMode );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE); 
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[' . $coordinatesFrom . '],[' . $coordinatesTo . ']]}');
#--this is a test with set coordinates---- 
#curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[11.966954,57.706818],[11.938598,57.705213]]}');

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
  "Authorization: 5b3ce3597851110001cf6248f012565337bb4301a0f7835ca1967d1e",
  "Content-Type: application/json; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);

# -------this print out ALL response stuff in JSON!!----------
#var_dump($response);

$data = json_decode($response);

$dist = $data->routes[0]->summary->distance; //this is the distance
$duration = $data->routes[0]->summary->duration; //this is the time in seconds

$time = round($duration/60);
$distance = number_format($dist/1000, 1, '.', ',');
return array($distance, $time);
}
# TODO testvariabler + utskrifter - att ta bort när vi är klara
$transportationMode_walk = 'foot-walking';
$transportationMode_car = 'driving-car';
$transportationMode_wheelchair = 'wheelchair';
$tranportationMode_cycling ='cycling-regular';
$tranportationMode_cyclingElectric ='cycling-electric';


#$coordinatesFrom = '11.966954,57.706818';
#$coordinatesTo = '11.938598,57.705213';
#echo getDistanceAndTime($coordinatesFrom, $coordinatesTo, $transportationMode_wheelchair)[0];
#echo '<br>';
#echo getDistanceAndTime($coordinatesFrom, $coordinatesTo, $transportationMode_wheelchair)[1];

?>
