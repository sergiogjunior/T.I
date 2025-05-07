<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabuada</title>
</head>
<body>
    <?php

$numero = $_GET['numero'];

$i = 1;

while ($i <= 10) {

    $resultado = $numero * $i;

    echo "$numero x $i = $resultado <br>";

    $i++;
}

?>
</body>
</html>
