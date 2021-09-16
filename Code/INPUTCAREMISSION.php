<?php

#____________________
#Upon press of the 'Calculate' button it runs function input_co2()
#____________________

if($_GET['btn_submit'])
{
    input_co2($_GET['quantity']);
}


#____________________
#Function that takes a variable and prints it
#____________________

 function input_co2($quantity)#$quantity);
 {
     echo "This is your emission!  --> " . $quantity;
 }


?>

<html>
    <body>
        <form >
            <!-- Number input with limit from 0<x<300 -->
            Please input your car's emission in g/km
            <input type="number" id="quantity" name="quantity" min="0" max="300">
            
            <!-- Button to calculate -->
            <input type="submit" name="btn_submit" value="My Carbon Footprint?" />
        </form>
    </body>
</html>

