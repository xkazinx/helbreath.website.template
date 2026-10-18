# Uploads the site to the home server (ssh kazin-music) at https://kazin.dev/hbsite/.
# The server keeps its own config.php in /var/www/hbsite (never uploaded from here).
param(
    [string]$SshHost = 'kazin-music',
    [string]$Dir = '/var/www/hbsite'
)

$ErrorActionPreference = 'Stop'
Set-Location $PSScriptRoot

# The site's files: what git tracks (or will once added), without the repo's own files
$files = git ls-files --cached --others --exclude-standard |
    Where-Object { $_ -notmatch '^(\.gitignore|deploy\.ps1|README\.md|config\.sample\.php)$' }
$list = Join-Path $env:TEMP 'hbsite-files.txt'
$tgz = Join-Path $env:TEMP 'hbsite.tgz'
[IO.File]::WriteAllLines($list, [string[]]$files)
tar -czf $tgz -T $list
if ($LASTEXITCODE) { throw 'tar failed' }

scp -q $tgz "${SshHost}:/tmp/hbsite.tgz"
if ($LASTEXITCODE) { throw 'scp failed' }
ssh $SshHost "sudo -n mkdir -p $Dir && sudo -n tar -xzf /tmp/hbsite.tgz -C $Dir && sudo -n chown -R root:www-data $Dir && rm /tmp/hbsite.tgz"
if ($LASTEXITCODE) { throw 'extract failed' }

Remove-Item $list, $tgz
Write-Host "Deployed $($files.Count) files to ${SshHost}:$Dir"
