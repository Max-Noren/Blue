<!------------------- 
#
# This file contain a function to calculate the time it takes for a trip by public transport
#
# The file is manualy tested
#
-------------------->
<?php
function getPublicTransport($originLat, $originLng, $destinationLat, $destinationLng){

    //Get token from Västtrafik API
    $curl = curl_init();
    $param = "grant_type=client_credentials&scope=<device_id>";
    curl_setopt($curl, CURLOPT_URL, "https://api.vasttrafik.se/token");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: Basic UGVaWnY1NjUzckUyUHVWUUZoVzQwVWNVX2ZjYTp3TXpLaVZkVlFQeVl4cUJnYzJfX1F1X0dtRWdh",
        "Content-Type: application/x-www-form-urlencoded"
        ));
    curl_setopt($curl, CURLOPT_POSTFIELDS,$param);
    $responseAuth = curl_exec($curl);
    curl_close($curl);
        
    $authKey=json_decode($responseAuth)-> access_token;

   
    //Get data from Västtrafik API
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.vasttrafik.se/bin/rest.exe/v2/trip?originCoordLat='.$originLat.'&originCoordLong='.$originLng.'&originCoordName=fran&destCoordLat='.$destinationLat.'&destCoordLong='.$destinationLng.'&destCoordName=till&format=json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$authKey,
    ),
    ));

    $vastTrafikAPIResponse = curl_exec($curl);

    curl_close($curl);

    //Finds the highest index in array/index for end destination
    $maxIndex = 0;   
    while(json_decode($vastTrafikAPIResponse)-> TripList -> Trip[0]->Leg[$maxIndex+1]->type != null){
        $maxIndex++;
    };

    //Time calculation
    $startTime = new DateTime(json_decode($vastTrafikAPIResponse)-> TripList -> Trip[0]->Leg[0]->Origin->time);
    $endTime = new DateTime(json_decode($vastTrafikAPIResponse)-> TripList -> Trip[0]->Leg[$maxIndex]->Destination->time);
    $interval = $endTime->diff($startTime);

    //Return time diffrence in minutes
    return $interval->format("%H")*60 + $interval->format("%i");

}

?>