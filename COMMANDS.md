# Useful Commands

## Guardar credenciales (key) en Debian

```bash
    eval $(ssh-agent) && ssh-add
```

## Migrations

Generar una nueva migración

```bash 
  symfony doctrine:migrations:diff
```

Migrar la base de datos o a una versión concreta

```bash
  symfony doctrine:migrations:migrate 'DoctrineMigrations\Version20210707115250' 
```

Fusionar histórico de migraciones

```Bash
  symfony doctrine:migrations:diff --from-empty-schema
```

Saltar una migración

```bash
  symfony doctrine:migrations:version 'DoctrineMigrations\Version20221216162459' --add
```

# Encrypt Cache

First, you need to generate a secure key and add it to your secret store as CACHE_DECRYPTION_KEY:

```bash
php -r 'echo base64_encode(sodium_crypto_box_keypair()); echo "\n";'
```
