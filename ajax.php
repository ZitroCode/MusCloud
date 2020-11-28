<?php
require 'server/libs/settings.php';
require 'server/libs/class.database.php';
require 'server/utils/encript.php';
require 'server/utils/renameFiles.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'user':
            require 'server/libs/class.users.php';
            $user = new User;

            switch ($_POST['action']) {
                case 'login':
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    // Email validation.
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $dataUser = $user->getUser($email);
                        // $response = $dataUser;
                        if ($dataUser) {
                            // Check password
                            if(verifyPass($password, $dataUser->Password)) {
                                // Log in
                                $response = 'start';
                                $_SESSION["urs"] = $dataUser;
                            } else { $response = 'error_password'; }
                        } else { $response = false; }
                    } else { $response = 'invalid_email'; }
                break;
                case 'register':
                    $data = [
                        'name' => $_POST['name'],
                        'lastname' => $_POST['lastname'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'confirm_password' => $_POST['confirm_password'],
                        'username' => str_replace(' ', '', $_POST['name'] . time()),
                        'img' => ''
                    ];

                    if (!empty($data['name']) && !empty($data['lastname']) && !empty($data['email']) && 
                    !empty($data['password'] && !empty($data['confirm_password']))) {
                        // Check if the data is an email
                        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                            // Password greater than 7 characters
                            if (strlen($data['password']) > 7) {
                                // Check if the email exists
                                if (!$user->veryEmail($data['email'])) {
                                    // Encrypt the password
                                    $data['password'] = encrypt($data['password']);
                                    // Check if the password matches
                                    if (verifyPass($data['confirm_password'], $data['password'])) {
                                        // Create a user
                                        if ($user->addUser($data)) { 
                                            $response = 'success_user'; 
                                        } else { $response = 'error_addUser'; }
                                    } else { $response = 'error_password'; }
                                } else { $response = 'exit_email'; }
                            } else { $response = 'invalid_password'; }
                        } else { $response = 'invalid_email'; }
                    } else { $response = 'empty_fields'; }
                break;
            }
        break;
        case 'song':
            require 'server/libs/class.songs.php';
            $song = new Song;
            switch ($_POST['action']) {
                case 'get':
                    $response = $song->getSongs();
                break;
                case 'add':
                    $data = [
                        'name' => $_POST['name'],
                        'artist' => $_POST['artist'],
                        'audio' => (isset($_FILES['song']) ? $_FILES['song'] : null),
                        'cover' => (isset($_FILES['cover']) ? $_FILES['cover'] : null)
                    ];
                    
                    if (!empty($data['name']) && !empty($data['artist']) 
                    && !empty($data['cover']) && !empty($data['audio'])) {
                        if ($data['cover']['type'] == "image/jpeg" || $data['cover']['type'] == "image/png") {
                            if ($data['audio']['type'] == "audio/mpeg") {
                                // Config rute for move files.
                                $dir = APP_UPDATE;
                                // Config name and route for audio
                                $nameSong = nameFile($data['audio']['name'], $data['name'], $data['artist']);
                                $dirSong = $_SERVER["DOCUMENT_ROOT"] . $dir . 'songs/' . $nameSong;
                                // Move the audio to the server.
                                if (move_uploaded_file($data['audio']['tmp_name'], $dirSong)) {
                                    // Config name and route for image
                                    $nameImg = nameFile($data['cover']['name'], $data['name'], $data['artist']);
                                    $dirImg = $_SERVER["DOCUMENT_ROOT"] . $dir . 'covers/' . $nameImg;
                                    // Move the image to the server.
                                    if (move_uploaded_file($data['cover']['tmp_name'], $dirImg)) {
                                        // Update data to send to database.
                                        $data['audio'] = SERVER_UPDATE . 'songs/' . $nameSong;
                                        $data['cover'] = SERVER_UPDATE . 'covers/' . $nameImg;
                                        // Add song to database.
                                        if ($song->addSong($data)) {
                                            $response = 'success_song';
                                        } else { $response = 'error_addSong'; }
                                    } else { $response = 'error_move_image'; }
                                } else { $response = 'error_move_audio'; }
                            } else { $response = 'error_song'; }
                        } else { $response = 'error_cover'; }
                    } else { $response = 'empty_fields'; }
                break;
                case 'delete':
                    $id = $_POST['id'];
                    $audio = $_POST['audio'];
                    $image = $_POST['image'];
                    
                    $audio = explode('/', $audio);
                    $audio = end($audio);

                    $image = explode('/', $image);
                    $image = end($image);

                    $dir = APP_UPDATE;
                    $dirSong = $_SERVER["DOCUMENT_ROOT"] . $dir . 'songs/' . $audio;
                    $dirImage = $_SERVER["DOCUMENT_ROOT"] . $dir . 'covers/' . $image;

                    if (!empty($id)) {
                        if ($song->deleteSong($id)) {
                            if (file_exists($dirSong)) {
                                unlink($dirSong);
                            }
                            if (file_exists($dirImage)) {
                                unlink($dirImage);
                            }
                            $response = 'success_deleteSong';
                        } else { $response = 'error_delete'; }
                    } else { $response = 'empty_error'; }
                break;
                case 'update':
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $artist = $_POST['artist'];

                    if (!empty($id) && !empty($name) && !empty($artist)) {
                        if ($song->updateSong($id, $name, $artist)) {
                            $response = 'success_updateSong';
                        } else { $response = 'error_update'; }
                    } else { $response = 'empty_error'; }
                break;
                }
        break;
    }
}

// Export Respuest
echo json_encode($response);
