## Pemasangan Admin Penawaran

Untuk memasang aplikasi ini pada komputer lokal anda, silahkan ikuti petunjuk di bawah ini:

	- jalankan perintah ini pada cmd: composer install
	- jalankan perintah ini pada cmd: cp .env.example .env 
	- masukkan perintah: php artisan key:generate
	- Buat database, disini saya membuat database bernama: penawaran
	- Masukkan admin_transisi pada .env: DB_DATABASE
	- jalankan perintah: php artisan migrate:fresh --seed
	- Jalankan pada browser: **https://localhost/penawaran**


## CATATAN

Tidak perlu menggunakan **php artisan:serve** untuk menjalankan aplikasi ini, langsung saja **https://localhost/penawaran**