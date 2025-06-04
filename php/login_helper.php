<?php
function redirectComErro($codigo) {
    header("Location: login.php?erro=$codigo");
    exit;
}

function registrarTentativaLogin($email) {
    $log = sprintf("[%s] Tentativa de login com: %s\n", date("Y-m-d H:i:s"), $email);
    file_put_contents(__DIR__ . '/logs/login.log', $log, FILE_APPEND);
}
?>

