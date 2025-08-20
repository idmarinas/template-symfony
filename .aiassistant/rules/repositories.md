---
apply: off
---

# Reglas para Repositories de Doctrine

## Estructura

- Extender ServiceEntityRepository
- Usar constructor para registrar la entity class
- Mantener métodos pequeños y enfocados
- Nombrar métodos descriptivamente (findActiveUsers vs getUsers)

## Consultas

- Usar QueryBuilder para consultas complejas
- Implementar paginación para resultados grandes
- Optimizar consultas (JOIN, indexing, etc.)
- Usar parámetros con nombre para prevenir SQL injection

## DQL y SQL

- Preferir DQL sobre SQL nativo cuando sea posible
- Documentar consultas SQL nativas
- Usar funciones de agregación apropiadamente
- Implementar resultados cacheables cuando sea útil

## Relaciones

- Manejar apropiadamente eager y lazy loading
- Evitar N+1 query problem
- Usar JOINs para optimizar consultas relacionadas
- Considerar DTOs para resultados personalizados

## Manejo de Errores

- Manejar NoResultException apropiadamente
- Documentar comportamiento esperado en PHPDoc
- Incluir manejo de valores nulos

## Ejemplo:

```php
namespace App\Repository;

use App\Entity\User;
use App\Model\UserSearchCriteria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Finds users by criteria with pagination
     *
     * @return Paginator<User>
     */
    public function findByCriteria(UserSearchCriteria $criteria, int $page = 1, int $limit = 10): Paginator
    {
        $qb = $this->createQueryBuilder('u')
            ->leftJoin('u.posts', 'p')
            ->addSelect('p'); // Avoid N+1 problem

        $this->applyCriteriaToQueryBuilder($qb, $criteria);

        $qb->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit);

        return new Paginator($qb->getQuery());
    }

    /**
     * Finds active admins
     *
     * @return User[]
     */
    public function findActiveAdmins(): array
    {
        return $this->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->andWhere('u.isActive = :active')
            ->setParameter('role', '%ROLE_ADMIN%')
            ->setParameter('active', true)
            ->orderBy('u.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Gets user statistics
     *
     * @return array<string, int>
     */
    public function getUserStats(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT
                COUNT(*) as total_users,
                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_users,
                SUM(CASE WHEN created_at >= :last_month THEN 1 ELSE 0 END) as new_users
            FROM users
        ';

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery([
            'last_month' => (new \DateTime('first day of last month'))->format('Y-m-d')
        ]);

        return $result->fetchAssociative();
    }

    private function applyCriteriaToQueryBuilder(QueryBuilder $qb, UserSearchCriteria $criteria): void
    {
        if ($criteria->getName()) {
            $qb->andWhere('u.name LIKE :name')
               ->setParameter('name', '%' . $criteria->getName() . '%');
        }

        if ($criteria->getEmail()) {
            $qb->andWhere('u.email LIKE :email')
               ->setParameter('email', '%' . $criteria->getEmail() . '%');
        }

        if ($criteria->getRole()) {
            $qb->andWhere('u.roles LIKE :role')
               ->setParameter('role', '%' . $criteria->getRole() . '%');
        }

        if ($criteria->getIsActive() !== null) {
            $qb->andWhere('u.isActive = :isActive')
               ->setParameter('isActive', $criteria->getIsActive());
        }
    }
}
```
