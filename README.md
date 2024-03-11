## Pemasangan Admin Penawaran

Untuk memasang aplikasi ini pada komputer lokal anda, silahkan ikuti petunjuk di bawah ini:

	- jalankan perintah ini pada cmd: composer install
	- jalankan perintah ini pada cmd: cp .env.example .env 
	- masukkan perintah: php artisan key:generate
	- Buat database, disini saya membuat database bernama: penawaran
	- Masukkan penawaran pada .env: DB_DATABASE
	- jalankan perintah: php artisan migrate:fresh --seed
	- Jalankan pada browser: https://localhost/penawaran


## CATATAN

Tidak perlu menggunakan **php artisan:serve** untuk menjalankan aplikasi ini, langsung saja **https://localhost/penawaran**

Setiap alur program sudah tertulis pada setiap controller, untuk login terbagi 3 role:
	- admin
	- client 
	- perusahaan

## CATATAN PENGGUNA/USER (Pengguna default)
	
	Role: **Admin**
	username: admin@penawaran.com
	password: penawaran



	Role: **Client**
	username: client@penawaran.com
	password: penawaran


	Role: **Perusahaan**
	username: perusahaan@penawaran.com
	password: penawaran