sa:
	php artisan serve

aa:
	php artisan migrate:fresh --seed

c:
	code .

qq:
	php artisan db:seed --class=PicSeeder
	php artisan db:seed --class=FakturSeeder

cl:
	php artisan optimize:clear
