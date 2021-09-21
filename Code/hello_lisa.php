<html>
<body>

<h2> This is a map :) </h2>


<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=11.899583817576058%2C57.68861649826122%2C12.009962082956921%2C57.72099206475251&amp;layer=mapnik" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=14/57.7048/11.9548">Visa större karta</a></small> 

   
   <?php
#TEST 1 - LJF
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[11.966954,57.706818],[11.938598,57.705213]]}'); //TODO fixa så man lägger in koordinater
 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
  "Authorization: 5b3ce3597851110001cf6248f012565337bb4301a0f7835ca1967d1e",
  "Content-Type: application/json; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);

# -------this print out ALL response stuff in JSON!!----------
#var_dump($response);

#$data = json_decode($response, true); THIS IS WRONG!!
$data = json_decode($response);
# "routes":[{"summary":{"distance":5463.5

$dist = $data->routes[0]->summary->distance; //this is the distance
echo '<br><br>';
echo $dist .'<br>';
$km = $dist/1000;
echo "The distance is " . $km . "km";








#------------test 2 - GET ----------------------
/*
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248f012565337bb4301a0f7835ca1967d1e&start=11.966954,57.706818&end=11.938598,57.705213");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8"
));

$response = curl_exec($ch);
curl_close($ch);

#var_dump($response);



#The out print: "type":"Feature","properties":{"segments":[{"distance":5463.5,....
$data = json_decode($response, true);

$dist = $data->features->properties->summary->distance;
echo $dist;
*/


?>

</body>
</html>
