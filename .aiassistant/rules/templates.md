---
apply: by file patterns
patterns: **/*.html.twig
---

# Reglas para Templates Twig

## Estructura

- Organizar templates en directorios por funcionalidad
- Usar base.html.twig como plantilla principal
- Seguir convención de nombrado: entity_action.html.twig
- Mantener templates pequeños y enfocados

## Herencia y Bloques

- Usar herencia de templates (extends)
- Definir bloques significativos (content, title, stylesheets, etc.)
- Evitar sobrescribir bloques completos, extender cuando sea posible
- Usar include para partes reutilizables

## Variables y Filtros

- Nombrar variables usando snake_case (user_name, product_category, last_login_date)
- Usar filtros para formatear datos (date, number_format, etc.)
- Verificar existencia de variables (is defined, is not null)
- Escapar variables por defecto ({{ var }})
- Usar raw solo cuando sea absolutamente necesario y seguro

## Formularios

- Implementar form_themes para estilizar formularios
- Personalizar renderizado de widgets cuando sea necesario
- Incluir CSRF protection
- Mostrar mensajes de error apropiados

## Internacionalización

- Usar trans filter para traducciones
- Implementar pluralización cuando sea necesario
- Organizar traducciones por dominio

## Seguridad

- Escapar todas las salidas por defecto
- Usar is_granted() para verificar permisos
- No exponer información sensible

## Ejemplo:

```twig
{# templates/user/show.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}{{ user.name }} - User Profile{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
{% endblock %}

{% block content %}
    <div class="profile-container">
        <h1>{{ user.name|escape }}</h1>

        {% if user.avatar %}
            <img src="{{ asset(user.avatar) }}" alt="{{ user.name }}" class="profile-avatar">
        {% else %}
            <div class="profile-avatar-placeholder">{{ user.name|first|upper }}</div>
        {% endif %}

        <div class="profile-details">
            <p><strong>{{ 'Email'|trans }}:</strong> {{ user.email }}</p>
            <p><strong>{{ 'Member since'|trans }}:</strong> {{ user.created_at|date('d M Y') }}</p>

            {% if user.bio is defined and user.bio is not empty %}
                <div class="profile-bio">
                    <h3>{{ 'Biography'|trans }}</h3>
                    <p>{{ user.bio|nl2br }}</p>
                </div>
            {% endif %}

            {% if is_granted('ROLE_ADMIN') or app.user.id == user.id %}
                <div class="profile-actions">
                    <a href="{{ path('app_user_edit', {id: user.id}) }}" class="btn btn-primary">
                        {{ 'Edit profile'|trans }}
                    </a>
                </div>
            {% endif %}

            {% if user.posts|length > 0 %}
                <h3>{{ 'Recent posts'|trans }} ({{ user.posts|length }})</h3>
                <ul class="post-list">
                    {% for post in user.posts|slice(0, 5) %}
                        <li>
                            <a href="{{ path('app_post_show', {id: post.id}) }}">
                                {{ post.title }}
                            </a>
                            <span class="post-date">{{ post.created_at|date('d M Y') }}</span>
                        </li>
                    {% endfor %}
                </ul>

                {% if user.posts|length > 5 %}
                    <a href="{{ path('app_post_index', {author: user.id}) }}" class="btn btn-secondary">
                        {{ 'View all posts'|trans }}
                    </a>
                {% endif %}
            {% else %}
                <p>{{ 'No posts found'|trans }}</p>
            {% endif %}
        </div>
    </div>
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    <script src="{{ asset('js/profile.js') }}"></script>
{% endblock %}
```
