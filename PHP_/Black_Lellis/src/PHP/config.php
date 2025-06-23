<?php

    define('HOST','localhost');
    define('USER','root');
    define('PASS','');
    define('BASE','blacklelis');
    
    
    $conexao = new mysqli(HOST,USER,PASS,BASE);
    $conexao -> set_charset("utf8mb4");
?>