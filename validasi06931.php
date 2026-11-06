<?php

function validasi($password, $hashed_password) {
    // Validasi password menggunakan hash modern
    if (password_verify($password, $hashed_password)) {
        return true;
    }

    // Kompatibilitas dengan hash MD5 dari database lama
    if (
        preg_match('/^[a-f0-9]{32}$/i', $hashed_password) &&
        hash_equals(strtolower($hashed_password), md5($password))
    ) {
        return true;
    }

    return false;
}

?>
