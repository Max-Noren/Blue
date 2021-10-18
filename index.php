<!------------------- 
#
#This file contains the main code of the program including
#user interface inputs as well as integrating all related
#function files to provide a cohesive report of a trips
#carbon emission and other useful data for the trip.
#
-------------------->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blue</title>
        
        <!-- jQuery Widgets -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">

        <!-- jQuery Autocomplete -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <link rel="stylesheet" href="style.css">

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
            source: allAddresses 
            });  
            
        } );

        //Autocomplete for end address
        $( function() {
            
            $("#end").on("input", function(){ //Calls on the getAddress function every keystroke
            getAddress($(this).val(), "end");
            })
            
            $( "#end" ).autocomplete({
            source: allAddresses 
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
                        <input type="text" id="start" name="start" value="<?php if(isset($_GET['start'])){echo $_GET['start'];}?>" required>
                        
                    </div>
                    
                    <!-- End Address --> 
                    <div style="display:inline-block;">
                        <label style="font-weight:bold;" for="end">To: </label>
                        <br>
                        <input type="text" id="end" name="end" value="<?php if(isset($_GET['end'])){echo $_GET['end'];}?>" required>
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
                    <input style="display: none;" id="startLat" name="startLat" value="<?php if(isset($_GET['startLat'])){echo $_GET['startLat'];} ?>" >
                    <input style="display: none;" id="startLng" name="startLng" value="<?php if(isset($_GET['startLng'])){echo $_GET['startLng'];} ?>" >
                    <input style="display: none;" id="endLat" name="endLat" value="<?php if(isset($_GET['endLat'])){echo $_GET['endLat'];} ?>" >
                    <input style="display: none;" id="endLng" name="endLng" value="<?php if(isset($_GET['endLng'])){echo $_GET['endLng'];} ?>" >
                    <br>
                </form> 

                
            </div>   
        </center>
    </body>
</html>

<?php
    
    #Import functions (Main)
    include ('Code/emission.php');
    include ('Code/display.php');
    include ('Code/travelinfo.php');
    include ('Code/costs.php');
    include ('Code/publicTransport.php');

    #Import Windows
    #include ('C:/xampp/htdocs/Blue/Code/emission.php');
    #include ('C:/xampp/htdocs/Blue/Code/display.php');
    #include ('C:/xampp/htdocs/Blue/Code/travelinfo.php');
    #include ('C:/xampp/htdocs/Blue/Code/costs.php');
    #include ('C:/xampp/htdocs/Blue/Code/publicTransport.php');

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

    #Fuel consumption (liter/km)
    $gasConsumption = 0.056; //This is for new cars of 2020, according to the car manufacturers themself (source: Trafikverket)
    $dieselConsumption = 0.051;
    $electricConsumption = 0.2; // kwh/km

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
        #Process and save input
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
            $totalGasPrice , $totalDieselPrice , $totalElectricPrice , $totalTicketPrice 

            #Fuel consumption (liter/km)
            , $gasConsumption ,$dieselConsumption , $electricConsumption

            #Addresses
            , $startAddress, $endAddress
            , $startCoordinate , $endCoordinate;
        }

        
        #Address
        $startAddress = $_GET['start'];
        $endAddress = $_GET['end'];

        ## Get coordinates from search querry
        $startCoordinatesArray = getCoordinatesORSAutoComplete($startAddress);
        $endCoordinatesArray = getCoordinatesORSAutoComplete($endAddress);

        #Coordinates
        $startLat = $startCoordinatesArray[1];
        $startLng = $startCoordinatesArray[0];
        $endLat = $endCoordinatesArray[1];
        $endLng = $endCoordinatesArray[0];

        #Input for distance calc
        $startCoordinate = $startLng . ',' . $startLat;
        $endCoordinate = $endLng . ',' . $endLat;
        
        #Distance
        $carDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[0];
        $walkDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[0];
        $bikeDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[0];
        $electricBikeTime = $bikeDistance;
        
        #The public transportation distance uses car distance 
        #since Västtrafiks API doesn't provide this
        $publicTranDistance = $carDistance; 
            
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
        $publicTranTime = getPublicTransport($startLat, $startLng, $endLat, $endLng);

        #Price
        $totalGasPrice = calculateCost($carDistance, $gasPrice, $gasConsumption);
        $totalDieselPrice = calculateCost($carDistance, $dieselPrice, $dieselConsumption);
        $totalElectricPrice = calculateCost($carDistance, $electricPrice, $electricConsumption); 
        $totalTicketPrice = $ticketPrice;
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
            , $gasPrice, $dieselPrice, $electricPrice
            , $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice

            #Fuel consumption(liter/km)
            , $gasConsumption, $dieselConsumption, $electricConsumption

            #Addresses
            , $startAddress, $endAddress
            , $startCoordinate , $endCoordinate;
        }
        
        
        
        #Displays all data in table
        displayTable($carTime, $bikeTime, $electricBikeTime, $walkTime, $publicTranTime,
            $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission, 
            $TripBikeEmission, $TripElectricBikeEmission,$TripWalkEmission, $TripPublicTranEmission,
            $carDistance, $bikeDistance, $walkDistance, $publicTranDistance, 
            $gasPrice, $dieselPrice, $electricPrice,
            $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice,
            $gasCarEmission, $dieselCarEmission, $electricCarEmission, $publicTranEmission,
            $gasConsumption, $dieselConsumption, $electricConsumption);

        #Displays info about hover functions
        displayHoverInfo();  

    }
        

?>



