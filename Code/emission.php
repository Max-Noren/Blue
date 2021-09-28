<?php 
    #____________________
    #This file contain emission related functions
    #____________________



    #____________________
    # This function calculated the total emission for the route, using
    # inputs for emission & distance, then prints it out. 
    #____________________
    function calculateEmission($emission, $distance)
    {
        return $emission*$distance;
        #$tot_emission = $emission * $distance;
        #echo "The total emission for your route is: " . $tot_emission . "g CO2" . '<br><br><br>';
    }




?>