# MusCloud

**MusCloud** es un proyecto principalmente creado para la enseñanza de JavaScript utilizando AJAX, en el Instituto de CompuIngles de Oriente.

***Idiomas***
- 🇪🇸 Español
- [🇺🇸 Ingles](./README.md)

# Tabla de contenidos
- [Visión General](#vision-general)
- [Configuración del servidor](#configuración-del-servidor)
- [Configuraciones de Archivos](#estructura-de-archivos)
- [Base de datos](#base-de-datos)
- [Conectar a base de datos](#conectar-a-base-de-datos)

## Visión General
Esta guía te acompañará en la preparación de tu servidor local (WampServer o XAMP). En caso de que tengas uno diferente, te recomiendo que busques los procedimientos para configurar tu servidor por tu cuenta. También es importante que cree su propio diseño web para reforzar sus conocimientos. Y finalmente el proyecto lo desarrolla de forma sencilla el cliente. En el lado del servidor, se utilizó POO (Programación Orientada a Objetos).

## Configuración del servidor
Para poder empezar con la configuración debemos ir a nuestro archivo: `php.ini`.
*WampServer* **Windows 64 Bits**

```bash
C:/wamp64/bin/php/php_version/php.ini
```
*WampServer* **Windows 32 Bits**

```bash
C:/wamp/bin/php/php_version/php.ini
```
*XAMPP* **Windows**

```bash
C:/wamp/bin/php/php_version/php.ini
```

Una vez localizado nuestro archivo de `php.ini`, debemos buscar la siguiente variable `upload_max_filesize` y cambiarla a un numero mayor a 10M:

_Ejemplo_
```Code
upload_max_filesize = 10M
```

Esta opción es con fin a que nuestro servidor permite la subida de archivos más pesada como por ejemplo una canción que normalmente pesa entre 2Mb y 5Mb.

## Estructura de Archivos
Clona o descargar este repositorio en los cuales crearas tu propio reproductor  utilizando `JavaScript`, `HTML` y `CSS`.

Puedes utilizar la siguiente estructura de archivo o puedes utilizar la que tú prefieras.
````Files
* Nombre de tu aplicación (Carpeta Raiz)
	- Public
		- css
		- js
		- img
	- index.html
````

En tu **carpeta raíz** pasa los archivos que descargaste de este repositorio  que son `ajax.php` y la carpeta `server`.

## Base de datos
En este repositorio también hay un archivo llamado `music.sql` el cual no va a permitir crear nuestra base de datos de forma automática. Para poder crear la tabla sigue los pasos siguientes.

1.	Iniciar tu servidor local.
2.	Ingresa al siguiente enlace.
```bash
http://localhost/phpmyadmin
```
3.	Ingresa tus credenciales para iniciar sesión.
4.	Ve a la ficha **Importar**.
5.	En la sección **Importando al servidor actual**.
6.	En archivo a importar seleccionamos el botón llamado **Seleccionar Archivo**.
7.	Por último en la parte inferior de la página pulsa el botón **Continuar**.

## Conectar a base de datos
Es importante recalcar que solo debemos cambiar las variables de conexión, ya que todo está listo para la conexión del mismo.

Para poder empezar es importante que ubiquemos el siguiente archivo `settings.php`. El cual está en la siguiente ruta.

```path
APP_NAME/server/libs/settings.php
```

**Nota:** `APP_NAME` Hace referencia al nombre de tu aplicación.

En este archivo vamos a modificar las siguientes nuestras constantes.

1.	Modificar nuestra constante llamada `APP_HOST`.

```PHP
// Dentro de NAME_HOST pon el nombre de tu dominio si utilizas un servidor local debes ingresar "localhost".
define("DB_HOST", "NAME_HOST");
```

2.	Modificar nuestra constante llamada `DB_USERNAME`.
```PHP
// Dentro de "YOUR_USERNAME" ingresa tu nombre de usuario de tu base de datos (phpmyadmin).
define("DB_USERNAME", "YOUR_USERNAME");
```

3.	Modificar nuestra constante llamada `DB_PASSWORD`.
```PHP
// Dentro de "YOUR_PASSWORD" ingresa tu contraseña de tu base de datos (phpmyadmin).
define("DB_PASSWORD", "YOUR_PASSWORD");
```

4.	Modificar nuestra constante llamada `DB_DATABASE`.
```PHP
// Dentro de "YOUR_DB" ingresa el nombre de la base de datos. Si utilizaste el archivo llamado "music.sql" debes ingresar el siguiente nombre "music".
define("DB_DATABASE", "YOUR_DB");
```
Una vez que hayas terminado de configurar la constante de la base de datos seguimos con el siguiente paso.

## Constantes de URL y Update
Estas constantes nos permiten subir los archivos a nuestro servidor para ser más específica a la carpeta llamada `update` dentro de nuestra carpeta `server`.

Empecemos vamos a configurar nuestra constante `APP_UPDATE`.
```PHP
// Dentro de "APP_UPDATE" vamos a cambiarlo por el nombre de nuestra carpeta raiz.
define('APP_UPDATE', '/APP_NAME/server/update/');
```

Ahora vamos a configurar nuestra constante `SERVER_UPDATE`.
```PHP
// Dentro de "APP_UPDATE" vamos a cambiarlo por el nombre de nuestra carpeta raiz.
define('SERVER_UPDATE', 'http://localhost/APP_NAME/server/update/');

```
Recuerda que la URL cambia dependiendo tu hosting si estas en un servidor local no deberías tener problemas al configurar la constante de URL.

## Ejemplos de Script para AJAX

He decidido poner estos ejemplos, ya que con AJAX podemos tener algunos problemas a la hora de enviar los datos a nuestro servidor por método POST.

Ejemplo 1: En este ejemplo tenemos un ejemplo de html, aunque en vez de utilizar un `form` se puede utilizar un `div`.
```html
<form id="formExample" enctype="multipart/form-data">
	<input type="text" id="name">
	<input type="file" id="song">
	<button type="submit">Enviar</button>
</form>
```

Es importante saber que el atributo `enctype` con el valor `multipart/form-data` nos permite subir diferentes archivos.

En JavaScript el código sería algo como el siguiente.

```javascript
    var formExample = document.getElementById("formExample");
    formExample.addEventListener("submit", sendData);

    function sendData(e) {
        // Evitar que se recargue nuestra página ideal cuando se utiliza una etiqueta form.
        e.preventDefault;

        //Obtiene el nombre que hemos ingresado del form
        var audioName = document.getElementById("name").value;
        // Obtiene el objeto del archivo del form
        var audio = document.getElementById("song").files[0];

        var formData = new FormData(); // Crea un formulario
        // Metemos los datos para poder enviarlos posteriormente.

        formData.append('type', 'song'); // Importante para el archivo ajax.php
        formData.append('action', 'add'); // Importante para el archivo ajax.php
        formData.append('name', audioName);
        formData.append('song', audio);

        // Creamos nuestro objeto para enviar una solicitud HTTP
        var xhr = new XMLHttpRequest();
        var urlRequest = 'http://localhost/reproductor/ajax.php';

        /* Cuando solo enviemos texto se utiliza "onreadystatechange" pero cuando enviamos texto
         * y archivos se utiliza "onload". Para este ejemplo vamos a utilizar "onload" ya que estamos
         * enviando archivos.
        */

        xhr.onload = function() {
            // Comprobamos el estado de la solicitud.
            if (this.readyState == 4 && this.status == 200) {
                // Si todo fue correcto imprimimos la respuesta en formato JSON
                console.log((this.responseText));
            }
        }

        // El metodo y dirección de nuestra petición
        xhr.open('POST', urlRequest, true);
        // Enviamos la solicitud
        xhr.send(formData);
    }
```

Recuerda que en nuestro `FormData()` debe tener como primer parámetro el tipo de solicitud con el nombre `type` y el valor puede ser `user` o `song` en minúsculas. Otro valor  puede devolver un error.

Como siguiente parametro nuestro `FormData()` debe ser un `action`, los valores que puede recibir son los siguientes.

- Para usuarios `user` deben ser los siguientes.
	- `login` Nos permite enviar datos de tipo texto y recibe como parametros `email` y `password`. Otro dato enviado será ignorado o puede causar un error. [Ver tipos de respuestas]()
	- `register` Nos permite enviar datos de tipo texto y recibe como parametros `name`, `lastname`, `email`, `password`, `confirm_password`. El `username` se genera automaticamente. En una futura actualización podremos editar nuestro perfil en nuestra aplicación. [Ver tipos de respuestas]()
- Para música `song` deben ser los siguientes.

	- `get` Nos permite obtener todas las canciones que estén en nuestra base de datos, los únicos parametros que puede recibir son el `type` y `action`. Cualquier otro 	parámetro enviado va a ser ignorado. [Ver tipos de respuestas]()

	- `add` Nos permite añadir una nueva canción y recibe como parámetros `name`, `artist`, `song` y `cover`. [Ver tipos de respuestas]()

	- `delete` Nos permite eliminar una canción el parámetro que recibe es `id`, el ID debe ser de la canción. [Ver tipos de respuestas]()

	- `update` Nos permite actualizar el nombre y artista/s de la canción los parámetros que recibe son `id`, `name`, `artist`. [Ver tipos de respuestas]()
