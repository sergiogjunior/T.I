<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular IMC</title>
</head>
<body>
<?php

    $peso = $_GET["peso"];
    $altura = $_GET["altura"];

    $imc = $peso/($altura * $altura);

    echo $imc;
?>
</body>
</html> 