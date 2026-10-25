function Get-Env
{
  param([string]$VarName, [string]$File = "$PSScriptRoot/../../.env")

  $line = Get-Content $File | Where-Object { $_ -match "^$VarName\s*=" } | Select-Object -First 1

  if ($line)
  {
    $value = ($line -split "=", 2)[1].Trim()
    return $value -replace '^["\x27]|["\x27]$', ''
  }
  return $null
}

$appVersion = Get-Env -VarName "APP_VERSION"
$appVersionBuild = Get-Env -VarName "APP_VERSION_BUILD"
$appTitle = Get-Env -VarName "APP_TITLE"
$projectName = Get-Env -VarName "APP_PROJECT_NAME"

Write-Host "Prod Building Docker Imagen" -BackgroundColor Red
Write-Host "$appTitle" -BackgroundColor Green
Write-Host "Tag: $appVersion+build.$appVersionBuild" -BackgroundColor Blue

docker build --target prod -f .docker/Dockerfile -t "idmarinas/${projectName}:$appVersion-build.$appVersionBuild" .
docker image prune -f
