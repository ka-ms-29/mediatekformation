<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Formation;
use App\Entity\Playlist;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of FormationValidationsTest
 *
 * @author Mostaghfera Jan
 */
class FormationValidationsTest extends KernelTestCase{
    /**
     * 
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * 
     * @return void
     */
    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }
    
    /**
     * 
     * @return Formation
     */
    public function getFormation(): Formation {
        $playlist = new Playlist();
        $playlist->setName('Playlist test');

        return (new Formation())
            ->setTitle("s")
            ->setVideoId("1234")
            ->setPublishedAt(new DateTime('today')) 
            ->setPlaylist($playlist);
    }
    
    /**
     * 
     * @return void
     */
    public function testValidPublishedAtFormation(): void{ 
        $formation = $this->getFormation();
        $formation->setPublishedAt(new \DateTime('today'));
        $errors = $this->validator->validate($formation);
        $this->assertCount(0, $errors);
    }
    
    /**
     * 
     * @return void
     */
    public function testnonValidPublishedAtFormation(): void{
        $formation = $this->getFormation();
        $formation->setPublishedAt(new \DateTime('+1 day'));
        $errors = $this->validator->validate($formation);
        $this->assertGreaterThan(0, count($errors));
    }
    
}
