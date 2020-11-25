<?php

function nameFile($file, $name, $artist) {
    $exeted = explode('.', $file);
    $exeted = '.' . end($exeted);
    $name = str_replace('ñ', 'n', $name);
    
    return $newName = strtolower(str_replace(' ','',$name)) . '-' . 
    strtolower(str_replace(' ','',$artist)) . $exeted;
}