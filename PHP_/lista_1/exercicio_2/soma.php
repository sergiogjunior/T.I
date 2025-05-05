<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio 1</title>
</head>
<body>


<?php
if (isset($_GET["num1"]) && isset($_GET["num2"])) {
    $num1 = $_GET["num1"];
    $num2 = $_GET["num2"];
    $soma = $num1 + $num2;

    if ($soma > 20) {
        $resultado = $soma + 8;
        echo "Resultado (soma > 20): $resultado";
    } else {
        $resultado = $soma - 5;
        echo "Resultado (soma ≤ 20): $resultado";
    }
}
?>


</body>
</html>