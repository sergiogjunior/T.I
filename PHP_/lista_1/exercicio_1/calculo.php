<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMC Completo</title>
</head>
<body>
<?php
    $A = $_GET["A"];
    $B = $_GET["B"];
    $C = $_GET["C"];
    $D = $_GET["D"];

    $soma = $A+$C;
    $multiplicacao = $B*$D;

    if ($soma > $multiplicacao){
    echo 'A+C É MAIOR QUE B+D.';
    }
    elseif ($soma < $multiplicacao){
    echo 'A+C É MENOR QUE B+D';
    }
    else {
    echo 'A+C É IGUAL A B+D';
    }

?>
</body>
</html>