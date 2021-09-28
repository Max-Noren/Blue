<?php

    function displayEmissionPerKm($emission){
        echo $emission, "g/km";
    }

    function displayEmission($mode, $emission){
        echo "CO2 emission when travelling by ",$mode," : ", $emission;
    }

    function displayDistance($mode, $distance){
        echo "Trip distance when travelling by ", $mode," : ", $distance;
    }

    function displayTime($mode, $time){
        echo "Time spent when travelling by ",$mode, " : ", $distance;
    }

    function displayCoordinates($start, $end){
        echo "<br>Start : ", $start, "<br>";
        echo "Latitude : ", $start_coordinates[1], "<br>";
        echo "Longitude : ", $start_coordinates[0], "<br>";
        
        echo "<br>End : ", $end, "<br>";
        echo "Latitude : ", $end_coordinates[1], "<br>";
        echo "Longitude : ", $end_coordinates[0], "<br>";

    }


?>