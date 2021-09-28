<?php
include ('C:/xampp/htdocs/Blue/Code/emission.php');
include ('C:/xampp/htdocs/Blue/Code/openrouteservice.php');
include ('C:/xampp/htdocs/Blue/Code/display.php');
include ('C:/xampp/htdocs/Blue/Code/travelInfo.php');


#____________________
#Global variables
#____________________

#Emissions
$gasCarEmission = 0;
$dieselCarEmission = 0;
$electricCarEmission = 9.36; // g CO2e/km (CO2 equivalent)
$walkEmission = 0;
$bikeEmission = 0;
$publicTranEmission = 0;

#Trip Emissions
$TripGasCarEmission = 0;
$TripDieselCarEmission = 0;
$TripElectricCarEmission = 9.36; // g CO2e/km (CO2 equivalent)
$TripWalkEmission = 0;
$TripBikeEmission = 0;
$TripPublicTranEmission = 0;

#Distance
$carDistance = 0;
$walkDistance = 0;
$bikeDistance = 0;
$publicTranDistance = 0;

#Time
$carTime = 0;
$walkTime = 0;
$bikeTime = 0;
$publicTranTime = 0;

#Price
$gasPrice = 0;
$dieselPrice = 0;
$electricPrice = 0;
$ticketPrice = 0;

#Calories
$walkCalories = 0;
$bikeCalories = 0;

#Addresses
$startAddress = 'Chalmers';
$endAddress = 'Majorna';

#Chalmers --> Majorna, DEFUALT COORDINATES
$startCoordinate = '11.963719,57.705524'; 
$endCoordinate = '11.919815,57.69342';


#____________________
#Upon press of the 'Calculate' button it runs function main function
#____________________

if(isset($_GET['calculate']))
{
    #displayCoordinates($startCoordinate, $endCoordinate);
    processInput();
    processOutput();
    
    #input_co2($_GET['car_emission'], $_GET['car_distance']);
    #calculate_co2($_GET['car_emission'], $_GET['car_distance']);
    #display_co2($_GET['car_emission'], $_GET['car_distance']);
}

#____________________
#Processes the inputs and saves them to global variables
#____________________
function processInput(){
    
    #Imports all GLOBAL variables
    if(true){
        #Emissions
        GLOBAL $gasCarEmission, $dieselCarEmission, $electricCarEmission
        , $walkEmission, $bikeEmission, $publicTranEmission

        #Trip Emissions
        , $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission
        , $TripWalkEmission, $TripBikeEmission, $TripPublicTranEmission

        #Distance
        , $carDistance, $walkDistance, $bikeDistance, $publicTranDistance

        #Time
        , $carTime, $walkTime, $bikeTime, $publicTranTime

        #Price
        , $gasPrice, $dieselPrice, $electricPrice, $ticketPrice

        #Calories
        , $walkCalories, $bikeCalories

        #Addresses
        , $startAddress, $endAddress
        , $startCoordinate , $endCoordinate;
    }
    
    #Emissions
    $gasCarEmission = ($_GET['car_emission']);
    $dieselCarEmission = ($_GET['car_emission']);
    $publicTranEmission = 0;

    #Distance

    $carDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[0];
    $walkDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[0];
    $bikeDistance = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[0];
   
    $publicTranDistance = ($_GET['distance']);
        
    #Trip Emissions
    $TripGasCarEmission = calculateEmission($gasCarEmission, $carDistance);
    $TripDieselCarEmission = calculateEmission($dieselCarEmission, $carDistance);
    $TripElectricCarEmission =calculateEmission($electricCarEmission, $carDistance);

    $TripWalkEmission = calculateEmission($walkEmission, $walkDistance);
    $TripBikeEmission = calculateEmission($bikeEmission, $bikeDistance);
    $TripPublicTranEmission = calculateEmission($publicTranEmission, $publicTranDistance);

    #Coordinates
    #$startAddress = $_GET['start']; 
    #$endAddress = $_GET['end'];
   
    #$startCoordinate = getAddresses($start);
    #$endCoordinate = getAddresses($end);

    #Time
    $carTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'driving-car')[1];
    $walkTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'foot-walking')[1];
    $bikeTime = getDistanceAndTime($startCoordinate, $endCoordinate, 'cycling-regular')[1];
    


    $publicTranTime = 0; #($_GET['travelTime']);

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
        , $walkEmission, $bikeEmission, $publicTranEmission

        #Trip Emissions
        , $TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission
        , $TripWalkEmission, $TripBikeEmission, $TripPublicTranEmission

        #Distance
        , $carDistance, $walkDistance, $bikeDistance, $publicTranDistance

        #Time
        , $carTime, $walkTime, $bikeTime, $publicTranTime

        #Price
        , $gasPrice, $dieselPrice, $electricPrice, $ticketPrice

        #Calories
        , $walkCalories, $bikeCalories

        #Addresses
        , $startAddress, $endAddress
        , $startCoordinate , $endCoordinate;
    }
    displayEmissionPerKm($gasCarEmission, $dieselCarEmission, $electricCarEmission, 
                    $bikeEmission,$walkEmission, $publicTranEmission);

                    
                    
    displayEmission($TripGasCarEmission, $TripDieselCarEmission, $TripElectricCarEmission, 
                    $TripBikeEmission,$TripWalkEmission, $TripPublicTranEmission);

    
    displayDistance($carDistance, $bikeDistance,
                    $walkDistance, $publicTranDistance);

                    
    displayTime($carTime, $bikeTime,
                $walkTime, $publicTranTime);

    

 }


?>

<html>
    <head>
        <title>Blue</title>
    </head>
    
    <body>
        <form >
            <br><br><br>
            <!-- Number input with limit from 0<x<300 -->
            Please input your car's emission in g/km
            <input type="number" id="car_emission" name="car_emission" value="0" min="0" max="300">
            <br>
            <!-- Number input with limit from 0<x<infinity -->
            Please input route distance in km
            <input type="number" id="distance" name="distance" value="0" min="0">
            <br>
            <!-- Button to calculate -->
            <input type="submit" name="calculate" value="My Carbon Footprint?" />
        </form>
    </body>
</html>

