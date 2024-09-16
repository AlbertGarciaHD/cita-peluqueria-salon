<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Verifica que el usuario esté autenticado antes de permitirle acceder a ciertas rutas
function isAuthenticated() {
    return $_SESSION['login'] ?? false;
}