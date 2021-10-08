<html>
<head>
</head>

<body>
<?php


//function getPublicTransport($coordinatesFrom, $coordinatesTo){
    //Start : Nordstan, Göteborg, VG, Sverige-->(11.96761,57.708077)
    //End : Polisen Göteborg, Göteborg, VG, Sverige-->(12.287668,57.664153)
    $coordinatesFrom = "11.96761,57.708077";
    $coordinatesTo = "12.287668,57.664153";

    //Split coordinates
    $coordiatesFromLong=explode(',', coordinatesFrom)[1];
    $coordiatesToLong=explode(',', coordinatesTo)[1];
    $coordiatesFromLat=explode(',', coordinatesFrom)[2];
    $coordiatesToLat=explode(',', coordinatesTo)[2];

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

   

    

    //curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/" . $transportationMode );
    //curl_setopt($ch, CURLOPT_URL, "https://api.vasttrafik.se/bin/rest.exe/v2/trip?originCoordLat=".$coordiatesFromLat."&originCoordLong=".$coordiatesFromLong."&originCoordName=Chalmers%2C%20Gothenburg%2C%20VG%2C%20Sweden&destCoordLat=".$coordiatesToLat."&destCoordLong=".$coordiatesToLong."&destCoordName=Nordstan%2C%20Gothenburg%2C%20VG%2C%20Sweden&format=json");
    curl_setopt($ch, CURLOPT_URL, "https://api.vasttrafik.se/bin/rest.exe/v2/trip?originCoordLat=".$coordiatesFromLat."&originCoordLong=".$coordiatesFromLong."&originCoordName=Chalmers%2C%20Gothenburg%2C%20VG%2C%20Sweden&destCoordLat=".$coordiatesToLat."&destCoordLong=".$coordiatesToLong."&destCoordName=Nordstan%2C%20Gothenburg%2C%20VG%2C%20Sweden&format=json");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    curl_setopt($ch, CURLOPT_POST, TRUE); 
    //curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[[' . $coordinatesFrom . '],[' . $coordinatesTo . ']]}');
    curl_setopt($ch, CURLOPT_HTTPHEADER, "Authorization: Bearer ".$authKey."");

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;

    $data = json_decode($response);
//}

?>
</body>
</html>