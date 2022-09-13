1. Descargar o Clonar repositorio
2. Instalar paquetes o dependencias composer install
3. Clonar contenido del archivo .env.example cp .env.example .env
4. Generar APP_KEY y prueba php artisan key:generate
5. Descargar las dependencias js,  npm install
6. Configurar en el archivo .env la base de datos y crearlas
7. ejecutar las Migraciones php artisan migrate:fresh --seed
8. registrar un usuario