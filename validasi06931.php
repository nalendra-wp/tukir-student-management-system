
<?php

function validasi($password, $hashed_password) {
    return password_verify($password, $hashed_password);
}

?>
