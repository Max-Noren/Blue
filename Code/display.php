<!------------------- 
#
#This file contain all print functions for outputting
#and displaying data
#
#display.php -> Manually tested and compared against results
#from openrouteservice.org
#
-------------------->

<?php

    #Displays CO2 emissions per kilometer for all travel options
    function displayEmissionPerKm($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>CO2 emission per kilometer</h4>";
        echo "Gas Car : ", $gas, "g/km";
        echo "<br>Diesel Car : ",$diesel, "g/km";
        echo "<br>Electric Car : ",$electric, "g/km";
        echo "<br>Bike : ",$bike, "g/km (Negligible)";
        echo "<br>Electric Bike : ",$electricBike, "g/km";
        echo "<br>Walking : ",$walk, "g/km (Negligible)";
        echo "<br>Public Transport : ",$publicTran, "g/km";
    }
    
    #Displays total trip emissions for all travel options
    function displayEmission($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>Trip Emissions</h4>";
        echo "CO2 emission when traveling by Gas Car : ", number_format($gas, 1, '.', ',') , " g";
        echo "<br>CO2 emission when traveling by Diesel Car : ", number_format($diesel, 1, '.', ','), " g";
        echo "<br>CO2 emission when traveling by Electric Car : ", number_format($electric, 1, '.', ','), " g";
        echo "<br>CO2 emission when traveling by Bike : ", number_format($bike, 1, '.', ','), " g (Negligible)";
        echo "<br>CO2 emission when traveling by Electric Bike : ", number_format($electricBike, 1, '.', ','), " g";
        echo "<br>CO2 emission when traveling by Walking : ", number_format($walk, 1, '.', ','), " g (Negligible)";
        echo "<br>CO2 emission when traveling by Public Transport : ", number_format($publicTran, 1, '.', ','), " g";
    }

    #Displays distance for all travel types
    function displayDistance($car, $bike, $walk, $publicTran){
        echo "<br><h4>Trip Distance</h4>";
        echo "Trip distance when traveling by Car: ", $car, " km";
        echo "<br>Trip distance when traveling by Bike: ", $bike, " km";
        echo "<br>Trip distance when traveling by Walking: ", $walk, " km";
        echo "<br>Trip distance when traveling by Public Transport: ", $publicTran, " km";
    }

    #Displays travel time for all travel options
    function displayTime($car, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>Trip Time</h4>";
        echo "Time spent when traveling by Car: ", convertToHoursMins($car);
        echo "<br>Time spent when traveling by Bike: ", convertToHoursMins($bike);
        echo "<br>Time spent when traveling by Electric Bike: ", convertToHoursMins($electricBike);
        echo "<br>Time spent when traveling by Walking: ", convertToHoursMins($walk);
        echo "<br>Time spent when traveling by Public Transport: ", convertToHoursMins($publicTran);
    }

    #Displays start and end addresses and coordinates
    function displayCoordinates($start, $end, $startCoordinates, $endCoordinates){
        echo "<br>Start : ", $start,"-->(", $startCoordinates, ")<br>";
        echo "End : ", $end, "-->(", $endCoordinates,")<br>";

    }

    #____________________
    #This function displays the CO2 equivalence in either cheese sandwiches, plastic bags 
    #or tumble drying sessions for the trip, chosen randomly.
    #
    #The function takes in CO2 for the trip given every transportation mode and then prints
    #out nr of sandwiches/plasticbags/tumble dryer sessions that the trip equivalates to.
    #____________________
    function displayCarbonEquivalent($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran)
    {
        //how many grams of CO2 is (approx) the emissions from either a cheese sandwich, 
        //plasticbag and dryer(which one of them is chosen randomly).

        $cheeseSandwich = 345;
        $plasticbag = 33;
        $dryer = 1074;

        $randomNumber = rand(0, 2);
        $RandomMeasure = 0;
        $houseHoldItem = "";
    
        if($randomNumber == "0"){
           $RandomMeasure = $cheeseSandwich; 
           $houseHoldItem = "Cheese Sandwitches";
        }
        else if($randomNumber == "1"){
            $RandomMeasure = $plasticbag;
            $houseHoldItem = "Plastic Bags";
        }
        else if($randomNumber == "2"){
            $RandomMeasure = $dryer;
            $houseHoldItem = "Tumble Drying Sessions";
        }
        
        //return the equivalent numbers of items in this order: plastic bags, cheese sandwich, 
        //nr of tumble drying sessions
        echo "<br><h4>Carbon Equivalence</h4>";
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Gas Car : " ,
             number_format($gas / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Diesel Car : " , 
             number_format($diesel / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Electric Car : " , 
             number_format($electric / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Bike : " , 
             number_format($bike / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Electric Bike : " , 
             number_format($electricBike / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Walking : " , 
             number_format($walk / $RandomMeasure, 1) , " " , $houseHoldItem;

        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when traveling by Public Transport : " , 
             number_format($publicTran / $RandomMeasure, 1) , " " , $houseHoldItem;
    }

    #Converts minutes into hours and minutes format
    function convertToHoursMins($time) {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        if($hours == 0){
            $format = '%2dmin';
            return sprintf($format, $minutes);
        }
        $format = '%2dh %2dmin';
        return sprintf($format, $hours, $minutes);
    }


?>