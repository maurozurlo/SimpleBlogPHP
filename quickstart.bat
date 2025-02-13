@echo off
where php >nul 2>nul || (
    echo PHP is not installed or not in PATH.
    pause
    exit /b
)
php ./php/migrate.php || pause
php -S 127.0.0.1:8889