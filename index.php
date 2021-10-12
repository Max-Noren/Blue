<!------------------- 
#
#This file contain the main code of the program including
#user interface inputs as well as integrating all related
#function files to provide a cohesive report of a trip's
#carbon emission and other useful data for the trip.
#
#openrouteservice.php -> has been manually tested and 
#compared to results from Google Maps (Coordinates). 
#
#index.php -> Manually tested and compared against results
#from openrouteservice.org
-------------------->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carbon Mort</title>
        
        <!-- jQuery Widgets -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- jQuery Autocomplete -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <style>
            /*Text input style : Adjusting size */
            input[type=text]{
                border: round;
                border-radius: 13px;
                font-size: 150%;
            }

            /*Submit input style : Adjusting color, size*/
            input[type=submit]{
                background-color: #7FFF00;
                border-radius: 15px;
                font-weight: bold;
                font-size: 125%;
            }

            /* Make inputs visible as interactive*/
            input:hover{
                background-color: #FFFF00 ;
                box-shadow: 2px 2px;
            }

            /*Img style: Resizing capabilites */
            img{
                max-width: 200px;
                height: auto;
            }

            /* Hidden explaination visible when hovering*/
            explain {
                position: absolute;
                display : none;
                font-size: 11px;
            }
            .question:hover + explain{
                display : block;
                background-color: #FFE4E1 ;
                border-style: inset;
            }

            /* The style of the table */
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            }

            td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            }
            
            tr:nth-child(even) {
            background-color: #dddddd;
            }


        </style>
    </head>

    
    <body>
        <script>

        //Global array for available addresses
        const allAddresses = ["N/A"];

        //Autocomplete for start address
        $( function() {
            
            $("#start").on("input", function(){ //Calls on the getAddress function every keystroke
            getAddress($(this).val(), "start");
            })

            $( "#start" ).autocomplete({
            source: allAddresses //The array from line 81
            });  
            
        } );

        //Autocomplete for end address
        $( function() {
            
            $("#end").on("input", function(){ //Calls on the getAddress function every keystroke
            getAddress($(this).val(), "end");
            })
            
            $( "#end" ).autocomplete({
            source: allAddresses //The array from line 81
            });
            
        } );

        //Obtains related addresses based on search, Openrouteservice API
        function getAddress(search, startOrEnd){
            var request = new XMLHttpRequest();

            autocompletePart1= 'https://api.openrouteservice.org/geocode/autocomplete?api_key=5b3ce3597851110001cf6248e38d3f64310c46ceb044c9b37ef563cd&text=';
            autocompletePart2= '&boundary.country=SE&sources=openstreetmap&layers=neighbourhood,address,venue'
            autocompletePart3 = '&boundary.circle.lon=11.97307942&boundary.circle.lat=57.70914870&boundary.circle.radius=11';
            request.open('GET', autocompletePart1 +search+ autocompletePart2 + autocompletePart3);
            request.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');

            request.onreadystatechange = function () {
                if (this.readyState === 4) {
                //console.log('Status:', this.status);
                //console.log('Headers:', this.getAllResponseHeaders());
                //console.log('Body:', this.responseText);


                var response = JSON.parse(this.responseText);
                while (allAddresses.length) { allAddresses.pop(); } // Empty array
                response.features.map(feature => feature.properties.label).forEach(label => allAddresses.push(label));  // Filter our label from response and push to allAddresses

                if(startOrEnd == "start") {
                    $("#startLat").val(response.features[0].geometry.coordinates[1]);
                    $("#startLng").val(response.features[0].geometry.coordinates[0]);
                } else if(startOrEnd == "end") {
                    $("#endLat").val(response.features[0].geometry.coordinates[1]);
                    $("#endLng").val(response.features[0].geometry.coordinates[0]);
                } else {
                    console.warn("Invalid startOrEnd arg", startOrEnd);
                }
                }
            };

            request.send();
        }
        </script>


        <!-- Two search fields, start and end address-->
        <center>
            <div class="ui-widget">
                <img src="logo.png">

                <h2>Calculate your commute's carbon footprint!</h2>
                <br>

                <form>
                    <!-- Start Address -->
                    <div style="display:inline-block;">
                        <label style="font-weight:bold;" for="start">From: </label>
                        <br>
                        <input type="text" id="start" name="start" required>
                        
                    </div>
                    
                    <!-- End Address --> 
                    <div style="display:inline-block;">
                        <label style="font-weight:bold;" for="end">To: </label>
                        <br>
                        <input type="text" id="end" name="end" required>
                    </div>
                    
                    <br><br><br>
                    
                    <!-- Button to calculate carbon footprint -->
                    <input type="submit" name="calculate" value=" My Commute's Carbon Footprint! " />

                    
                    <img class="question" style="width: 20px;" id="question" src="question.png">
                    <explain>Please input the start and end point of your commute, press the button
                             and let the program calculate the carbon footprint of your commute for 
                             different travelling option and help you make a more environmentally 
                             conscious choice! (Limited to Gothenburg Sweden) </explain>

                    <!-- Hidden input fields for saving data -->
                    <input style="display: none;" id="startLat" name="startLat" >
                    <input style="display: none;" id="startLng" name="startLng" >
                    <input style="display: none;" id="endLat" name="endLat" >
                    <input style="display: none;" id="endLng" name="endLng" >
                    <br>
                </form> 

                
            </div>   
        </center>
    </body>
</html>

<?php
    
    #Import functions (Main)
    include ('../Blue/Code/emission.php');
    include ('../Blue/Code/display.php');
    include ('../Blue/Code/travelinfo.php');
    include ('../Blue/Code/costs.php');

    #Import Windows
    #include ('C:/xampp/htdocs/Blue/Code/emission.php');
    #include ('C:/xampp/htdocs/Blue/Code/display.php');
    #include ('C:/xampp/htdocs/Blue/Code/travelinfo.php');
    #include ('C:/xampp/htdocs/Blue/Code/costs.php');

    #Import Mac
    #include('/Applications/XAMPP/xamppfiles/htdocs/Blue/Code/emission.php');
    #include('/Applications/XAMPP/xamppfiles/htdocs/Blue/Code/display.php');
    #include('/Applications/XAMPP/xamppfiles/htdocs/Blue/Code/travelinfo.php');
    #include('/Applications/XAMPP/xamppfiles/htdocs/Blue/Code/costs.php');

    #____________________
    #Global variables
    #____________________

    #Emissions (CO2e g/km)
    $gasCarEmission = 169;
    $dieselCarEmission = 159;
    $electricCarEmission = 9.36;
    $walkEmission = 0;
    $bikeEmission = 0;
    $electricBikeEmission = 0.065;
    $publicTranEmission = 16; // average between bus and tram
    $tramEmission = 10.33; // per passenger
    $dieselBusEmission = 22; // per passenger
    $localTrainEmission = 10.33; // per passenger
    $ferryEmission = 19.3;

    #Trip Emissions (CO2e g/km)
    $TripGasCarEmission = 0;
    $TripDieselCarEmission = 0;
    $TripElectricCarEmission = 9.36;
    $TripWalkEmission = 0;
    $TripBikeEmission = 0;
    $TripElectricBikeEmission = 0;
    $TripPublicTranEmission = 0;

    #Distance (km)
    $carDistance = 0;
    $walkDistance = 0;
    $bikeDistance = 0;
    $publicTranDistance = 0;

    #Time (minutes)
    $carTime = 0;
    $walkTime = 0;
    $bikeTime = 0;
    $electricBikeTime = 0;
    $publicTranTime = 0;

    #Price (kr)
    $gasPrice = 17.59; 
    $dieselPrice = 19.17;
    $electricPrice = 1.650;
    $ticketPrice = 34;

    #fuel consumption (liter/km)
    $gasConsumption = 0.056; //this is for new cars of 2020, according to the car manufacturers themself (source: trafikverket)
    $dieselConsumption = 0.051;
    $electricConsumption = 0.2; // kwh/km

    #Calories (sugar cubes)
    $walkCalories = 0;
    $bikeCalories = 0;

    #Addresses 
    $startAddress = '';
    $endAddress = '';

    #Coordinates
    $startCoordinate = ''; 
    $endCoordinate = '';

    #____________________
    #Upon press of the 'Calculate' button it runs function main function
    #____________________
    if(isset($_GET['calculate']))
    {
        #Process and save inputs
        processInput();

        #Process data and display output
        processOutput(); 
    }

    #____________________
    #Processes the inputs and saves them to global variables
    #____________________
    function processInput(){
        
        #Imports all GLOBAL variables
        if(true){
            #Emissions
            GLOBAL $gasCarEmission, $dieselCarEmission, $electricCarEmission
            , $walkEmission, $bikeEmission, $electricBikeEmission, $publicTranEmission

            #Trip Emissions
            , $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission
            , $TripWalkEmission, $TripBikeEmission, $TripElectricBikeEmission, $TripPublicTranEmission

            #Distance
            , $carDistance, $walkDistance, $bikeDistance, $publicTranDistance

            #Time
            , $carTime, $walkTime, $bikeTime, $electricBikeTime, $publicTranTime

            #Price
            , $gasPrice, $dieselPrice, $electricPrice, $ticketPrice,
            $totalGasPrice , $totalDieselPrice , $totalElectricPrice , $totalTicketPrice //?

            #Calories
            , $walkCalories, $bikeCalories

            #fuel consumption (liter/km)
            , $gasConsumption ,$dieselConsumption , $electricConsumption

            #Addresses
            , $startAddress, $endAddress
            , $startCoordinate , $endCoordinate;
        }

        
        #Address
        $startAddress = $_GET['start'];
        $endAddress = $_GET['end'];

        #Coordinates
        $startCoordinate = $_GET['startLng'] . ',' . $_GET['startLat'];
        $endCoordinate = $_GET['endLng'] . ',' . $_GET['endLat'];
        
        #Distance
        $carDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[0];
        $walkDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[0];
        $bikeDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[0];
        $electricBikeTime = $bikeDistance;
        
        #Change once västtrafik is implemented
        $publicTranDistance = $carDistance; //using car distance right now (since västtrafiks API doesn't provide this)
            
        #Trip Emissions
        $TripGasCarEmission = calculateEmission($gasCarEmission, $carDistance);
        $TripDieselCarEmission = calculateEmission($dieselCarEmission, $carDistance);
        $TripElectricCarEmission =calculateEmission($electricCarEmission, $carDistance);
        
        $TripWalkEmission = calculateEmission($walkEmission, $walkDistance);
        $TripBikeEmission = calculateEmission($bikeEmission, $bikeDistance);
        $TripElectricBikeEmission = calculateEmission($electricBikeEmission, $bikeDistance);
        $TripPublicTranEmission = calculateEmission($publicTranEmission, $publicTranDistance);

        #Time
        $carTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[1];
        $walkTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[1];
        $bikeTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[1];
        $electricBikeTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-electric')[1];

        #Change once västtrafik is implemented
        $publicTranTime = 0;

        #Price
        $totalGasPrice = calculateCost($carDistance, $gasPrice, $gasConsumption);
        $totalDieselPrice = calculateCost($carDistance, $dieselPrice, $dieselConsumption);
        $totalElectricPrice = calculateCost($carDistance, $electricPrice, $electricConsumption); 
        $totalTicketPrice = $ticketPrice; #($_GET['ticketPrice']);

        #Calories
        $walkCalories = 0; #($_GET['calories']);
        $bikeCalories = 0; #($_GET['calories']);

    }

    #____________________
    # This function displays the total emission for the different traveling methods.
    #____________________
    function processOutput(){

        #Imports all GLOBAL variables
        if(true){
            #Emissions
            GLOBAL $gasCarEmission, $dieselCarEmission, $electricCarEmission
            , $walkEmission, $bikeEmission, $electricBikeEmission, $publicTranEmission

            #Trip Emissions
            , $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission
            , $TripWalkEmission, $TripBikeEmission, $TripElectricBikeEmission, $TripPublicTranEmission

            #Distance
            , $carDistance, $walkDistance, $bikeDistance, $publicTranDistance

            #Time
            , $carTime, $walkTime, $bikeTime, $electricBikeTime,$publicTranTime

            #Price
            , $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice

            #Calories
            , $walkCalories, $bikeCalories

            #Addresses
            , $startAddress, $endAddress
            , $startCoordinate , $endCoordinate;
        }

        #Displays all data in table
        displayTable($carTime, $bikeTime, $electricBikeTime, $walkTime, $publicTranTime,
            $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission, 
            $TripBikeEmission, $TripElectricBikeEmission,$TripWalkEmission, $TripPublicTranEmission,
            $carDistance, $bikeDistance, $walkDistance, $publicTranDistance, 
            $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice);

    }

?>



