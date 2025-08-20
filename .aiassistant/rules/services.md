---
apply: off
---

# Reglas para Services de Symfony

## Principios Generales

- Implementar un propósito único (Single Responsibility)
- Utilizar inyección de dependencias
- Definir servicios como final cuando sea posible
- Preferir immutabilidad

## Estructura

- Organizar servicios por dominio o funcionalidad
- Implementar interfaces para abstracciones importantes
- Usar traits para código compartido cuando sea apropiado
- Mantener métodos pequeños y enfocados

## Dependencias

- Inyectar solo las dependencias necesarias
- Usar constructor injection sobre setter injection
- Evitar service locator pattern cuando sea posible
- Considerar tagged services para extensibilidad

## Manejo de Errores

- Lanzar excepciones específicas y descriptivas
- Documentar excepciones en PHPDoc
- Implementar logging apropiado con Monolog
- Usar try/catch solo cuando se pueda manejar el error

## Transacciones

- Usar EntityManager para transacciones
- Asegurar atomicidad en operaciones relacionadas
- Manejar rollbacks apropiadamente

## Ejemplo:

```php
namespace App\Service;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EventDispatcherInterface $eventDispatcher,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates a new user
     * 
     * @throws UserAlreadyExistsException If email already exists
     */
    public function create(User $user, string $plainPassword): User
    {
        // Check if user already exists
        if ($this->userRepository->findOneBy(['email' => $user->getEmail()])) {
            $this->logger->warning('Attempted to create user with existing email', [
                'email' => $user->getEmail()
            ]);
            throw new UserAlreadyExistsException('A user with this email already exists');
        }

        // Hash password
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Save user
        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->entityManager->commit();

            // Dispatch event
            $this->eventDispatcher->dispatch(new UserCreatedEvent($user));

            $this->logger->info('User created successfully', [
                'id' => $user->getId(),
                'email' => $user->getEmail()
            ]);

            return $user;
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $this->logger->error('Failed to create user', [
                'exception' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
```
