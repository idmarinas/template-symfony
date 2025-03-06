# wget https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.11/tailwindcss-linux-x64-musl -P /var/www/html/var/tailwind/cli
# chmod +x /var/www/html/var/tailwind/cli/tailwindcss-linux-x64-musl

#Invoke-WebRequest -Uri "https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.11/tailwindcss-linux-x64-musl" -OutFile $folderPath

$url = "https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.11/tailwindcss-linux-x64-musl"
$folderPath = "F:\Projects\template-symfony\var\tailwind\cli"
$fileName = "tailwindcss-linux-x64-musl"
$fullPath = Join-Path -Path $folderPath -ChildPath $fileName

# Crear la carpeta si no existe
if (-not (Test-Path -Path $folderPath))
{
  New-Item -ItemType Directory -Path $folderPath
}

# Download the file using BitsTransfer
Start-BitsTransfer -Source $url -Destination $fullPath
