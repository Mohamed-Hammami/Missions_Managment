<?php
/**
 * Created by PhpStorm.
 */

namespace MP\TimeSheetBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MP\TimeSheetBundle\Entity\Client;

class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $client = new Client();
        $client->setName('Orange');
        $client->setAdresse('Tunis');
        $client->setSecteurActivite('Telecom');
        $client->setMainContact($this->getReference('client-john'));

        $manager->persist($client);
        $manager->flush();

        $client = new Client();
        $client->setName('Capgemini');
        $client->setAdresse('Paris');
        $client->setSecteurActivite('IT');
        $client->setMainContact($this->getReference('client-cobby'));

        $manager->persist($client);
        $manager->flush();

        $client = new Client();
        $client->setName('Sanofi');
        $client->setAdresse('Paris');
        $client->setSecteurActivite('Pharmacie');
        $client->setMainContact($this->getReference('client-christiano'));

        $manager->persist($client);
        $manager->flush();

    }

    public function getOrder()
    {
        return 2;
    }

}