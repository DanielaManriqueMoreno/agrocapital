## Tecnologías utilizadas

- **Backend**: Laravel 10
- **Frontend**: Blade + Tailwind CSS
- **Base de datos**: MySQL
- **Docker**: Contenedores para desarrollo y despliegue

## Requisitos previos

- PHP >= 8.1
- Composer
- MySQL
- Servidor web (Apache, Nginx)
- Docker y Docker Compose (opcional)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/agrocapital.git
cd agrocapital

## Instalar dependencias
´´´bash
composer install

## Configurar la base de datos
Crea una base de datos MySQL y configura la conexión en el archivo .env.
´´´bash
cp .env.example .env
## Generar la clave de aplicación
´´´bash
php artisan key:generate

## Configurar el archivo .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agrocapital
DB_USERNAME=root
DB_PASSWORD=

## Ejecutar las migraciones
´´´bash
php artisan migrate
## Iniciar el servidor de desarrollo
´´´bash
php artisan serve

```


