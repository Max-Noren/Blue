<?php
include ('/Code/emission.php');
include ('/Code/openrouteservice.php');
include ('/Code/display.php');


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




#____________________
#Upon press of the 'Calculate' button it runs function main function
#____________________

if(isset($_GET['calculate']))
{
    process_input();
    displayCoordinates($startCoordinate, $endCoordinate);

    
    #input_co2($_GET['car_emission'], $_GET['car_distance']);
    #calculate_co2($_GET['car_emission'], $_GET['car_distance']);
    #display_co2($_GET['car_emission'], $_GET['car_distance']);
}

#____________________
#Processes the inputs and saves them to global variables
#____________________
function process_input(){
        
    #Emissions
    $gasCarEmission = ($_GET['car_emission']);
    $dieselCarEmission = ($_GET['car_emission']);
    $publicTranEmission = 0;
        
    #Trip Emissions
    $TripGasCarEmission = calculateEmission($gasCarEmission, $carDistance);
    $TripDieselCarEmission = calculateEmission($dieselCarEmission, $carDistance);
    $TripElectricCarEmission =calculateEmission($electricCarEmission, $carDistance);
    $TripWalkEmission = calculateEmission($walkCarEmission, $walkDistance);
    $TripBikeEmission = calculateEmission($bikeCarEmission, $bikeDistance);
    $TripPublicTranEmission = calculateEmission($publicTransportCarEmission, $publicTransportDistance);

    #Coordinates
    $startAddress = $_GET['start']; 
    $endAddress = $_GET['end'];
   
    $startCoordinate = getAddresses($start);
    $endCoordinate = getAddresses($end);

    #Distance
    
    $carDistance = getDistanceAndTime(startCoordinate, endCoordinate, 'driving-car')[0];
    $walkDistance = getDistanceAndTime(startCoordinate, endCoordinate, 'foot-walking')[0];
    $bikeDistance = getDistanceAndTime(startCoordinate, endCoordinate, 'cycling-regular')[0];

    $publicTranDistance = ($_GET['distance']);

    #Time
    $carTime = getDistanceAndTime(startCoordinate, endCoordinate, 'driving-car')[1];
    $walkTime = getDistanceAndTime(startCoordinate, endCoordinate, 'foot-walking')[1];
    $bikeTime = getDistanceAndTime(startCoordinate, endCoordinate, 'cycling-regular')[1];
    
    $publicTranTime = ($_GET['travelTime']);;

    #Price
    $gasPrice = 0;
    $dieselPrice = 0;
    $electricPrice = 0;
    $ticketPrice = ($_GET['ticketPrice']);

    #Calories
    $walkCalories = ($_GET['calories']);
    $bikeCalories = ($_GET['calories']);



}

#____________________
# This function displays the total emission for the different traveling methods.
#____________________
 function process_output($emission, $distance){
    global $walkEmission, $bikeEmission, $electricCarEmission;
    echo "The total emission if traveling by car is: " . calculate_co2($emission, $distance) . "g CO2" . '<br>';
    echo "The total emission if traveling by electric car is: " . calculate_co2($electricCarEmission, $distance) . "g CO2 equivalent" . '<br>';
    echo "The total emission for walking is: " . $walkEmission . "g CO2" . '<br>';
    echo "The total emission for riding a bike is: " . $bikeEmission . "g CO2" . '<br>';
    echo "<br><br>";

 }


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
            <input type="number" id="distance" name="distance" value="0" min="0">
            <br>
            <!-- Button to calculate -->
            <input type="submit" name="calculate" value="My Carbon Footprint?" />
        </form>
    </body>
</html>

