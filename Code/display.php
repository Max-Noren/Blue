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
        $publicTran, $carDistance, $bikeDistance, $walkDistance, $publicTranDistance,
        $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice){

        #Mouseover tooltips
        $toolTipGas = 'In general high emission and best avoided. To improve your individual carbon emission try car sharing with other commuters.';
        $toolTipDiesel = 'Lower carbon emissions than gas car but higher nitrogen oxides which are harmful for humans. In general take the same considerations as with gas driven cars.';
        $toolTipElectric = 'BEV stands for Battery Electric Vehicle. They have no tailpipe emissions and do not contribute to pollution in our cities. Their emissions come from producing the electricity they consume. Please share your commute!';
        $toolTipWalk = 'Good for the environment and good for your health! It might just take some time depending on your commute.';
        $toolTipBike = 'The same benefits as walking but faster!';
        $toolTipElectricBike = 'More efficent than taking the car but less beneficial than a normal bike in terms of health and enviornment. (Allows you to decide how sweaty you are for the next meeting! ;) )';
        $toolTipTran = 'Sharing is caring! Your carbon emission may vary depending on your choice of public transportation. The CO2e values in this column represents an avarage between diesel buses and trams. A good alternative if you do not have the option to walk or bike.';
        $tooTipCO2e = 'CO2e stands for Carbon Dioxide Equivalence and is a measure of carbon dioxide resulting from in this case your travel. Lower is better.';
        $toolTipTime ='The duration of your trip in hours and minutes.';
        $toolTipDistance = 'The distance in kilometers for your trip, remember that different travel option may have different available routes.';
        $toolTipHouseHoldItem = 'Your trip’s emissions converted to the same emission caused by this many';
        $toolTipCost = 'The price for your trip in Swedish Kronor (SEK). The cost is only for the fuel consumed or a Västtrafik ticket within Gothenburg.';

        #Tooltips for CO2 calculations
        $co2infoCars = 'This is calculated using an average value for the Co2 emissions in grams/km and multiplied with the lenght of your trip in km';
        $co2infoZeroemission = 'Close enough to zero to be ignored';
        $co2infoElectricBike = 'Electric bikes consumes small ammounts of electricity and therefor the Co2 emissions per km is very low. While biking within Gothenburg the emissions are close to zero. :)';
        $co2infoPublicTransport = 'This is calculated using an average value of Co2 emissions for different kinds of public transportation methods within Gothenburg (busses, tram etc.). The end result is based on that value, the lenght of the trip and for one passenger.';

        #Tooltips for cost
        $costinfoCars = 'The cost is only for the fuel consumed during your trip (calculated for a car made in 2020)';
        $costinfoElectricCar = 'The cost for the trip with a BEV is based on how much electricity an average BEV consumes measured in kwh/km and the current price of electricity within Gothenburg 2021';
        $costinfoFree = 'This is free!';
        $costinfoElectricBike = 'This is almost free, if you use the bike everyday it will add up to a small cost though so it is not totally free.';
        $costinfoPublicTransport = 'This is the cost of a Västtrafik ticket, valid 90 minutes within Gothenburg.'


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
                echo "<td title='$co2infoCars'>" . convertToTonnesKilos($gas) . "</td>";
                echo "<td title='$co2infoCars'>" . convertToTonnesKilos($diesel) . "</td>";
                echo "<td title='$co2infoCars'>" . convertToTonnesKilos($electric) . "</td>";
                echo "<td title='$co2infoZeroemission'>" . convertToTonnesKilos($walk) . "</td>";
                echo "<td title='$co2infoZeroemission'>" . convertToTonnesKilos($bike) . "</td>";
                echo "<td title='$co2infoElectricBike'>" . convertToTonnesKilos($electricBike) . "</td>";
                echo "<td title='$co2infoPublicTransport'>" . convertToTonnesKilos($publicTran) . "</td>";
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

                
                // Outputs costs
                echo "<tr>";
                echo "<th title='$toolTipCost' style='text-align:right;'>Cost</th>";
                echo "<td title='$costinfoCars'>" . $totalGasPrice . " kr" . "</td>"; //gas
                echo "<td title='$costinfoCars'>" . $totalDieselPrice . " kr" . "</td>"; //diesel


                echo "<td>$totalElectricPrice kr</td>"; // electric
                echo "<td>0 kr</td>"; // walk
                echo "<td>0 kr</td>"; // bike
                echo "<td>0 kr</td>"; // electric bike
                echo "<td>$totalTicketPrice kr</td>";
                echo "</tr>";

            echo "</table>";
    }


?>