# Documentación Proyecto PHP 1º Ev.

## <u>Nombre del proyecto:</u> Trapos y Zapatos

## <u>Tecnologías utilizadas</u>
Se han utilizado PHP, PostgreSQL, Boostrap y Docker
## <u>Estructura del proyecto</u>
Tenemos una estructura como la que sigue:
* root:   
  * database: init.sql.
  * src:
    * directorios:
      * config: Config.php.
      * models: Categoria.php, Producto.php, User.php
      * services: CategoriasService.php, ProductosService.php, SessionService.php, UsersService.php.
      * uploads
    * ficheros: favicon.ico, create.php, delete.php, details.php, footer.php, header.php, index.php, login.php, logout.php, update_image_file.php, update-image.php, update.php
  * tests
  * vendor
    * dependencias
    * autoload.php
  * .env, .gitignore, composer.json, composer.lock, docker-compose.yaml, Dockerfile, Readme.md.

## <u>Instrucciones de instalación</u>
1. Abrir terminal desde el directorio root del proyecto
2. Instalar dependencias escribiendo en consola:
    ```bash
    composer require vlucas/phpdotenv
    composer require ramsey/uuid
    composer install
    ```
3. Desplegar escribiendo en consola:
    ```bash
    docker compose up --build
    ```
4. Escribir "http://localhost:8080" en la url del navegador.

## <u>Uso Básico</u>
### Introducción
Esta es una aplicación web con login que permite hacer CRUD sobre los productos, dependendiendo del rol del usuario que haya iniciado sesión.

### Navegación
En todo momento el usuario tiene acceso a un header con navegación que le permite ir a la página Home, a la de creación de productos o iniciar/cerrar sesión, dependiendo del caso. También muestra al usuario su nombre y, si tiene rol ADMIN, también su rol. En caso de no haber iniciado sesión, muestra "Invitado".

### Login
Si ocurre algún error al iniciar sesión, salta un aviso. En caso contrario, se redirige al usuario a la página de index.php (Home). 

### Ver Productos
En la página de home se pueden ver todos los productos, con sus detalles. Pueden filtrarse por marca o modelo, y aparecen las opciones para crear, modificar, borrar, cambiar imagen y ver detalles de cada producto.

### Crear Producto
Sólo apto para usuarios con rol ADMIN. En la página de creación de producto, se pueden elegir los campos de creación de dicho producto, que permitirán especificar modelo, marca, descripción, stock, precio y categoría.

### Modificar Producto
Sólo apto para usuarios con rol ADMIN. En la página de modificación de producto, muestra el id del producto escogido y se pueden elegir los campos de modificación de dicho producto, que permitirán especificar modelo, marca, descripción, stock, precio y categoría.

### Cambiar Imagen
Sólo apto para usuarios con rol ADMIN. En la página de cambio de imagen, muestra el id, marca, modelo y ruta actual de la imagen. También permite seleccionar el nuevo fichero de imagen y subirlo. Se muestran mensajes en caso de éxito o error, redirigiendo a Home.

### Eliminar Producto
Sólo apto para usuarios con rol ADMIN. En la opción de eliminación de producto, muestra mensajes de éxito/error después de redirigir a Home.

## <u>Requisitos previos</u>
Únicamte es necesario tener docker instalado en el equipo, puesto que se creará una imagen y un contenedor con el resto de programas de entorno.

## <u>Autor</u>
Daniel Sanfélix Alós
Github: https://github.com/dsanfealos/Proyecto-PHP-Ev-1

## <u>Licencia</u>
Uso educativo.
