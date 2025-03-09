<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

# **Gestión de Contactos y Eventos con Laravel**

Este proyecto es una API RESTful construida con **Laravel** que permite gestionar contactos, eventos y recordatorios. Está diseñado para ser escalable, seguro y fácil de integrar con aplicaciones frontend.

---

## **Tabla de Contenidos**
1. [Características](#características)
2. [Requisitos](#requisitos)
3. [Instalación](#instalación)
4. [Configuración](#configuración)
5. [Uso de la API](#uso-de-la-api)
6. [Endpoints](#endpoints)
7. [Tareas Programadas](#tareas-programadas)
8. [Seguridad](#seguridad)
9. [Manejo de Errores](#manejo-de-errores)
10. [Contribuir](#contribuir)
11. [Licencia](#licencia)

---

## **Características**
- **Autenticación**: Registro, inicio de sesión y cierre de sesión con tokens JWT.
- **Gestión de Contactos**: Crear, leer, actualizar y eliminar contactos.
- **Gestión de Eventos**: Crear, leer, actualizar y eliminar eventos.
- **Recordatorios**: Crear recordatorios para eventos y enviar notificaciones.
- **Roles y Permisos**: Uso de Spatie Permission para gestionar roles (`admin`, `user`).
- **Notificaciones**: Envío de notificaciones por correo electrónico.
- **Tareas Programadas**: Ejecución de tareas en segundo plano (por ejemplo, enviar recordatorios).

---

## **Requisitos**
- PHP >= 8.0
- Composer
- MySQL
- Redis (opcional, para colas y caché)
- Laravel Sanctum (para autenticación API)

---

## **Instalación**

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/tu-repositorio.git
   cd tu-repositorio
   ```

2. Instala las dependencias de Composer:
   ```bash
   composer install
   ```

3. Copia el archivo `.env.example` a `.env` y configura las variables de entorno:
   ```bash
   cp .env.example .env
   ```

4. Genera una clave de aplicación:
   ```bash
   php artisan key:generate
   ```

5. Configura la base de datos en el archivo `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nombre_de_tu_db
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

6. Ejecuta las migraciones y los seeders:
   ```bash
   php artisan migrate --seed
   ```

7. Instala Laravel Sanctum:
   ```bash
   php artisan sanctum:install
   ```

8. (Opcional) Configura Redis para colas y caché en `.env`:
   ```env
   QUEUE_CONNECTION=redis
   CACHE_DRIVER=redis
   ```

---

## **Configuración**
- **Autenticación**: Configura Laravel Sanctum en `config/sanctum.php`.
- **Notificaciones**: Configura el servicio de correo en `.env` (por ejemplo, Mailtrap o SMTP).
- **Tareas Programadas**: Configura el cron job para ejecutar tareas en segundo plano:
  ```bash
  * * * * * cd /ruta-de-tu-proyecto && php artisan schedule:run >> /dev/null 2>&1
  ```

---

## **Uso de la API**

### **Autenticación**

**Registro:**
```bash
POST /api/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Inicio de Sesión:**
```bash
POST /api/login
{
  "email": "john@example.com",
  "password": "password123"
}
```

### **Contactos**

**Obtener todos los contactos:**
```bash
GET /api/contacts
```

**Crear un contacto:**
```bash
POST /api/contacts
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "123456789",
  "notes": "Cliente importante"
}
```

---

## **Endpoints**

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST   | /api/register | Registrar un nuevo usuario. |
| POST   | /api/login | Iniciar sesión. |
| POST   | /api/logout | Cerrar sesión. |
| GET    | /api/contacts | Obtener todos los contactos. |
| POST   | /api/contacts | Crear un nuevo contacto. |
| GET    | /api/contacts/{id} | Obtener un contacto específico. |
| PUT    | /api/contacts/{id} | Actualizar un contacto. |
| DELETE | /api/contacts/{id} | Eliminar un contacto. |
| GET    | /api/events | Obtener todos los eventos. |
| POST   | /api/events | Crear un nuevo evento. |
| GET    | /api/events/{id} | Obtener un evento específico. |
| PUT    | /api/events/{id} | Actualizar un evento. |
| DELETE | /api/events/{id} | Eliminar un evento. |

---

## **Tareas Programadas**

**Enviar Recordatorios:** Ejecuta cada minuto para enviar notificaciones de recordatorios pendientes.
```php
$schedule->call(function () {
    // Lógica para enviar recordatorios
})->everyMinute();
```

---

## **Seguridad**
- **Autenticación**: Tokens JWT con Laravel Sanctum.
- **Autorización**: Roles y permisos con Spatie Permission.
- **CORS**: Configurado en `config/cors.php`.
- **CSRF Protection**: Habilitado para rutas web.

---

## **Manejo de Errores**
- **Errores HTTP**: Respuestas JSON con códigos de estado adecuados (404, 500, etc.).
- **Logs**: Registro de errores en `storage/logs/laravel.log`.

---

## **Contribuir**
- Haz un fork del repositorio.
- Crea una rama (`git checkout -b feature/nueva-funcionalidad`).
- Realiza cambios y haz commit (`git commit -m 'Añadir nueva funcionalidad'`).
- Haz push a la rama (`git push origin feature/nueva-funcionalidad`).
- Abre un Pull Request.

---

## **Licencia**
Este proyecto está bajo la licencia MIT.
