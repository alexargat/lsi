<?php

namespace App\DataFixtures;

use App\Entity\History;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $history = new History();
        $history->setExportDate((new \DateTime)->modify('-1 days'));
        $history->setUsername('User1');
        $history->setName('First export');
        $history->setPlace('Local 1');
        $manager->persist($history);

        $history = new History();
        $history->setExportDate((new \DateTime)->modify('-2 days'));
        $history->setUsername('User2');
        $history->setName('Second export');
        $history->setPlace('Local 1');
        $manager->persist($history);

        $history = new History();
        $history->setExportDate((new \DateTime)->modify('-1 days'));
        $history->setUsername('User1');
        $history->setName('Third export');
        $history->setPlace('Local 2');
        $manager->persist($history);

        $history = new History();
        $history->setExportDate((new \DateTime));
        $history->setUsername('User1');
        $history->setName('Zero export');
        $history->setPlace('Local 2');
        $manager->persist($history);

        $manager->flush();
    }
}
