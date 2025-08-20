---
apply: by file patterns
patterns: **/tests/**/*
---

# Reglas para Tests

## Estructura

- Organizar tests según la estructura del código (Unit, Functional, Integration)
- Nombrar clases de test con sufijo Test (UserServiceTest)
- Agrupar tests por funcionalidad o clase
- Implementar PHPUnit para testing (phpunit/phpunit)

## Tests Unitarios

- Probar una unidad de código aislada
- Usar mocks/stubs para dependencias (PHPUnit mock framework)
- Nombrar métodos de test descriptivamente (test_create_user_success)
- Validar estados, excepciones y comportamientos esperados

## Tests Funcionales

- Probar funcionalidad end-to-end
- Usar WebTestCase para tests de Controllers
- Verificar respuestas HTTP, contenido y redirecciones
- Probar rutas protegidas con autenticación simulada

## Tests de Integración

- Probar interacción entre componentes
- Usar KernelTestCase para tests con container
- Configurar database específica para tests (SQLite)
- Usar fixtures para preparar datos de prueba

## Mejores Prácticas

- Implementar test isolation
- Usar data providers para probar múltiples casos
- Ejecutar test suite completo antes de commit
- Implementar CI/CD con ejecución automática de tests

## Fixtures

- Usar DoctrineFixturesBundle para cargar datos de prueba
- Organizar fixtures por entidad o caso de uso
- Implementar dependencies entre fixtures cuando sea necesario
- Usar FakerPHP para generar datos aleatorios

## Ejemplo:

```php
namespace App\Tests\Service;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Exception\UserAlreadyExistsException;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private EventDispatcherInterface $eventDispatcher;
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->userService = new UserService(
            $this->entityManager,
            $this->userRepository,
            $this->passwordHasher,
            $this->eventDispatcher,
            $this->logger
        );
    }

    public function testCreateUserSuccess(): void
    {
        // Arrange
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setName('Test User');

        $plainPassword = 'password123';
        $hashedPassword = 'hashed_password';

        $this->userRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'test@example.com'])
            ->willReturn(null);

        $this->passwordHasher->expects($this->once())
            ->method('hashPassword')
            ->with($user, $plainPassword)
            ->willReturn($hashedPassword);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())
            ->method('commit');

        $this->eventDispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserCreatedEvent::class));

        // Act
        $result = $this->userService->create($user, $plainPassword);

        // Assert
        $this->assertSame($user, $result);
    }

    public function testCreateUserWithExistingEmailThrowsException(): void
    {
        // Arrange
        $user = new User();
        $user->setEmail('existing@example.com');
        $user->setName('Existing User');

        $existingUser = new User();

        $this->userRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'existing@example.com'])
            ->willReturn($existingUser);

        $this->logger->expects($this->once())
            ->method('warning')
            ->with(
                'Attempted to create user with existing email',
                $this->callback(function ($context) {
                    return isset($context['email']) && $context['email'] === 'existing@example.com';
                })
            );

        // Assert & Act
        $this->expectException(UserAlreadyExistsException::class);
        $this->expectExceptionMessage('A user with this email already exists');

        $this->userService->create($user, 'password123');
    }

    public function testCreateUserRollbackOnException(): void
    {
        // Arrange
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setName('Test User');

        $plainPassword = 'password123';
        $hashedPassword = 'hashed_password';

        $this->userRepository->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $this->passwordHasher->expects($this->once())
            ->method('hashPassword')
            ->willReturn($hashedPassword);

        $this->entityManager->expects($this->once())
            ->method('beginTransaction');

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->entityManager->expects($this->once())
            ->method('flush')
            ->willThrowException(new \Exception('Database error'));

        $this->entityManager->expects($this->once())
            ->method('rollback');

        $this->logger->expects($this->once())
            ->method('error')
            ->with(
                'Failed to create user',
                $this->callback(function ($context) {
                    return isset($context['exception']) && $context['exception'] === 'Database error';
                })
            );

        // Assert & Act
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Database error');

        $this->userService->create($user, $plainPassword);
    }
}
```
