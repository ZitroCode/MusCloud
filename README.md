# MusCloud

**MusCloud** is a project primarily created for teaching JavaScript using AJAX, at the Instituto de CompuIngles de Oriente.

***Languages***
- [🇪🇸 Spanish](./README.es.md)
- 🇺🇸 English

# Table of Contents
- [Overview](#overview)
- [Server setup](#server-setup)
- [File Structure](#file-structure)
- [Database](#database)
- [Connect to database](#conectar-a-base-de-datos)

## Overview
This guide will accompany you in the preparation of your local server (WampServer or XAMP). In case you have a different one, I recommend that you look for the procedures to configure your server on your own. It is also important that you create your own web design to reinforce your knowledge. And finally the project is developed in a simple way by the client. On the server side, OOP (Object Oriented Programming) was used.

## Server setup
In order to start with the configuration we must go to our file: `php.ini`.
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

Once our `php.ini` file is located, we must look for the following variable` upload_max_filesize` and change it to a number greater than 10M:

_Example_
```Code
upload_max_filesize = 10M
```

This option is so that our server allows the uploading of heavier files, such as a song that normally weighs between 2Mb and 5Mb.

## File Structure
Clone or download this repository in which you will create your own player using `JavaScript`,` HTML` and `CSS`.

You can use the following file structure or you can use the one you prefer.
````Files
* Name of your application (Root Folder)
	- Public
		- css
		- js
		- img
	- index.html
````

In your ** root folder ** put the files you downloaded from this repository which are `ajax.php` and the `server` folder.

## Database
In this repository there is also a file called `music.sql` which will not allow us to create our database automatically. In order to create the table, follow the steps below.

1.	Start your local server.
2.	Enter the following link.
```bash
http://localhost/phpmyadmin
```
3.	Enter your credentials to log in.
4.	Go to the **Import** tab.
5.	In the section **Importing to the current server**.
6.	In the file to import we select the button called **Select File**.
7.	Finally, at the bottom of the page, click the button **Continue**.

## Connect to database
It is important to emphasize that we only have to change the connection variables, since everything is ready for the connection.

In order to start it is important that we locate the following `settings.php` file. Which is in the following route.

```path
APP_NAME/server/libs/settings.php
```

**Note:** `APP_NAME` Refers to the name of your application.

In this file we are going to modify the following our constants.

1.	Modify our constant called `APP_HOST`.

```PHP
// Inside NAME_HOST put the name of your domain if you use a local server you must enter "localhost".
define("DB_HOST", "NAME_HOST");
```

2.	Modify our constant called `DB_USERNAME`.
```PHP
// Inside "YOUR_USERNAME" enter your username from your database (phpmyadmin).
define("DB_USERNAME", "YOUR_USERNAME");
```

3.	Modify our constant called `DB_PASSWORD`.
```PHP
// Inside "YOUR_PASSWORD" enter your password for your database (phpmyadmin).
define("DB_PASSWORD", "YOUR_PASSWORD");
```

4.	Modify our constant called `DB_DATABASE`.
```PHP
// Inside "YOUR_DB" enter the name of the database. If you used the file called "music.sql" you must enter the following name "music".
define("DB_DATABASE", "YOUR_DB");
```
Once you have finished setting the database constant, we continue with the next step.

## URL and Update constants
These constants allow us to upload the files to our server to be more specific to the folder called `update` within our` server` folder.

Let's start, let's configure our constant `APP_UPDATE`.
```PHP
// Inside "APP_UPDATE" we are going to change it to the name of our root folder.
define('APP_UPDATE', '/APP_NAME/server/update/');
```

Now we are going to configure our constant `SERVER_UPDATE`.
```PHP
// Inside "APP_UPDATE" we are going to change it to the name of our root folder.
define('SERVER_UPDATE', 'http://localhost/APP_NAME/server/update/');

```
Remember that the URL changes depending on your hosting if you are on a local server you should not have problems when configuring the URL constant.

## Script examples for AJAX

I have decided to put these examples, since with AJAX we can have some problems when sending the data to our server by POST method.

Example 1: In this example we have an example of html, although instead of using a `form` you can use a` div`.
```html
<form id="formExample" enctype="multipart/form-data">
	<input type="text" id="name">
	<input type="file" id="song">
	<button type="submit">Send</button>
</form>
```

It is important to know that the `enctype` attribute with the `multipart/form-data` value allows us to upload different files.

In JavaScript the code would be something like the following.

```javascript
    var formExample = document.getElementById("formExample");
    formExample.addEventListener("submit", sendData);

    function sendData(e) {
        // Prevent our ideal page from reloading when using a form tag.
        e.preventDefault;

        // Get the name that we have entered from the form
        var audioName = document.getElementById("name").value;
        // Get the object from the form file
        var audio = document.getElementById("song").file[0];

        var formData = new FormData(); // Create a form

        // We put the data to be able to send it later.
        formData.append('type', 'song'); // Important for the ajax.php file
        formData.append('action', 'add'); // Important for the ajax.php file
        formData.append('name', audioName);
        formData.append('song', audio);

        // We create our object to send an HTTP request
        var xhr = new XMLHttpRequest();
        var urlRequest = 'http://localhost/reproductor/ajax.php';

        / * When we only send text "onreadystatechange" is used but when we send text
		* and files "onload" is used. For this example we are going to use "onload" 		since we are sending files.
		* /

        xhr.onload = function() {
            // We check the status of the request.
            if (this.readyState == 4 && this.status == 200) {
                // If everything was correct we print the response in JSON format
                console.log((this.responseText));
            }
        }

        // The method and direction of our request
        xhr.open('POST', urlRequest, true);
        // We send the request
        xhr.send(formData);
    }
```

Remember that in our `FormData()` it must have as its first parameter the type of request with the name `type` and the value can be `user` or `song` in lowercase. Another value can return an error.

As the next parameter our `FormData()` must be an `action`, the values it can receive are the following.

- For `user` users they must be the following.
	- `login` It allows us to send text type data and receives as parameters `email` and` password`. Other data sent will be ignored or may cause an error. [See types of responses]()
	- `register` It allows us to send data of type text and receives as parameters `name`,` lastname`, `email`,` password`, `confirm_password`. The `username` is generated automatically. In a future update we will be able to edit our profile in our application. [See types of responses]()

- For `song` music they should be the following.
	- `get` It allows us to obtain all the songs that are in our database, the only parameters it can receive are the `type` and` action`. Any other parameters sent will be ignored. [See types of responses]()

	- `add` It allows us to add a new song and receives as parameters `name`,` artist`, `song` and` cover`. [See types of responses]()

	- `delete` It allows us to delete a song. The parameter it receives is `id`, the ID must be of the song. [See types of responses]()

	- `update` It allows us to update the name and artist/s of the song. The parameters it receives are `id`,` name`, `artist`. [See types of responses]()