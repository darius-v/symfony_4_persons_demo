<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
     * @return array
     */
    public function findById(int $id): array
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_ARRAY);
    }
}
