<?php

#____________________
#Global variables
#____________________
$electricCarEmission = 9.36; // g CO2e/km (CO2 equivalent)
$walkEmission = 0;
$bikeEmission = 0;
$dieselCarEmission = 159;
$gasolineCarEmission = 169;
$electricBikeEmission = 0.065;



#____________________
#Upon press of the 'Calculate' button it runs function input_co2()
#____________________

if($_GET['btn_submit'])
{
    input_co2($_GET['car_emission'], $_GET['car_distance']);
    calculate_co2($_GET['car_emission'], $_GET['car_distance']);
    display_co2($_GET['car_emission'], $_GET['car_distance']);
}


#____________________
#Function that takes a variable and prints it
#____________________

 function input_co2($emission, $distance)#$quantity);
 {
     echo "This is your emission --> " . $emission . '<br>';
     echo "This is your route distance --> " . $distance . '<br><br>';
 
 }

#____________________
# This function displays the total emission for the different traveling methods.
#____________________
 function display_co2($emission, $distance){
    global $walkEmission, $bikeEmission, $electricCarEmission;
    echo "The total emission if traveling by car is: " . calculate_co2($emission, $distance) . "g CO2" . '<br>';
    echo "The total emission if traveling by electric car is: " . calculate_co2($electricCarEmission, $distance) . "g CO2 equivalent" . '<br>';
    echo "The total emission for walking is: " . $walkEmission . "g CO2" . '<br>';
    echo "The total emission for riding a bike is: " . $bikeEmission . "g CO2" . '<br>';
    echo "<br><br>";

 }

#____________________
# This function calculated the total emission for the route, using
# inputs for emission & distance.
#____________________
 function calculate_co2($emission, $distance)
 {
    $tot_emission = $emission * $distance;
    return $tot_emission;
 }

<<<<<<< Updated upstream
=======
            #Trip Emissions
            , $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission
            , $TripWalkEmission, $TripBikeEmission, $TripElectricBikeEmission, $TripPublicTranEmission

            #Distance
            , $carDistance, $walkDistance, $bikeDistance, $publicTranDistance

            #Time
            , $carTime, $walkTime, $bikeTime, $electricBikeTime, $publicTranTime

            #Price
            , $gasPrice, $dieselPrice, $electricPrice, $ticketPrice

            #Calories
            , $walkCalories, $bikeCalories

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
        $publicTranDistance = $carDistance;
            
        #Trip Emissions
        $TripGasCarEmission = calculateEmission($gasCarEmission, $carDistance);
        $TripDieselCarEmission = calculateEmission($dieselCarEmission, $carDistance);
        $TripElectricCarEmission =calculateEmission($electricCarEmission, $carDistance);

        $TripWalkEmission = calculateEmission($walkEmission, $walkDistance);
        $TripBikeEmission = calculateEmission($bikeEmission, $bikeDistance);
        $TripPublicTranEmission = calculateEmission($publicTranEmission, $publicTranDistance);



        #Time
        $carTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[1];
        $walkTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[1];
        $bikeTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[1];
        $electricBikeTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycle-electric')[1];
        
        #Change once västtrafik is implemented
        $publicTranTime = $carTime;

        #Price
        $gasPrice = 0;
        $dieselPrice = 0;
        $electricPrice = 0;
        $ticketPrice = 0; #($_GET['ticketPrice']);

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
            , $gasPrice, $dieselPrice, $electricPrice, $ticketPrice

            #Calories
            , $walkCalories, $bikeCalories

            #Addresses
            , $startAddress, $endAddress
            , $startCoordinate , $endCoordinate;
        }

        displayCoordinates($startAddress,$endAddress, $startCoordinate, $endCoordinate);

        displayEmissionPerKm($gasCarEmission, $dieselCarEmission, $electricCarEmission, 
                        $bikeEmission, $electricBikeEmission, $walkEmission, $publicTranEmission);

                        
                        
        displayEmission($TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission, 
                        $TripBikeEmission, $TripElectricBikeEmission,$TripWalkEmission, $TripPublicTranEmission);

        
        displayDistance($carDistance, $bikeDistance,
                        $walkDistance, $publicTranDistance);

                        
        displayTime($carTime, $bikeTime,
                    $walkTime, $electricBikeTime, $publicTranTime);

        carbonEquivalent($TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission, 
        $TripBikeEmission, $TripElectricBikeEmission,$TripWalkEmission, $TripPublicTranEmission);     
    }
>>>>>>> Stashed changes

?>

<html>
    <body>
        <form >
            <!-- Number input with limit from 0<x<300 -->
            Please input your car's emission in g/km
            <input type="number" id="car_emission" name="car_emission" value="0" min="0" max="300">
            <br>
            <!-- Number input with limit from 0<x<infinity -->
            Please input route distance in km
            <input type="number" id="car_distance" name="car_distance" value="0" min="0">
            <br>
            <!-- Button to calculate -->
            <input type="submit" name="btn_submit" value="My Carbon Footprint?" />
        </form>
    </body>
</html>

