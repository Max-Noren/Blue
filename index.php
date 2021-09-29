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

