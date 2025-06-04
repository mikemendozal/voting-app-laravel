<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 🧠 Sistema de Gestión de Preguntas (VotingApp)

Aplicación web para crear, editar y eliminar preguntas con opciones dinámicas, desarrollada con **Laravel 11**, **Vue 3**, **Inertia.js** y base de datos **MySQL**.

---

## ⚙️ Requisitos

- **PHP** >= 8.2
- **Composer**
- **Node.js** >= 18
- **MySQL** o **MariaDB**
- **Laravel 11**
- **Laravel Breeze** (stack Inertia)

---

## 🚀 Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/usuario/nombre-del-proyecto.git
cd nombre-del-proyecto
```

2. Instala dependencias backend y frontend:
   ```bash
    composer install
    npm install
    ```
   
3. Copia y configura el archivo .env:
   ```bash
    cp .env.example .env
    php artisan key:generate
   ```

4. Configura tu base de datos en .env:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_bd
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
   ```

5. Ejecuta las migraciones y seeders:
    ```bash
    php artisan migrate --seed
   ```

6. Corre el servidor:
   ```bash
   php artisan serve
   ```

7. Corre el frontend:
   ```bash
   npm run dev
   ```

👤 Usuario de prueba
Puedes acceder con las siguientes credenciales:
```bash
Correo electrónico: admin@admin.com
Contraseña: admin123
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
