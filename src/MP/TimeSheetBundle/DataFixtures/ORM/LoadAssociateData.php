<?php
/**
 * Created by PhpStorm.
 * User: Pegasus
 * Date: 29/08/2015
 * Time: 15:29
 */

namespace MP\TimeSheetBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MP\TimeSheetBundle\Entity\Associate;

class LoadAssociateData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $associate = new Associate();

        $associate->setName('Baron');
        $associate->setSurname('Holloway');
        $associate->setEmail('BaronHolloway@gmail.com');
        $associate->setUsername('BaronHolloway@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('signataire');
        $associate->setRoles(array('ROLE_ADMIN'));

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Alicia');
        $associate->setSurname('Zamora');
        $associate->setEmail('AliciaZamora@gmail.com');
        $associate->setUsername('AliciaZamora@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('manager');
        $associate->setRoles(array('ROLE_ADMIN'));

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Lyric');
        $associate->setSurname('Hubbard');
        $associate->setEmail('LyricHubbard@gmail.com');
        $associate->setUsername('LyricHubbard@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('chef de mission');

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Warren');
        $associate->setSurname('Hines');
        $associate->setEmail('WarrenHines@gmail.com');
        $associate->setUsername('WarrenHines@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('chef de mission');

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Gabriela');
        $associate->setSurname('Wise');
        $associate->setEmail('GabrielaWise@gmail.com');
        $associate->setUsername('GabrielaWise@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('collaborateur');

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Mark');
        $associate->setSurname('Webb');
        $associate->setEmail('MarkWebb@gmail.com');
        $associate->setUsername('MarkWebb@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('collaborateur');

        $manager->persist($associate);

        $associate = new Associate();

        $associate->setName('Kasey');
        $associate->setSurname('Fields');
        $associate->setEmail('KaseyFields@gmail.com');
        $associate->setUsername('KaseyFields@gmail.com');
        $associate->setDepartment($this->getReference('Audit'));
        $associate->setPost('collaborateur');

        $manager->persist($associate);

        $manager->flush();

    }

    public function getOrder()
    {
        return 4;
    }
} 