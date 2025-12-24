<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use App\Entity\Formation;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author Mostaghfera Jan
 */
class FormationTest extends TestCase{
    /**
     * test la format retouner par la fonction de getPublishedAtString
     */
    public function testgetPublishedAtString(){
        $formation = new Formation();
        $formation ->setPublishedAt(new DateTime("2025-12-17"));
        $this->assertEquals("17/12/2025", $formation->getPublishedAtString());
}
    
}
