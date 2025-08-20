---
apply: always
---

# Convenciones de Nomenclatura

Una guía completa sobre cómo nombrar elementos en el proyecto.

## Clases

- Usar **PascalCase** (CamelCase con primera letra mayúscula)
- Descriptivas y en singular: `UserController`, `ProductService`, `PaymentProcessor`
- Sufijos por tipo: `*Controller`, `*Service`, `*Repository`, `*Factory`, etc.

## Métodos y Funciones (PHP)

- Usar **camelCase** (primera letra minúscula)
- Verbos que describan la acción: `getUser()`, `processPayment()`, `validateInput()`
- Métodos booleanos con prefijo `is`, `has`, `can`: `isValid()`, `hasPermission()`, `canEdit()`

## Propiedades y Variables (PHP)

- Usar **camelCase**
- Nombres descriptivos: `$userName`, `$productCount`, `$isActive`
- Evitar abreviaturas no estándar: `$userRepository` en lugar de `$userRepo`

## Variables en Twig

- Usar **snake_case** (minúsculas con guiones bajos)
- Consistente en todo el template: `user_name`, `product_list`, `error_message`
- Misma convención para nombres de bloques: `{% block user_profile %}`

## Archivos y Directorios

- **Archivos PHP de clases**: PascalCase y coincidiendo con el nombre de la clase: `UserController.php`
- **Plantillas Twig**: snake_case: `user_profile.html.twig`
- **Archivos de configuración**: snake_case: `services.yaml`, `security.yaml`
- **Assets** (JS/CSS): snake_case o kebab-case: `app.js`, `main-style.css`

## Constantes

- Usar **UPPER_SNAKE_CASE** (mayúsculas con guiones bajos)
- Descriptivas y completas: `MAX_LOGIN_ATTEMPTS`, `API_BASE_URL`

## Rutas

- Usar **kebab-case** (minúsculas con guiones)
- RESTful cuando sea posible: `/users/`, `/users/{id}`, `/users/{id}/posts`
- Evitar verbos en URLs (usar métodos HTTP): `/users` (GET, POST) en lugar de `/get-users` o `/create-user`

## Bases de Datos

- **Tablas**: snake_case y plural: `users`, `product_categories`
- **Columnas**: snake_case: `first_name`, `created_at`
- **Primary Keys**: `id` o `{tabla_singular}_id`
- **Foreign Keys**: `{tabla_referenciada_singular}_id`: `user_id`, `category_id`

## Enums

- Nombre de enum: PascalCase y singular: `StatusEnum`, `RoleEnum`
- Casos de enum: UPPER_SNAKE_CASE: `StatusEnum::PENDING`, `RoleEnum::ADMIN`

## Ejemplos Completos

### Clase PHP

```php
class UserProfileService
{
    private UserRepository $userRepository;
    private const MAX_PROFILE_IMAGE_SIZE = 1024 * 1024 * 2; // 2MB

    public function getUserProfileData(int $userId): array
    {
        $user = $this->userRepository->find($userId);
        $profileData = [
            'user_name' => $user->getName(),
            'email' => $user->getEmail(),
            'created_at' => $user->getCreatedAt(),
            'is_verified' => $user->isVerified()
        ];

        return $profileData;
    }
}
```

### Plantilla Twig

```twig
{# user/profile.html.twig #}
{% extends 'base.html.twig' %}

{% block user_profile %}
    <div class="user-profile">
        <h1>{{ user_name }}</h1>
        <p>{{ email }}</p>
        <p>Miembro desde: {{ created_at|date('d M Y') }}</p>

        {% if is_verified %}
            <span class="verified-badge">Verificado</span>
        {% endif %}
    </div>
{% endblock %}
```

### Configuración

```yaml
# config/packages/security.yaml
security:
  password_hashers:
    App\Entity\User:
      algorithm: auto
      cost: 12
```
