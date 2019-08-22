# SIA V3.0
Sistema de información para la autoevaluación
# requerimientos
- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
 - JSON PHP Extension
### Instalación
1. Clonar el proyecto
2. Realizar pull sobre la rama developer
3. Ejecuta en la consola el siguiente comando
    $ composer install
4. Copiar el archivo .env.example ejecutando el siguiente comando
    $ cp .env.example .env
5. Crear una base de datos y configurarla en el archivo .env
6. Luego de haber configurado este archivo ejecutar los siguientes comandos
    ```sh
    $ php artisan key:generate
    $ php artisan storage:link
    $ php artisan migrate --path=/database/migrations/autoevaluacion --seed
    ```
7. Para que funcionen las queues realizar la siguiente configuración, en el archivo .env colocar el driver de esta manera
    ```sh
    QUEUE_DRIVER=redis
    ```
    para que funcionen se debe instalar redis este se puede ejecutar localmente         utilizando laragon en windows, por ultimo para procesar las colas el siguiente     comando se debe estar ejecutando en consola:
    ```sh
    $ php artisan queue:work
    ```