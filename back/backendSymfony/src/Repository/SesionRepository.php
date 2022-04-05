<?php

namespace App\Repository;

use App\Entity\Sesion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sesion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sesion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sesion[]    findAll()
 * @method Sesion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SesionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sesion::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Sesion $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Sesion $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function selectAllbyTodayTill7daysAfter()
    {
        return $this->createQueryBuilder('s')
            ->where('s.fecha >= :a')
            ->andWhere('s.fecha  <= :b')
            ->setParameter('a', date('Y-m-d'))
            ->setParameter('b', date('Y-m-d', strtotime('+6days')))
            ->orderBy('s.fecha')
            ->getQuery()
            ->getResult();
    }

    public function selectOneSesion($idSesion)
    {
        return $this->createQueryBuilder('s')
            ->where('s.id = :idSesion')
            ->setParameter('idSesion', $idSesion)
            ->getQuery()
            ->getResult();
    }

    public function guardarButacasOcupadas($butacasOcupadas, $idSesion)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "UPDATE sesion SET butacas_ocupadas = '$butacasOcupadas' WHERE id = $idSesion";
        $conn->prepare($sql)->executeQuery();
    }

    public function anadirSesion($dataSesion)
    {
        // print_r($dataSesion);
        foreach ($dataSesion as $sesion => $data) {
            $$sesion = $data;
        }

        if ($this->comprovarExisteSesion($fecha)) {
            $conn = $this->getEntityManager()->getConnection();
            $sql = "INSERT INTO `sesion`(fecha, hora, vip, dia_espectador, id_peli, nombre_peli, ano_peli, img_peli) 
                    VALUES ('$fecha', '$hora', $vip, $diaEspectador, '$idPeli', '$nombrePeli', '$anoPeli', '$imgPeli')";
            $conn->prepare($sql)->executeQuery();
            $r = 1;
        } else {
            $r = 0;
        }

        return $r;
    }

    public function comprovarExisteSesion($fecha)
    {
        $res = $this->createQueryBuilder('s')
            ->select('s.id as ID')
            ->where('s.fecha = :fecha')
            ->setParameter('fecha', $fecha)
            ->getQuery()
            ->getResult();

        return (empty($res)) ? 1 : 0;
    }

    // /**
    //  * @return Sesion[] Returns an array of Sesion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sesion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
