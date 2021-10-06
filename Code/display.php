<!------------------- 
#
#This file contain all print functions for outputting
#and displaying data
#
#display.php -> Manually tested and compared against results
#from openrouteservice.org
#
-------------------->

<html>
<head>
    <!-- Font used for the icons -->
    <script src="https://kit.fontawesome.com/5599b9237b.js" crossorigin="anonymous"></script>
</head>
</html>

<?php

    #____________________
    #This function calculates the CO2 equivalence in either cheese sandwiches, plastic bags 
    #or tumble drying sessions for the trip, chosen randomly.
    #
    #The function takes in CO2 for the trip given every transportation mode and then prints
    #out nr of sandwiches/plasticbags/tumble dryer sessions that the trip equivalates to.
    #____________________
    function calculateHouseHoldItems($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran)
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
        
        $gasHouseHoldItems = number_format($gas / $RandomMeasure, 1);
        $dieselHouseHoldItems = number_format($diesel / $RandomMeasure, 1);
        $electricHouseHoldItems = number_format($electric / $RandomMeasure, 1);
        $bikeHouseHoldItems = number_format($bike / $RandomMeasure, 1);
        $electricBikeHouseHoldItems = number_format($electricBike / $RandomMeasure, 1);
        $walkHouseHoldItems = number_format($walk / $RandomMeasure, 1);
        $publicTranHouseHoldItems = number_format($publicTran / $RandomMeasure, 1);

        //return the type of household item and the equivalent numbers of household items
        return array($houseHoldItem, $gasHouseHoldItems, $dieselHouseHoldItems, $electricHouseHoldItems, 
        $bikeHouseHoldItems, $electricBikeHouseHoldItems, $walkHouseHoldItems, $publicTranHouseHoldItems);
    }

    #Converts minutes into hours and minutes format
    function convertToHoursMins($time) {
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        if($hours == 0){
            $format = '%2d min';
            return sprintf($format, $minutes);
        }
        $format = '%2dh %2d min';
        return sprintf($format, $hours, $minutes);
    }

    #Converts grams into kilograms and kilograms into tonnes
    function convertToTonnesKilos($grams) {
        $kilos = floor($grams / 1000);
        $tonnes = floor($grams / 1000000);
        //$minutes = ($time % 60);
        if($kilos == 0){
            $format = '%2d g';
            return sprintf($format, $grams);
        }
        if($tonnes == 0){
            $format = '%2d kg';
            return sprintf($format, $kilos);
        }
        else{
            $format = '%2d t';
            return sprintf($format, $tonnes);  
        }
    }

    #Displays all the data in a table
    function displayTable($carTime, $bikeTime, $electricBikeTime, $walkTime,
        $publicTranTime, $gas, $diesel, $electric, $bike, $electricBike, $walk, 
        $publicTran, $carDistance, $bikeDistance, $walkDistance, $publicTranDistance){

        #Mouseover tooltips
        $toolTipGas = 'In general high emission and best avoided. To improve your individual carbon emission try car sharing with other commuters.';
        $toolTipDiesel = 'Lower carbon emissions than gas car but higher nitrogen oxides which are harmful for humans. In general take the same considerations as with gas driven cars.';
        $toolTipElectric = 'BEV stands for Battery Electric Vehicle. They have no tailpipe emissions and do not contribute to pollution in our cities. Their emissions come from producing the electricity they consume. Please share your commute!';
        $toolTipWalk = 'Good for the environment and good for your health! It might just take some time depending on your commute.';
        $toolTipBike = 'The same benefits as walking but faster!';
        $toolTipElectricBike = 'More efficent than taking the car but less beneficial as a normal bike in terms of health and enviornment. (Allows you to decide how sweaty you are for the next meeting! ;) )';
        $toolTipTran = 'Sharing is caring! Your carbon emission may vary depending on your choice of public transportation. The CO2e values in this column represents an avarage between diesel buses and trams. A good alternative if you do not have the option to walk or bike.';
        $tooTipCO2e = 'CO2e stands for Carbon Dioxide Equivalence and is a measure of carbon dioxide resulting from in this case your travel. Lower is better.';
        $toolTipTime ='The duration of your trip in hours and minutes.';
        $toolTipDistance = 'The distance in kilometers for your trip, remember that different travel option may have different available routes.';
        $toolTipHouseHoldItem = 'Your trip’s emissions converted to the same emission caused by this many';

        #ignore
        $easterEgg1 = '*COUGH COUGH*';
        $easterEgg2 = '*cough cough cough*';
        $easterEgg3 = 'Bzz!';
        $easterEgg4 = ':)';
        $easterEgg5 = 'Swooosh!!!';
        $easterEgg6 = 'Are we there yet?';

        list($houseHoldItem, $gasHouseHoldItems, $dieselHouseHoldItems, $electricHouseHoldItems, 
        $bikeHouseHoldItems, $electricBikeHouseHoldItems, $walkHouseHoldItems, $publicTranHouseHoldItems) = 
            calculateHouseHoldItems($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran);

            echo "<br><br>";
            echo "<table style='width:70%;margin-left:auto;margin-right:auto;' bordercolor='#ffffff'>";

                // Outputs icons
                echo "<tr>";
                echo "<th></th>";
                echo "<th colspan='3' style='text-align:center;'>" . '<i class="fas fa-car fa-3x"></i>' . "</th>";
                echo "<th style='text-align:center;'>" . '<i class="fas fa-walking fa-3x"></i>' . "</th>";
                echo "<th colspan='2' style='text-align:center;'>" . '<i class="fas fa-bicycle fa-3x"></i>' . "</th>";
                echo "<th style='text-align:center;'>" . '<i class="fas fa-bus fa-3x"></i>' . "</th>";
                echo "<tr>";

                // Outputs headers
                echo "<tr>";
                echo "<th></th>";
                echo "<th title='$toolTipGas'>Gas</th>";
                echo "<th title='$toolTipDiesel'>Diesel</th>";
                echo "<th title='$toolTipElectric'>BEV</th>";
                echo "<th title='$toolTipWalk'>Walking</th>";
                echo "<th title='$toolTipBike'>Cycling</th>";
                echo "<th title='$toolTipElectricBike'>Electric cycling</th>";
                echo "<th title='$toolTipTran'>Public Transport</th>";
                echo "<tr>";

                // Outputs the CO2 values
                echo "<tr>";
                echo "<th title='$tooTipCO2e' style='text-align:right;'>CO2e</th>";
                echo "<td title='$easterEgg1'>" . convertToTonnesKilos($gas) . "</td>";
                echo "<td title='$easterEgg2'>" . convertToTonnesKilos($diesel) . "</td>";
                echo "<td title='$easterEgg3'>" . convertToTonnesKilos($electric) . "</td>";
                echo "<td title='$easterEgg4'>" . convertToTonnesKilos($walk) . "</td>";
                echo "<td title='$easterEgg4'>" . convertToTonnesKilos($bike) . "</td>";
                echo "<td title='$easterEgg4'>" . convertToTonnesKilos($electricBike) . "</td>";
                echo "<td title='$easterEgg4'>" . convertToTonnesKilos($publicTran) . "</td>";
                echo "</tr>";

                // Outputs time
                echo "<tr>";
                echo "<th title='$toolTipTime' style='text-align:right;'>Time</th>";
                echo "<td>" . convertToHoursMins($carTime) . "</td>"; // gas
                echo "<td>" . convertToHoursMins($carTime) . "</td>"; // diesel
                echo "<td>" . convertToHoursMins($carTime) . "</td>"; // electric
                echo "<td>" . convertToHoursMins($walkTime) . "</td>";
                echo "<td title='$easterEgg5'>" . convertToHoursMins($bikeTime) . "</td>";
                echo "<td title='$easterEgg5'>" . convertToHoursMins($electricBikeTime) . "</td>";
                echo "<td title='$easterEgg6'>" . convertToHoursMins($publicTranTime) . "</td>";
                echo "</tr>";

                // Outputs distance
                echo "<tr>";
                echo "<th title='$toolTipDistance' style='text-align:right;'>Distance</th>";
                echo "<td>$carDistance km</td>"; // gas
                echo "<td>$carDistance km</td>"; // diesel
                echo "<td>$carDistance km</td>"; // electric
                echo "<td>$walkDistance km</td>";
                echo "<td>$bikeDistance km</td>"; // bike
                echo "<td>$bikeDistance km</td>"; // electric bike
                echo "<td>$publicTranDistance km</td>";
                echo "</tr>";

                // Outputs number of household items
                echo "<tr>";
                echo "<th title='$toolTipHouseHoldItem $houseHoldItem' style='text-align:right;'>$houseHoldItem</th>";
                echo "<td>$gasHouseHoldItems</td>"; // gas
                echo "<td>$dieselHouseHoldItems</td>"; // diesel
                echo "<td>$electricHouseHoldItems</td>"; // electric
                echo "<td>$walkHouseHoldItems</td>";
                echo "<td>$bikeHouseHoldItems</td>"; // bike
                echo "<td>$electricBikeHouseHoldItems</td>"; // electric bike
                echo "<td>$publicTranHouseHoldItems</td>";
                echo "</tr>";
        
            echo "</table>";
    }


?>