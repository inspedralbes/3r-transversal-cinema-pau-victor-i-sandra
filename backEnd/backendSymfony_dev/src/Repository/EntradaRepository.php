<?php

namespace App\Repository;

use App\Entity\Entrada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entrada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrada[]    findAll()
 * @method Entrada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrada::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Entrada $entity, bool $flush = true): void
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
    public function remove(Entrada $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function guardarEntradas($usuario, $sesion, $butaca, $precio)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            INSERT INTO entrada(usuario_id, sesion_id, butaca, precio) 
            VALUES ($usuario, $sesion, '$butaca', $precio) 
            ";
   
        return $conn->prepare($sql)->executeQuery();
    }

    public function seleccionarEntradasUsuario($sesion, $usuario)
    {
        return $this->createQueryBuilder('e')
        ->where('e.usuario = :usuario')
        ->setParameter('usuario', $usuario)
        ->andWhere('e.sesion = :sesion')
        ->setParameter('sesion', $sesion)
        ->getQuery()
        ->getResult();
    }

    public function buscarEntradas($usuario)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT entrada.butaca, entrada.precio, sesion.fecha, sesion.hora, sesion.nombre_peli, sesion.ano_peli, sesion.img_peli FROM entrada JOIN sesion ON sesion_id = sesion.id WHERE entrada.usuario_id = $usuario AND sesion.fecha >= CURDATE();";
        return $conn->prepare($sql)->executeQuery()->fetchAllAssociative();
    }

    public function usuarioTieneEntradas($id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT entrada.*, sesion.fecha FROM entrada JOIN sesion ON sesion.id = entrada.sesion_id where entrada.usuario_id = $id and sesion.fecha >= curdate();";
        return $conn->prepare($sql)->executeQuery()->fetchAllAssociative();
    }



    // /**
    //  * @return Entrada[] Returns an array of Entrada objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entrada
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
