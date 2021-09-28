<?php

    function displayEmissionPerKm($gas, $diesel, $electric, $bike, $walk, $publicTran){
        echo "<br><h4>CO2 emission per kilometer</h4>";
        echo "Gas Car : ",$gas, "g/km";
        echo "<br>Diesel Car : ",$diesel, "g/km";
        echo "<br>Electric Car : ",$electric, "g/km";
        echo "<br>Bike : ",$bike, "g/km";
        echo "<br>Walk : ",$walk, "g/km";
        echo "<br>Public Transport : ",$publicTran, "g/km";
    }

    function displayEmission($gas, $diesel, $electric, $bike, $walk, $publicTran){
        echo "<br><h4>Trip Emissions</h4>";
        #Include a weight function that converts gram in kg
        echo "CO2 emission when travelling by Gas Car : ", $gas;
        echo "<br>CO2 emission when travelling by Diesel Car : ", $diesel;
        echo "<br>CO2 emission when travelling by Electric Car : ", $electric;
        echo "<br>CO2 emission when travelling by Bike : ", $bike;
        echo "<br>CO2 emission when travelling by Walk : ", $walk;
        echo "<br>CO2 emission when travelling by Public Transport : ", $publicTran;
    }

    function displayDistance($car, $bike, $walk, $publicTran){
        echo "<br><h4>Trip Distance</h4>";
        #Include a distance function that converts ... nothing, never mind
        echo "Trip distance when travelling by Car: ", $car;
        echo "<br>Trip distance when travelling by Bike: ", $bike;
        echo "<br>Trip distance when travelling by Walk: ", $walk;
        echo "<br>Trip distance when travelling by Public Transport: ", $publicTran;
    }

    function displayTime($car, $bike, $walk, $publicTran){
        echo "<br><h4>Trip Time</h4>";
        #Include a time function that converts minutes to hours
        echo "Time spent when travelling by Car: ", $car;
        echo "<br>Time spent when travelling by Bike: ", $bike;
        echo "<br>Time spent when travelling by Walk: ", $walk;
        echo "<br>Time spent when travelling by Public Transport: ", $publicTran;
    }

    #This is a horrible function
    function displayCoordinates($start, $end){
        echo "<br>Start : ", $start, "<br>";
        #echo "Latitude : ", $start_coordinates[1], "<br>";
        #echo "Longitude : ", $start_coordinates[0], "<br>";
        
        echo "<br>End : ", $end, "<br>";
        #echo "Latitude : ", $end_coordinates[1], "<br>";
        #echo "Longitude : ", $end_coordinates[0], "<br>";

    }


?>