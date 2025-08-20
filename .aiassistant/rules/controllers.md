---
apply: off
---

# Reglas para Controllers de Symfony

## Estructura Base

- Extiende AbstractController
- Usa Route attributes (no anotaciones)
- Organiza por funcionalidad, no por recurso
- Mantén los controllers delgados, delega lógica a services

## Validación

- Valida Request con Symfony Validator
- Usa FormType para formularios complejos
- Implementa validación de CSRF
- Maneja errores de validación de manera consistente

## Respuestas

- JsonResponse para APIs (con códigos HTTP apropiados)
- render() para templates Twig
- Usa flash messages para notificaciones al usuario
- Implementa paginación para colecciones grandes

## Rutas

- Usa nombres descriptivos para las rutas
- Implementa versionado para APIs (v1, v2, etc.)
- Mantén consistencia en el estilo de URLs
- Agrupa rutas relacionadas

## Seguridad

- Implementa @IsGranted o $this->denyAccessUnlessGranted()
- Verifica permisos antes de operaciones críticas
- Protege contra CSRF en operaciones modificadoras

## Ejemplo:

```php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService,
        private UserRepository $userRepository
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();
        return $this->json($users);
    }

    #[Route('', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $this->json(['errors' => $form->getErrors(true)], Response::HTTP_BAD_REQUEST);
        }

        $this->userService->create($user);
        return $this->json($user, Response::HTTP_CREATED);
    }
}
```
