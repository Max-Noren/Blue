<?php

//Replace with your local path for index.php
require 'C:\Users\Joel\Desktop\GIT\Blue\index.php';

class FunctionTest extends \PHPUnit\Framework\TestCase {
    public function testTotalEmission(){
        $result = calculate_co2(2,2);

        $this->assertEquals(4, $result);
    }
}