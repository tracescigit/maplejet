:start
php artisan queue:listen
php artisan queue:listen --queue=print_jobs --memory=1024

goto start