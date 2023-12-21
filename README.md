# Transportes ACME S.A.

La API ha sido desarrollada específicamente para ser utilizada por la empresa Transportes ACME S.A. 
para tener un control a nivel administrativo de los vehículos, conductores y propietarios que se manejan
dentro de sus operaciones diarias. La misma API permite a los usuarios de la plataforma consultar toda la información
almacenada, permitiendo que se realicen las peticiones y se cumplan requerimientos de manera eficiente y efectiva.

## Requisitos

- PHP (versión ^8.1)
- Laravel (versión ^10.10)

### ¿Cómo puedo saber si tengo instalado PHP y Laravel?

Para conocer si tenemos instalado en nuestros equipos PHP y Laravel, podemos ejecutar los siguientes comandos:

PHP:

```bash
$ php -v
```

Si nos devuelve una respuesta, es porqué ya tenemos instalado PHP en nuestro equipo.

Laravel:

```bash
$ composer --version
```

Si nos devuelve una respuesta, es porqué ya tenemos instalado la herramienta que nos permite trabajar con Laravel en nuestro equipo.

## Instalación

1. Clona el repositorio:

```bash
$ git remote add origin https://github.com/Nelmajuva/ACME_API.git
```

2. Instala las dependencias:

```bash
$ composer install
```

3. Crea una copia del archivo de configuración `.env`:

```bash
$ cp .env.example .env
```

4. Configura las variables de entorno en el archivo `.env`:

```bash
ADMIN_PASSWORD=XXXXXXXX
ADMIN_EMAIL=XXXXXXXX

DB_HOST=XXXXXXXX
DB_PORT=XXXX
DB_DATABASE=XXXXXXXXXXX
DB_USERNAME=XXXXXXXXXXX
DB_PASSWORD=XXXXXXXXXXX
```

5. Genera la clave de la aplicación:

```bash
$ php artisan key:generate
```

6. Realiza las migraciones a la base de datos y finalmente ejecuta las semillas para nutrir la base de datos:

```bash
$ php artisan migrate --seed
```

7. Ejecutar alguno de los siguientes comandos para iniciar la API de Laravel:

```bash
$ npm run dev
$ php artisan serve
```

La API estará disponible en el puerto y dirección IP proporcionada para su funcionamiento.

### Notas

¡Muchas gracias por la oportunidad de presentar este proyecto para el puesto de Desarrollador FullStack de la organización!

Espero que mis conocimientos y forma de trabajar sea de agrado para todos ustedes. :)
Por favor, contactarme al correo "camilopezm24734m@gmail.com" o a mi número de celular "+57 300 5442403" si requieren más
información, estaré encantado en ayudarlos en todo lo que necesiten.
