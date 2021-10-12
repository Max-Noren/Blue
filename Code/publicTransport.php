<html>
<head>
</head>

<body>
<?php


//function getPublicTransport($coordinatesFrom, $coordinatesTo){
    //Start : Nordstan, Göteborg, VG, Sverige-->(11.96761,57.708077)
    //End : Polisen Göteborg, Göteborg, VG, Sverige-->(12.287668,57.664153)
    //$coordinatesFrom = "11.96761,57.708077";
    //$coordinatesTo = "12.287668,57.664153";

    //Split coordinates
    //$coordiatesFromLong=explode(',', coordinatesFrom)[0];
    //$coordiatesToLong=explode(',', coordinatesTo)[0];
    //$coordiatesFromLat=explode(',', coordinatesFrom)[1];
    //$coordiatesToLat=explode(',', coordinatesTo)[1];

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

   
    //Get data from API
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.vasttrafik.se/bin/rest.exe/v2/trip?originCoordLat=57.705524&originCoordLong=11.963719&originCoordName=Chalmers%2C%20Gothenburg%2C%20VG%2C%20Sweden&destCoordLat=57.708077&destCoordLong=11.96761&destCoordName=Nordstan%2C%20Gothenburg%2C%20VG%2C%20Sweden&format=json',
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

    $response = curl_exec($curl);

    curl_close($curl);
    echo json_decode($response)-> TripList -> Trip[0]->Leg[0]->type;    
    //$data = json_decode($response);
//}

?>
</body>
</html>