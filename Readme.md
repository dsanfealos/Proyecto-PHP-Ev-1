# Documentación Proyecto PHP 1º Ev.

## <u>Nombre del proyecto:</u> Trapos y Zapatos

## <u>Descripción</u>
Es una aplicación web que permite crear, modificar, eliminar, visualizar (en grupo o por separado) y cambiar la imagen de diversos productos de una tienda de ropa. Algunas de estas acciones requieren del rol de ADMIN, por lo que hay también un mecanismo de inicio y cierre de sesión.

## <u>Tecnologías utilizadas</u>
Se han utilizado PHP, PostgreSQL, Boostrap, Composer y Docker.
Las librerías especiales a utilizar han sido:
* Dotenv, para leer las variables de entorno.
* Ramsey, para generar uuids.

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
1. Abrir terminal desde el directorio donde vamos a crear el proyecto.
2. Clonar el repositorio:
    ```bash
    git clone https://github.com/dsanfealos/Proyecto-PHP-Ev-1
    ```
3. Ir a la directorio que será nuestro root:
    ```bash
    cd Proyecto-PHP-Ev-1
    ```
4. Instalar dependencias escribiendo en consola:
    ```bash
    composer require vlucas/phpdotenv
    composer require ramsey/uuid
    composer install
    ```
5. En caso de estar en Linux, debemos dar permisos a nuestro directorio uploads para mover los ficheros de las imágenes:
    ```bash
    sudo chown www-data:www-data ./src/uploads/
    sudo chmod 755 ./src/uploads/
    ```
6. Desplegar escribiendo en consola:
    ```bash
    docker compose up --build
    ```
7. Escribir "http://localhost:8080" en la url del navegador.

## <u>Uso Básico</u>

### Navegación
En todo momento el usuario tiene acceso a un header con navegación que le permite ir a la página Home, a la de creación de productos o iniciar/cerrar sesión, dependiendo del caso. También muestra al usuario su nombre y, si tiene rol ADMIN, también su rol. En caso de no haber iniciado sesión, muestra "Invitado".

### Login
Si ocurre algún error al iniciar sesión, salta un aviso. En caso contrario, se redirige al usuario a la página de index.php (Home). 
Los usuarios y contraseñas de prueba son:
1. Admin
     * user: admin
     * pass: Admin1
2. User
     * user: user
     * pass: User1234
3. Test
     * user: test
     * pass: Test1234
4. Otro
     * user: otro
     * pass: Otro1234

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
Es necesario tener Docker instalado en el equipo, puesto que se creará una imagen y un contenedor con el resto de programas de entorno.
También necesitaremos tener Composer instalado, para crear las dependencias del proyecto.

## <u>Autor</u>
Daniel Sanfélix Alós<br>
Github: https://github.com/dsanfealos/Proyecto-PHP-Ev-1

## <u>Licencia</u>
Uso educativo.
