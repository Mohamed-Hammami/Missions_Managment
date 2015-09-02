<?php
/**
 * Created by PhpStorm.
 * User: Pegasus
 * Date: 29/08/2015
 * Time: 14:51
 */

namespace MP\TimeSheetBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MP\TimeSheetBundle\Entity\MainContact;

class LoadMainContactData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $mContact = new MainContact();
        $mContact->setName('John');
        $mContact->setSurname('Coppi');
        $mContact->setContactPost('PDG');
        $mContact->setTelNum('95871236');
        $mContact->setEmail('JohnCoppi@gmail.com');

        $manager->persist($mContact);
        $manager->flush();

        $this->addReference('client-john', $mContact);

        $mContact = new MainContact();
        $mContact->setName('Cobby');
        $mContact->setSurname('Eichler');
        $mContact->setContactPost('PDG');
        $mContact->setTelNum('97876236');
        $mContact->setEmail('CobbyEichler@gmail.com');

        $manager->persist($mContact);
        $manager->flush();

        $this->addReference('client-cobby', $mContact);

        $mContact = new MainContact();
        $mContact->setName('Christiano');
        $mContact->setSurname('Riccio');
        $mContact->setContactPost('PDG');
        $mContact->setTelNum('97878226');
        $mContact->setEmail('ChristianoRiccio@gmail.com');

        $manager->persist($mContact);
        $manager->flush();

        $this->addReference('client-christiano', $mContact);

    }

    public function getOrder()
    {
        return 1;
    }

} 