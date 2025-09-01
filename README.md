<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 🛒 DistrbuIT - Ecommerce con API Pública y Administración Interna
ECommerce para venta de productos y entrega de pedidos.

Esta documentación muestra como implementar e instalar el proyecto para uso personal o bien para utilizarlo como desarrollador para fines propios.

## 📦 Para desarrolladores

 1. Descarga el repositorio utilizando git clone `git clone <url del proyecto>``
 2. Copia el archivo .env y reemplaza los datos de la base de datos por tu conexión
 3. Ejecuta los comandos `composer install` y `npm install` respectivamente
 4. Ejecuta `php artisan generate:key` para generar la clave de tu aplicación.
 5. Una vez clonado ejecuta `php artisan migrate` para generar toda la base de datos
 6. Ejecuta `php artisan db:seed` para poblar la base de datos con datos ficticios.
 7. Finalmente ejecuta `php artisan serve` y `npm run dev` para comenzar a trabajar.
 **No olvides visitar la ruta http://localhost:8000/api/documentation#/ si deseas utilizar los endpoints para aplicaciones públicas.**

## 🌐 Para producción

 1. Sube el proyecto a tu hosting, una vez hecho no olvides copiar el archivo .env.
 2. Dentro del archivo .env además de colocar las credenciales de tu base de datos no olvides cambiar las llaves APP_ENV a production y APP_URL por la url principal del hosting.
 3. Ejecuta los comandos `composer install`, `php artisan migrate`, `php artisan db:seed`, `npm install`
 4. Tras ejecutar los comandos podrás acceder a la aplicación mediante el hosting que estés utilizando, por defecto el usuario inicial cuenta con el correo prueba@prueba.com y contraseña admin, asegurate de cambiar estos datos lo más pronto posible para evitar posibles fraudes o robo de información.
 5. Puedes personalizar algunas propiedades de la aplicación ingresando a las configuraciones, asegurate de personalizarlas para tu uso personal antes de implementar de manera pública la aplicación.

