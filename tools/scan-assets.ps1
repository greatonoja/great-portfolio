Param(
    [string]$Root = (Get-Location).Path,
    [string]$Out = "scan-report.csv"
)

Write-Output "Scanning: $Root"

# Use simpler, single-quoted regex patterns to avoid escaping issues
$patterns = @(
    'href\s*=\s*"([^"]+)"',
    'src\s*=\s*"([^"]+)"',
    'url\(\s*''([^'']+)''\s*\)',
    'url\(\s*"([^"]+)"\s*\)'
)

$files = Get-ChildItem -Path $Root -Recurse -File -Include *.html,*.htm,*.css,*.js | Where-Object { $_.FullName -notmatch "\\.git\\" }

$rows = @()
foreach ($f in $files) {
    $text = Get-Content -Raw -LiteralPath $f.FullName -ErrorAction SilentlyContinue
    foreach ($p in $patterns) {
        $matches = [regex]::Matches($text, $p)
        foreach ($m in $matches) {
            $ref = $m.Groups[1].Value.Trim()
            if ($ref -match '^(https?:|//)') {
                $exists = 'EXTERNAL'
                $resolved = $ref
                $caseMismatch = $false
            } else {
                if ($ref.StartsWith('/')) { $resolved = Join-Path $Root ($ref.TrimStart('/')) }
                else { $resolved = Join-Path $f.DirectoryName $ref }
                $exists = Test-Path $resolved
                # case-sensitive check
                if (-not $exists) {
                    $dir = Split-Path $resolved -Parent
                    $name = Split-Path $resolved -Leaf
                    if (Test-Path $dir) {
                        $entries = Get-ChildItem -LiteralPath $dir -Name
                        $matchCI = $entries | Where-Object { $_ -ieq $name }
                        if ($matchCI) { $caseMismatch = $true } else { $caseMismatch = $false }
                    } else { $caseMismatch = $false }
                } else { $caseMismatch = $false }
            }
            $rows += [PSCustomObject]@{
                sourceFile = $f.FullName
                reference = $ref
                resolved = $resolved
                exists = $exists
                caseMismatch = ($caseMismatch -eq $true)
            }
        }
    }
}

$rows | Select-Object sourceFile,reference,resolved,exists,caseMismatch | Format-Table -AutoSize
Write-Output "\nSummary: $(($rows | Where-Object { $_.exists -ne 'EXTERNAL' -and $_.exists -ne $true }).Count) missing local files (or mismatched case)."
Write-Output "Report saved to: $Out"
try { $rows | Export-Csv -Path $Out -NoTypeInformation -Encoding UTF8 } catch { Write-Warning ("Could not write {0}: {1}" -f $Out, $_) }
