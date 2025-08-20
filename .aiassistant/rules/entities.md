---
apply: off
---

# Reglas para Entities de Doctrine

## Estructura

- Usar attributes de Doctrine ORM 3.5.0
- Implementar __toString() cuando sea apropiado
- Usar tipos de datos específicos (int, string, DateTime, etc.)
- Implementar interfaces relevantes (\JsonSerializable, etc.)

## Propiedades

- Definir todas las propiedades como private o readonly cuando sea posible
- Preferir property hooks (PHP 8.4+) en lugar de getters y setters tradicionales
- Usar accessors (get, set) para lógica adicional o validación específica
- Usar value objects para conceptos de dominio complejos
- Usar enums para valores limitados (PHP 8.1+)

## Relaciones

- Definir relaciones bidireccionales cuando sea necesario
- Establecer claramente el propietario de la relación
- Usar cascade apropiadamente (persist, remove, etc.)
- Implementar métodos helper para colecciones (addItem, removeItem)

## Validación

- Usar Symfony Validator constraints
- Agrupar validaciones por contexto cuando sea necesario
- Implementar validaciones personalizadas para reglas complejas
- Validar en la Entity, no en el Controller

## Ciclo de Vida

- Usar ORM Lifecycle Callbacks para lógica simple (timestamps, etc.)
- Usar Entity Listeners para lógica más compleja
- Configurar índices para optimizar consultas frecuentes

## Property Hooks (PHP 8.4+)

- Usar property hooks para acceso y modificación controlada de propiedades
- Implementar validación y lógica de negocio directamente en los hooks
- Definir propiedades readonly para valores inmutables
- Ejemplo de property hook:

```php
public string $email {
    get;
    set {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }
        $value = $value;
    }
}
```

## Ejemplo:

```php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public readonly ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 50)]
    #[ORM\Column(type: 'string', length: 50)]
    public string $name {
        get;
        set;
    }

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    public string $email {
        get;
        set;
    }

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(targetEntity: Post::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $posts {
        get;
        set;
    }

    // Ejemplo de una propiedad con validación en el setter
    private string $password {
        get;
        set {
            // Validar que la contraseña tenga al menos 8 caracteres
            if (strlen($value) < 8) {
                throw new \InvalidArgumentException('Password must be at least 8 characters long');
            }
            $value = $value;
        }
    }

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->author = $this; // Usando property hook en lugar de setter
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            if ($post->author === $this) {
                $post->author = null; // Usando property hook en lugar de setter
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt->format('c')
        ];
    }
}
```
