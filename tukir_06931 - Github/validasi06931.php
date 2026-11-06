<?php
function validasi($password, $hashed_password) {
    return md5($password) === $hashed_password;
}
?>
