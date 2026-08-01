<?php

namespace tests;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../registration.php";

class NumberPlateValidationTest extends TestCase
{
    public function testValidNumberPlate(){
        $this->assertTrue(isValidNumberPlate("JAS-132"));
    }

    public function testLowecaseNumberPlate(){
        $this->assertTrue(isValidNumberPlate("hah-123"));
    }

    public function testInvalidNumberPlate(){
        $this->assertFalse(isValidNumberPlate("JAS1234"));
    }
}
