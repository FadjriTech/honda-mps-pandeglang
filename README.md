
![Logo](https://daftar.grasstrackid.com/img/kasal-cup-jc.png)



## Website Pendaftaran Motorcross Sederhana
_Honda Motorcross Pandeglang_


## Installation

Clone this github repo first. Then
install all dependency using composer

```bash
   composer install
```

Migrate all required table
```bash
   php artisan migrate
```

Seed required kelas data
```bash
   php artisan db:seed --class=MotorSeeder
```

Run server
```bash
   php artisan serve
```
    