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

    #Converts minutes into hours and minutes
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
        $gasPrice, $dieselPrice, $electricPrice,
        $totalGasPrice, $totalDieselPrice, $totalElectricPrice, $totalTicketPrice,
        $gasCarEmission, $dieselCarEmission, $electricCarEmission, $publicTranEmission,
        $gasConsumption, $dieselConsumption, $electricConsumption){
        

        #Mouseover tooltips
        $toolTipGas = 'In general high emission and best avoided. To improve your individual carbon emission try car sharing with other commuters.';
        $toolTipDiesel = 'Lower carbon emissions than gas car but higher nitrogen oxides which are harmful for humans. In general take the same considerations as with gas driven cars.';
        $toolTipElectric = 'BEV stands for Battery Electric Vehicle. They have no tailpipe emissions and do not contribute to pollution in our cities. Their emissions come from producing the electricity they consume. Please share your commute!';
        $toolTipWalk = 'Good for the environment and good for your health! It might just take some time depending on your commute.';
        $toolTipBike = 'The same benefits as walking but faster!';
        $toolTipElectricBike = 'More efficent than taking the car but less beneficial than a normal bike in terms of health and enviornment. (Allows you to decide how sweaty you are for the next meeting! ;) )';
        $toolTipTran = 'Sharing is caring! Your carbon emission may vary depending on your choice of public transportation. The CO2e values in this column represents an avarage between diesel buses and trams. A good alternative if you do not have the option to walk or bike.';
        $toolTipCO2e = 'CO2e stands for Carbon Dioxide Equivalence and is a measure of carbon dioxide resulting from in this case your travel. Lower is better.';
        $toolTipTime ='The duration of your trip in hours and minutes.';
        $toolTipDistance = 'The distance in kilometers for your trip, remember that different travel option may have different available routes.';
        $toolTipHouseHoldItem = 'Your trip’s emissions converted to the same emission caused by this many';
        $toolTipCost = 'The price for your trip in Swedish Kronor (SEK). The cost is only for the fuel consumed or a Västtrafik ticket within Gothenburg.';

        #icon tooltips
        $toolTipCarIcon = 'Half of all trips made by car in Swedish cities (like Gothenburg) are shorter than 5 km, according to Trafikverket. This is unfortunate since there are so many more energyefficient and environmental friendly options, such as public transportation, biking or walking. To take the bike or to walk is also good for your health!';
        $toolTipWalkIcon = 'I was walking home late one night when I saw dozens of giant cupcakes and pies everywhere. It was kind of scary… The streets were oddly desserted.';
        $toolTipBikeIcon = 'Riding a bike is a fast way to get to your destination and has close to zero negative impact on the environment! It is also very good for your health. Just don´t forget your helmet!';
        $toolTipPublicTransportIcon = 'Public transport in Gothenburg consists of buses, trams, and ferries. There are various types of tickets depending on how often you travel, how old you are or if you´re a student. With the same ticket, you can take the bus, the tram or the ferry.';

        #Tooltips for CO2 calculations
        $co2InfoCars1 = 'This is calculated using an average emission value for'; //part 1 of general car co2 emissions statement
        $co2InfoCars2 = 'g Co2/km, multiplied with the lenght of your trip in km'; //part 2 of general car co2 emissions statement
        $co2InfoZeroEmission = 'Close enough to zero to be ignored';
        $co2InfoElectricBike = 'Electric bikes consumes small ammounts of electricity and therefor the Co2 emissions per km is very low. While biking within Gothenburg the emissions are close to zero. :)';
        $co2InfoPublicTransport1 = 'This is calculated using an average value of Co2 emissions for busses and trams, which is'; //part 1
        $co2InfoPublicTransport2 = 'g Co2/km. The end result is based on that value, the lenght of the trip and is calculated for one passenger.'; //part 2

        #Tooltips for cost
        $costInfoCars1 = 'The cost is only for the fuel consumed during your trip. Fuel consumption is at average '; //part 1
        $costInfoCars2 = 'l/km (calculated for a car made in 2020), and the current gas price in august 2021 is'; //part 2
        $costInfoElectricCar1 = 'This cost is based on how much electricity an average BEV consumes measured in kwh/km ('; //part 1
        $costInfoElectricCar2 = 'kwh/km in 2021) and the current price of electricity within Gothenburg 2021 which is'; //part 2
        $costInfoFree = 'This is free!';
        $costInfoElectricBike = 'This is (almost) free. If you use an electric bike everyday for your commute it will add up to a small cost for the electricity used.';
        $costInfoPublicTransport = 'This is the cost of a Zon A Västtrafik ticket in 2021, valid 90 minutes within Gothenburg for an adult. For commuters, this can be made cheaper by buying a Period ticket instead. A 30 day Zon A ticket would cost ~18,9 SEK/trip, a 90 day Zon A ticket would cost ~17 SEK/trip and a 365 day Zon A ticket would only cost ~15,6 SEK/trip! (calculated with the assumption of making a returntrip later the same day and using an average of 21 workdays/month or 255 workdays/year)';

        #tooltip for public transportation distance
        $toolTipPublicTransportDist = 'Disclaimer: This is calculated using the shortest route for a car only and will probably not be a completely accurate representation of the distance for the route using public transportation.';

        #eastereggs
        $easterEgg1 = 'Bzz!'; //BEV
        $easterEgg2 = '*cough cough*'; //cars
        $easterEgg3 = 'Swooosh!!!'; //electric bike
        $easterEgg4 = 'Are we there yet?'; //walk
        $easterEgg5 = 'The bus leaves in a minute...'; //public transport
        $easterEgg6 = 'phew!'; //bike


        list($houseHoldItem, $gasHouseHoldItems, $dieselHouseHoldItems, $electricHouseHoldItems, 
        $bikeHouseHoldItems, $electricBikeHouseHoldItems, $walkHouseHoldItems, $publicTranHouseHoldItems) = 
            calculateHouseHoldItems($gas, $diesel, $electric, $bike, $electricBike, $walk, $publicTran);

            echo "<br><br>";
            echo "<table style='width:70%;margin-left:auto;margin-right:auto;' bordercolor='#ffffff'>";

                // Outputs icons
                echo "<tr>";
                echo "<th></th>";
                echo "<th title='$toolTipCarIcon' colspan='3' style='text-align:center;'>" . '<i class="fas fa-car fa-3x"></i>' . "</th>";
                echo "<th title='$toolTipWalkIcon' style='text-align:center;'>" . '<i class="fas fa-walking fa-3x"></i>' . "</th>";
                echo "<th title='$toolTipBikeIcon' colspan='2' style='text-align:center;'>" . '<i class="fas fa-bicycle fa-3x"></i>' . "</th>";
                echo "<th title='$toolTipPublicTransportIcon' style='text-align:center;'>" . '<i class="fas fa-bus fa-3x"></i>' . "</th>";
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
                echo "<th title='$toolTipCO2e' style='text-align:right;'>CO2e</th>";
                echo "<td title='$co2InfoCars1 gas cars, $gasCarEmission $co2InfoCars2'>" . convertToTonnesKilos($gas) . "</td>"; //gas
                echo "<td title='$co2InfoCars1 diesel cars, $dieselCarEmission $co2InfoCars2'>" . convertToTonnesKilos($diesel) . "</td>"; //diesel
                echo "<td title='$co2InfoCars1 electric cars (BEVs), $electricCarEmission $co2InfoCars2'>" . convertToTonnesKilos($gas) . "</td>"; //BEV
                echo "<td title='$co2InfoZeroEmission'>" . convertToTonnesKilos($walk) . "</td>"; //walk
                echo "<td title='$co2InfoZeroEmission'>" . convertToTonnesKilos($bike) . "</td>"; //bike
                echo "<td title='$co2InfoElectricBike'>" . convertToTonnesKilos($electricBike) . "</td>"; //electric bike
                echo "<td title='$co2InfoPublicTransport1 $publicTranEmission $co2InfoPublicTransport2'>" . convertToTonnesKilos($publicTran) . "</td>"; //public transport
                echo "</tr>";

                
                // Outputs time
                echo "<tr>";
                echo "<th title='$toolTipTime' style='text-align:right;'>Time</th>";
                echo "<td title='$easterEgg2'>" . convertToHoursMins($carTime) . "</td>"; // gas
                echo "<td title='$easterEgg2'>" . convertToHoursMins($carTime) . "</td>"; // diesel
                echo "<td title='$easterEgg1'>" . convertToHoursMins($carTime) . "</td>"; //BEV (electric car)
                echo "<td title='$easterEgg4'>" . convertToHoursMins($walkTime) . "</td>"; //walk
                echo "<td title='$easterEgg6'>" . convertToHoursMins($bikeTime) . "</td>"; //bike
                echo "<td title='$easterEgg3'>" . convertToHoursMins($electricBikeTime) . "</td>"; //electric bike
                echo "<td title='$easterEgg5'>" . convertToHoursMins($publicTranTime) . "</td>"; //public transport
                echo "</tr>";

                // Outputs distance
                echo "<tr>";
                echo "<th title='$toolTipDistance' style='text-align:right;'>Distance</th>";
                echo "<td>$carDistance km</td>"; // gas
                echo "<td>$carDistance km</td>"; // diesel
                echo "<td>$carDistance km</td>"; // BEV (electric car)
                echo "<td>$walkDistance km</td>"; //walk
                echo "<td>$bikeDistance km</td>"; // bike
                echo "<td>$bikeDistance km</td>"; // electric bike
                echo "<td title='$toolTipPublicTransportDist'>" . $publicTranDistance . " km *" . "</td>"; //public transport
                echo "</tr>";

                // Outputs number of household items
                echo "<tr>";
                echo "<th title='$toolTipHouseHoldItem $houseHoldItem' style='text-align:right;'>$houseHoldItem</th>";
                echo "<td>$gasHouseHoldItems</td>"; // gas
                echo "<td>$dieselHouseHoldItems</td>"; // diesel
                echo "<td>$electricHouseHoldItems</td>"; // electric
                echo "<td>$walkHouseHoldItems</td>"; //walk
                echo "<td>$bikeHouseHoldItems</td>"; // bike
                echo "<td>$electricBikeHouseHoldItems</td>"; // electric bike
                echo "<td>$publicTranHouseHoldItems</td>"; //public transport
                echo "</tr>";

                
                // Outputs costs
                echo "<tr>";
                echo "<th title='$toolTipCost' style='text-align:right;'>Cost</th>";
                echo "<td title='$costInfoCars1 $gasConsumption $costInfoCars2 $gasPrice SEK.'>" . $totalGasPrice . " kr" . "</td>"; //gas
                echo "<td title='$costInfoCars1 $dieselConsumption $costInfoCars2 $dieselPrice SEK.'>" . $totalDieselPrice . " kr" . "</td>"; //diesel
                echo "<td title='$costInfoElectricCar1 $electricConsumption $costInfoElectricCar2 $electricPrice SEK/kwh.'>" . $totalElectricPrice . " kr" . "</td>"; // electric
                echo "<td title='$costInfoFree'>" . "0 kr" . "</td>"; // walk
                echo "<td title='$costInfoFree'>" . "0 kr" . "</td>"; // bike
                echo "<td title='$costInfoElectricBike'>" . "0 kr" . "</td>"; // electric bike
                echo "<td title='$costInfoPublicTransport'>" . $totalTicketPrice . " kr" . "</td>"; // public transport cost
                echo "</tr>";

            echo "</table>";


    }

    function displayHoverInfo(){
        echo "<text style='text-indent: 15%;font-style: italic;'>";
        echo "<p>Try hovering the mouse over the icons or outputs below to receive more information.</p>";
    }


?>