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

 function calculate_co2($emission, $distance)
 {
    $tot_emission = $emission * $distance;
    echo "The total emission for your route is --> " . $tot_emission . '<br><br><br>';
 }


?>

<html>
    <body>
        <form >
            <!-- Number input with limit from 0<x<300 -->
            Please input your car's emission in g/km
            <input type="number" id="car_emission" name="car_emission" min="0" max="300">
            <br>
            Please input route distance in km
            <input type="number" id="car_distance" name="car_distance" min="0">
            <br>
            <!-- Button to calculate -->
            <input type="submit" name="btn_submit" value="My Carbon Footprint?" />
        </form>
    </body>
</html>

