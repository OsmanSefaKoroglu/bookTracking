<?php

namespace App\DataFixtures;

use App\Entity\Writer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WriterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      $writer=new Writer();
      $writer->setName('George Orwel Writer');
      $manager->persist($writer);

      $writer->addBook($this->getReference('book_2'));

      $manager->persist($writer);
      $manager->flush();

      $writer1=new Writer();
      $writer1->setName('Antoine de Saint-Exupéry 3');
      
      $writer->addBook($this->getReference('book_3'));
      
      $manager->persist($writer1);
     
      $manager->flush();
    // $this->addReference('writer_a', $writer);
    //  $this->addReference('writer_2', $writer1);

    }
}
