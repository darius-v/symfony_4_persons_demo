<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function save(Person $person)
    {
        $em = $this->getEntityManager();
        $em->persist($person);
        $em->flush();
    }

    /**
     * @param int $id
     * @return Person|object
     */
    public function findById(int $id): Person
    {
        return $this->findOneBy(['id' => $id]);
    }
}
