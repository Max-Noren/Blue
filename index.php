<?php

#____________________
#Upon press of the 'Calculate' button it runs function input_co2()
#____________________

if($_GET['btn_submit'])
{
    input_co2($_GET['car_emission'], $_GET['car_distance']);
    calculate_co2($_GET['car_emission'], $_GET['car_distance']);
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
# This function calculated the total emission for the route, using
# inputs for emission & distance, then prints it out. 
#____________________
 function calculate_co2($emission, $distance)
 {
    $tot_emission = $emission * $distance;
    echo "The total emission for your route is: " . $tot_emission . "g CO2" . '<br><br><br>';
    return $tot_emission;
 }


?>

<html>
    <body>
</HTML>