var alertDiv = document.getElementById("alert");

function login() {
    alertDiv.classList = '';
    alertDiv.innerHTML = '';

    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (email != '' && password != '') {
        var xhr = new XMLHttpRequest();
        var urlRequest = 'http://localhost/reproductor/ajax.php';
        var params = 'type=user&action=login'; // Config parems primarys
        params += '&email=' + email + '&password=' + password; // set data
        urlRequest += '?';

        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                console.log(data);
                switch (data) {
                    case 'start':
                        window.location = "http://localhost/reproductor/explore";
                        break;
                    case 'error_password':
                        alertDiv.classList = 'alert alert-warning';
                        alertDiv.innerHTML = '<b>Error: </b>Tu correo o contraseña no coinciden con nuestros registros. Intenta de nuevo.';
                        break;
                    case 'invalid_email':
                        alertDiv.classList = 'alert alert-warning';
                        alertDiv.innerHTML = '<b>Error: </b>Correo electronico invalido.';
                        break;
                    case false:
                        alertDiv.classList = 'alert alert-error';
                        alertDiv.innerHTML = '<b>Error: </b>Tu correo y contraseña no coinciden con nuestros registros. Intenta de nuevo.';
                        break;
                }
            }
        }
        xhr.open('POST', urlRequest, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(params);
    } else {
        alertDiv.classList = 'alert alert-error';
        alertDiv.innerHTML = '<b>Error: </b>Llena todos los campos.';
    }
}

function register(e) {
    alertDiv.classList = '';
    alertDiv.innerHTML = '';

    let name = document.getElementById("name").value;
    let lastname = document.getElementById("lastname").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirm_password = document.getElementById("confirm_password").value;

    var xhr = new XMLHttpRequest();
    var urlRequest = 'http://localhost/reproductor/ajax.php';
    var params = 'type=user&action=register'; // Config parems primarys
    params += '&name=' + name + '&lastname=' + lastname + '&email=' + email + '&password=' + password +
        '&confirm_password=' + confirm_password; // set data
    urlRequest += '?';

    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
            switch (data) {
                case 'success_user':
                    alertDiv.classList = 'alert alert-success';
                    alertDiv.innerHTML = '<b>Cuenta creada correctamente.</b>';
                    window.location = "http://localhost/reproductor/";
                break;
                case 'error_addUser':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>No ha sido posible registrate. Intenta de nuevo.';
                break;
                case 'error_password':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Tu contraseña no coincide. Intenta de nuevo.';
                break;
                case 'exit_email':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>El correo electronico, ya esta en uso. Intenta de nuevo.';
                break;
                case 'invalid_password':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>La contraseña debe ser mayor a 8 caracteres. Intenta de nuevo.';
                break;
                case 'invalid_email':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Ingresa un correo electronico valido e intenta de nuevo.';
                break;
                case 'empty_fields':
                    alertDiv.classList = 'alert alert-error';
                    alertDiv.innerHTML = '<b>Error: </b>Llena todos los campos.';
                break;
            }
        }
    }
    xhr.open('POST', urlRequest, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(params);
}