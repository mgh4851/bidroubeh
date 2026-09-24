[CmdletBinding()]
param()

$ErrorActionPreference = 'Stop'

$repositoryRoot = Split-Path -Parent $PSScriptRoot
$themeName = 'bidrubeh-municipality'
$themeDirectory = Join-Path $repositoryRoot $themeName
$stylePath = Join-Path $themeDirectory 'style.css'
$outputPath = Join-Path $repositoryRoot "$themeName.zip"
$temporaryRoot = Join-Path ([System.IO.Path]::GetTempPath()) ("bidrubeh-theme-" + [guid]::NewGuid().ToString('N'))
$temporaryTheme = Join-Path $temporaryRoot $themeName
$temporaryZip = Join-Path $temporaryRoot "$themeName.zip"

if (-not (Test-Path -LiteralPath $stylePath -PathType Leaf)) {
    throw "Theme header not found: $stylePath"
}

$styleHeader = Get-Content -LiteralPath $stylePath -Raw -Encoding UTF8
$versionMatch = [regex]::Match($styleHeader, '(?m)^\s*Version:\s*(?<version>[^\r\n]+)')
if (-not $versionMatch.Success) {
    throw 'The Version field is missing from style.css.'
}

try {
    New-Item -ItemType Directory -Path $temporaryTheme -Force | Out-Null
    Get-ChildItem -LiteralPath $themeDirectory -Force | ForEach-Object {
        Copy-Item -LiteralPath $_.FullName -Destination $temporaryTheme -Recurse -Force
    }

    Add-Type -AssemblyName System.IO.Compression
    Add-Type -AssemblyName System.IO.Compression.FileSystem
    $zipStream = [System.IO.File]::Open($temporaryZip, [System.IO.FileMode]::CreateNew)
    try {
        $writer = [System.IO.Compression.ZipArchive]::new(
            $zipStream,
            [System.IO.Compression.ZipArchiveMode]::Create,
            $false
        )
        try {
            Get-ChildItem -LiteralPath $temporaryTheme -File -Recurse | ForEach-Object {
                $relativePath = $_.FullName.Substring($temporaryRoot.Length + 1).Replace('\', '/')
                [void][System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
                    $writer,
                    $_.FullName,
                    $relativePath,
                    [System.IO.Compression.CompressionLevel]::Optimal
                )
            }
        }
        finally {
            $writer.Dispose()
        }
    }
    finally {
        $zipStream.Dispose()
    }

    $archive = [System.IO.Compression.ZipFile]::OpenRead($temporaryZip)
    try {
        $fileEntries = @($archive.Entries | Where-Object { -not [string]::IsNullOrEmpty($_.Name) })
        $rootNames = @($fileEntries | ForEach-Object { ($_.FullName -split '[\\/]')[0] } | Sort-Object -Unique)
        if ($rootNames.Count -ne 1 -or $rootNames[0] -ne $themeName) {
            throw "Unexpected archive root: $($rootNames -join ', ')"
        }
        $normalizedNames = @($fileEntries.FullName | ForEach-Object { $_.Replace('\', '/') })
        if ("$themeName/style.css" -notin $normalizedNames) {
            throw 'The generated archive does not contain style.css.'
        }
    }
    finally {
        $archive.Dispose()
    }

    Copy-Item -LiteralPath $temporaryZip -Destination $outputPath -Force
    $hash = (Get-FileHash -LiteralPath $outputPath -Algorithm SHA256).Hash
    Write-Host "Built $outputPath"
    Write-Host "Theme version: $($versionMatch.Groups['version'].Value.Trim())"
    Write-Host "SHA256: $hash"
}
finally {
    if (Test-Path -LiteralPath $temporaryRoot) {
        Remove-Item -LiteralPath $temporaryRoot -Recurse -Force
    }
}
