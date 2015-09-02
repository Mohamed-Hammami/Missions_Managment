<?php
/**
 * Created by PhpStorm.
 * User: Pegasus
 * Date: 07/08/2015
 * Time: 18:45
 */

namespace MP\TimeSheetBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MP\TimeSheetBundle\Entity\Nature;

class LoadNatureData implements FixtureInterface
{

    public function load(ObjectManager $manager){

        $names = array(
            'Audit',
            'IT'
        );

        foreach($names as $name){
            $nature = new Nature();
            $nature->setName($name);
            $manager->persist($nature);
        }

        $manager->flush();

    }

} 