param(
  [String]$Version,
  [Boolean]$Windows
)

[String]$VersionDefault = "4.0.14"
[Boolean]$WindowsDefault = $false

if (-not $Version)
{
  $Version = Read-Host "Please enter the version of TailwindCSS to download (Default $VersionDefault)"

  if (-not $Version)
  {
    $Version = $VersionDefault
  }
}

if (-not $Windows)
{
  $WindowsInput = Read-Host "Do you want the Windows version too? (Default $WindowsDefault)"

  if (-not $WindowsInput)
  {
    $Windows = $WindowsDefault
  }
  else
  {
    $yes = @("y", "ye", "yes")
    $no = @("n", "no", "not")
    if ($yes -contains $WindowsInput)
    {
      $Windows = $true
    }
    elseif ($no -contains $WindowsInput)
    {
      $Windows = $false
    }
    else
    {
      try
      {
        $Windows = [bool]::Parse($WindowsInput)
      }
      catch
      {
        Write-Host "The input '$WindowsInput' is invalid. Please enter 'y', 'yes', 'n', 'no', 'true' or 'false'." -ForegroundColor Red

        exit
      }
    }
  }
}

[String]$FolderPath = "F:\Projects\template-symfony\var\tailwind\cli"
[String]$LinuxFile = "tailwindcss-linux-x64-musl"
[String]$WindowsFile = "tailwindcss-windows-x64.exe"
[String]$Url = "https://github.com/tailwindlabs/tailwindcss/releases/download"
[String]$LinuxUrl = "$Url/v$Version/$LinuxFile".Trim()
[String]$WindowsUrl = "$Url/v$Version/$WindowsFile".Trim()
[String]$LinuxPath = Join-Path -Path $FolderPath -ChildPath $LinuxFile
[String]$WindowsPath = Join-Path -Path $FolderPath -ChildPath $WindowsFile

Write-Host "Downloading v$Version version of TailwindCSS" -ForegroundColor Blue

# Create the folder if it does not exist
if (-not (Test-Path -Path $FolderPath))
{
  try
  {
    New-Item -ItemType Directory -Path $FolderPath
    Write-Host "Directory created at $FolderPath" -ForegroundColor Green
  }
  catch
  {
    Write-Host "Failed to create directory at $FolderPath. Please check permissions." -ForegroundColor Red
    exit
  }
}

# Download the file using BitsTransfer
try
{
  Start-BitsTransfer -Source $LinuxUrl -Destination $LinuxPath
  Write-Host "Linux version downloaded successfully to $LinuxPath".Trim() -ForegroundColor Green
}
catch
{
  Write-Host "Failed to download the Linux version from $LinuxUrl" -ForegroundColor Red
  exit
}

# Download the file using BitsTransfer
if ($Windows)
{
  try
  {
    Start-BitsTransfer -Source $WindowsUrl -Destination $WindowsPath
    Write-Host "Windows version downloaded successfully to $WindowsPath" -ForegroundColor Green
  }
  catch
  {
    Write-Host "Failed to download the Windows version from $WindowsUrl" -ForegroundColor Red
    exit
  }
}
