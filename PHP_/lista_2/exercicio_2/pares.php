<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Números Pares</title>
</head>
<body>
    <h1>Números Pares entre 1000 e 2000</h1>

    <?php

    for ($i = 1000; $i <= 2000; $i++) {
        if ($i % 2 == 0) {
            echo "$i ";
        }
    }

    ?>

</body>
</html>
