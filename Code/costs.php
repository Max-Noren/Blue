<!------------------- 
#
#This file contain cost related functions
#
#calculateCost -> Manually tested
#
-------------------->

<?php

#_________________
# This function calculates the cost for the trip for each mode of transport (gascar, dieselcar and BEV).
# The functions inputs are distance for the trip (km), prise for the fuel type (kr/liter) and the fuel consumtion(liter/km).
#_______________
function calculateCost($km, $fuelPrice, $consumption){
    
    $costForTheTrip = $km * $consumption * $fuelPrice;
    $costForTheTrip = number_format($costForTheTrip, 1);
        return $costForTheTrip;
}

?>