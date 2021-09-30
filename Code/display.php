<?php

    function displayEmissionPerKm($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>CO2 emission per kilometer</h4>";
        echo "Gas Car : ",$gas, "g/km";
        echo "<br>Diesel Car : ",$diesel, "g/km";
        echo "<br>Electric Car : ",$electric, "g/km";
        echo "<br>Bike : ",$bike, "g/km";
        echo "<br>Electric Bike : ",$electricBike, "g/km";
        echo "<br>Walk : ",$walk, "g/km";
        echo "<br>Public Transport : ",$publicTran, "g/km";
    }

    function displayEmission($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>Trip Emissions</h4>";
        #Include a weight function that converts gram in kg
        echo "CO2 emission when travelling by Gas Car : ", $gas;
        echo "<br>CO2 emission when travelling by Diesel Car : ", $diesel;
        echo "<br>CO2 emission when travelling by Electric Car : ", $electric;
        echo "<br>CO2 emission when travelling by Bike : ", $bike;
        echo "<br>CO2 emission when travelling by Electric Bike : ", $electricBike;
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

    function displayTime($car, $bike, $electricBike, $walk, $publicTran){
        echo "<br><h4>Trip Time</h4>";
        #Include a time function that converts minutes to hours
        echo "Time spent when travelling by Car: ", $car;
        echo "<br>Time spent when travelling by Bike: ", $bike;
        echo "<br>Time spent when travelling by Electric Bike: ", $electricBike;
        echo "<br>Time spent when travelling by Walk: ", $walk;
        echo "<br>Time spent when travelling by Public Transport: ", $publicTran;
    }

    #This is a horrible function
    function displayCoordinates($start, $end, $startCoordinates, $endCoordinates){
        echo "<br>Start : ", $start,"-->(", $startCoordinates, ")<br>";
        echo "End : ", $end, "-->(", $endCoordinates,")<br>";

    }


    #____________________
    #This function displays the CO2 equivalence in either cheese sandwiches, plastic bags or tumble drying sessions for the trip, chosen randomly.
    #The function takes in CO2 for the trip given every transportation mode and then prints out nr of sandwiches/plasticbags/tumble dryer sessions
    #that the trip equivalates to.
    #____________________
    function carbonEquivalent($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran)
    {
        //how many grams of CO2 is (approx) the emissions from either a cheese sandwich, plasticbag and dryer(which one of them is chosen randomly).
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
        
    //return the equivalent numbers of items in this order: plastic bags, cheese sandwich, nr of tumble drying sessions
        echo "<br><h4>Carbon Equivalence</h4>";
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Gas Car : " , number_format($gas / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Diesel Car : " , number_format($diesel / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Electric Car : " , number_format($electric / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Bike : " , number_format($bike / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Electric Bike : " , number_format($electricBike / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Walking : " , number_format($walk / $RandomMeasure, 1) , " " , $houseHoldItem ;
        echo "<br>CO2 equivalence measured in " , $houseHoldItem , " when travelling by Public Transport : " , number_format($publicTran / $RandomMeasure, 1) , " " , $houseHoldItem ;
    }


?>