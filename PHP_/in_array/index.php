<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

$numerosSort = array();

while (count($numerosSort) < 6) {

    
    $sorteado = rand(1, 60);

    
    if (!in_array($sorteado, $numerosSort)) {
        
        $numerosSort[] = $sorteado;
    }
}


echo "Números sorteados: ";
foreach ($numerosSort as $numero) {
    echo $numero . " ";
}
?>

</body>
</html>