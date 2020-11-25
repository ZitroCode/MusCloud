<?php 
function encrypt($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPass($password, $passEncry){
    return (password_verify($password, $passEncry)) ? true : false;
}