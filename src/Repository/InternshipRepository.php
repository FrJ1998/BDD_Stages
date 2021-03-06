<?php

namespace App\Repository;

use App\Entity\Internship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Internship|null find($id, $lockMode = null, $lockVersion = null)
 * @method Internship|null findOneBy(array $criteria, array $orderBy = null)
 * @method Internship[]    findAll()
 * @method Internship[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InternshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Internship::class);
    }

    public function getVisible()
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.visible = 1')
            ->getQuery()
            ->getResult();
    }

    public function getInvisible()
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.visible = 0')
            ->getQuery()
            ->getResult();
    }

    public function getNbVisibleInternships()
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(i.id) as nb')
            ->where('i.visible = 1')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNbInvisibleInternships()
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(i.id) as nb')
            ->where('i.visible = 0')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNbCountry()
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(DISTINCT i.country) as nb')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getNbCity()
    {
        return $this->createQueryBuilder('i')
            ->select('COUNT(DISTINCT i.city) as nb')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findInternshipByDate($nbEntry)
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.visible = 1')
            ->orderBy('i.publishedOn', 'DESC')
            ->setMaxResults($nbEntry)
            ->getQuery()
            ->getResult();
    }

    public function getAlike(Internship $internship)
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->where('i.id != :id AND i.visible = 1 AND i.category = :category AND i.duration = :duration')
            ->setParameter('id', $internship->getId())
            ->setParameter('category', $internship->getCategory())
            ->setParameter('duration', $internship->getDuration())
            ->getQuery();
    }
}
