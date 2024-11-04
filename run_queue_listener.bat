@echo off
setlocal
:start
echo Starting queue listeners...

:: Start the first queue listener in a separate process
start /b cmd /c "php artisan queue:listen"
:: Start the second queue listener in a separate process
start /b cmd /c "php artisan queue:listen --queue=print_jobs --memory=1024"

:check
:: Wait for 60 seconds before checking again
timeout /t 60 >nul

:: Check if the listeners are still running
tasklist | find /i "php.exe" >nul 2>&1
if errorlevel 1 (
    echo One or both queue listeners have stopped. Restarting...
    goto start
) else (
    echo Queue listeners are running...
    goto check
)
