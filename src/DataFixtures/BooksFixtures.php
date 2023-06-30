<?php

namespace App\DataFixtures;

use App\Entity\Books;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BooksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $book=new Books();
        $book->setTitle('1984');
        $book->setReleaseYear( 1949);
        $book->setDescription(' İngiliz yazar George Orwell tarafından kaleme alınmış olan alegorik, distopik ve politik bir romandır. Distopya romanlarının en ünlülerindendir.');
        $book->setImagePath('https://cdn.pixabay.com/photo/2022/06/27/11/38/propaganda-7287298_1280.jpg');
        //Add Data To Pivot Table
    
       
        $manager->persist($book);
        $manager->flush();

        $book1=new Books();
         $book1->setTitle('Küçük Prens');
         $book1->setReleaseYear(1943);
         $book1->setDescription('Küçük Prens yazara yaşadığı yeri, yaşadığı maceraları anlatmaya başlar.');
         $book1->setImagePath('https://cdn.pixabay.com/photo/2020/05/29/15/09/the-little-prince-5235474_1280.jpg');
         //Add Data To Pivot Table
        
        // // $book1->addWriter($this->getReference('writer_2'));
        

         $manager->persist($book1);
      
         $manager->flush();
         $this->addReference('book_2', $book);
         $this->addReference('book_3', $book);

         
    }
}
