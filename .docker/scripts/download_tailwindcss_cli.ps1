param(
  [String]$Version,
  [Boolean]$Windows
)

[String]$ProjectDir = (Get-Item $PSScriptRoot).Parent.Parent.FullName
[String]$CliPath = Join-Path -Path $ProjectDir -ChildPath "var\tailwind\cli"
[String]$LinuxFile = "tailwindcss-linux-x64-musl"
[String]$WindowsFile = "tailwindcss-windows-x64.exe"
[String]$LinuxPath = Join-Path -Path $CliPath -ChildPath $LinuxFile
[String]$WindowsPath = Join-Path -Path $CliPath -ChildPath $WindowsFile
[String]$InstalledVersion = ""

if (Test-Path -Path $WindowsPath)
{
  $startInfo = New-Object System.Diagnostics.ProcessStartInfo
  $startInfo.FileName = $WindowsPath
  $startInfo.Arguments = "--help"
  $startInfo.RedirectStandardOutput = $true
  $startInfo.UseShellExecute = $false


  $process = New-Object System.Diagnostics.Process
  $process.StartInfo = $startInfo
  $process.Start() | Out-Null
  $process.WaitForExit()

  $InstalledVersion = $process.StandardOutput.ReadLine() -replace "\e\[[0-9;]*m", ""
  $InstalledVersion = $InstalledVersion.Split(" ")[-1].Trim().TrimStart("v")
}

# Get last version tag of TailwindCSS
$url = "https://github.com/tailwindlabs/tailwindcss/releases/latest"
$response = Invoke-WebRequest -Uri $url -MaximumRedirection 0 -ErrorAction SilentlyContinue
$finalUrl = $response.Headers["Location"]

[String]$VersionDefault = $finalUrl.Split("/")[-1].TrimStart("v").ToString()
[Boolean]$WindowsDefault = $true

if ($InstalledVersion -eq $VersionDefault)
{
  Write-Host "The latest version is already installed" -ForegroundColor Blue

  exit
}

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
    $yes = @("t", "y", "ye", "yes")
    $no = @("f", "n", "no", "not")
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

[String]$Url = "https://github.com/tailwindlabs/tailwindcss/releases/download"
[String]$LinuxUrl = "$Url/v$Version/$LinuxFile".Trim()
[String]$WindowsUrl = "$Url/v$Version/$WindowsFile".Trim()

Write-Host "Downloading v$Version version of TailwindCSS" -ForegroundColor Blue

# Create the folder if it does not exist
if (-not (Test-Path -Path $CliPath))
{
  try
  {
    New-Item -ItemType Directory -Path $CliPath
    Write-Host "Directory created at $CliPath" -ForegroundColor Green
  }
  catch
  {
    Write-Host "Failed to create directory at $CliPath. Please check permissions." -ForegroundColor Red
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
