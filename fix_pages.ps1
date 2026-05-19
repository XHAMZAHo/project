$files = @(
    'resources\views\pages\about.blade.php',
    'resources\views\pages\contact.blade.php',
    'resources\views\pages\portfolio.blade.php',
    'resources\views\pages\services.blade.php'
)
foreach($f in $files){
    $c = Get-Content $f -Raw -Encoding UTF8
    $c = $c -replace 'var\(--color-navy\)', '#080d1e'
    $c = $c -replace 'var\(--color-black\)', '#03040e'
    $c = $c -replace 'var\(--color-dark\)', '#03040e'
    $c = $c -replace 'rgba\(37,99,235', 'rgba(26,86,240'
    $c = $c -replace 'btn-glow px', 'btn-primary px'
    $c = $c -replace 'btn-outline-glow', 'btn-ghost'
    [System.IO.File]::WriteAllText((Join-Path (Get-Location) $f), $c, [System.Text.Encoding]::UTF8)
    Write-Host "Fixed: $f"
}
Write-Host 'All done!'
