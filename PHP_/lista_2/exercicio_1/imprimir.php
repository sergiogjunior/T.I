<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

$i= 1;

while ($i <= 100) {

  $primo= 1;

    for ($n= 2; $n < $i; $n++) {

      if ($i % $n == 0) {

       $primo= 0;

    break;

      }

}

 if ($primo == 1)

  echo "$i ";

 $i++;
}

?>

    
</body>
</html>