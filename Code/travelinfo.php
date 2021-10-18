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

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
      "Authorization: 5b3ce3597851110001cf6248f012565337bb4301a0f7835ca1967d1e",
      "Content-Type: application/json; charset=utf-8"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response);

    $dist = $data->routes[0]->summary->distance; //this is the distance
    $duration = $data->routes[0]->summary->duration; //this is the time in seconds

    $time = round($duration/60);
    $distance = number_format($dist/1000, 1, '.', ',');
    return array($distance, $time);
  }

  #____________________
  #Function that returns coordinates from search query
  #____________________

  function getCoordinatesORSAutoComplete($placeName){
    
    $addressArray = explode(",", $placeName);
    
    # Replace Göteborg and Sverige with Gothenburg and sweden 
    if($addressArray[1] != null){
      $addressArray[1] = "Gothenburg";
      $addressArray[2] = "VG";
      $addressArray[3] = "Sweden";
    };
    
    $placeName = implode(",", $addressArray);
  
    $curl_ORS = curl_init();

    curl_setopt($curl_ORS, CURLOPT_URL, "https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf6248e38d3f64310c46ceb044c9b37ef563cd&text=".urlencode($placeName)."&boundary.country=SE&sources=openstreetmap&layers=neighbourhood,address,venue&boundary.circle.lon=11.97307942&boundary.circle.lat=57.70914870&boundary.circle.radius=11");
    curl_setopt($curl_ORS, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl_ORS, CURLOPT_HEADER, FALSE);

    curl_setopt($curl_ORS, CURLOPT_HTTPHEADER, array(
      "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
      "Content-Type: application/json; charset=utf-8"
    ));

    $orsApiAutoCompleteResponse = curl_exec($curl_ORS);
    curl_close($curl_ORS);
    $lng = json_decode($orsApiAutoCompleteResponse) -> features[0] -> geometry -> coordinates[0];
    $lat = json_decode($orsApiAutoCompleteResponse) -> features[0] -> geometry -> coordinates[1];
    return array(
      $lng,
      $lat
    );
  }

?>
