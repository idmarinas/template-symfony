# Useful Commands

> En una terminal debian (WSL)
> Permite guardar la credencial de la key

```bash
    eval $(ssh-agent) && ssh-add
```

## Download TailwindCSS Standalone CLI

wget https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.11/tailwindcss-linux-x64-musl -P
/var/www/html/var/tailwind/cli
chmod +x /var/www/html/var/tailwind/cli/tailwindcss-linux-x64-musl

## Search Replace

> **Search**: "symfony/(.+)": "7.3.*"  
> **Replace**: "symfony/$1": "7.4.*"
