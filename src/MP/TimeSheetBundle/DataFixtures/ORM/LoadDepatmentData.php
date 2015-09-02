<?php
/**
 * Created by PhpStorm.
 * User: Pegasus
 * Date: 05/08/2015
 * Time: 17:21
 */

namespace MP\TimeSheetBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MP\TimeSheetBundle\Entity\Department;

class LoadDepartmentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Audit',
            'Tax',
            'Comptabilité',
            'Transaction services TS',
            'IT Advisory'
        );

        foreach($names as $name ){
            $departement = new Department();
            $departement->setName($name);

            $manager->persist($departement);

            $this->addReference($name, $departement);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        return 3;
    }
}