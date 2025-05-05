<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio 1</title>
</head>
<body>
    
<form action="calculo.php" method="GET">
        <label for="A">Digite o primeiro número: </label>    
        <input name="A" type="number" placeholder="Valor  'A'"></input>
        
        <p>+</p>

        <label for="C">Digite o segundo número: </label>    
        <input name="C" type="number" placeholder="Valor  'C'"></input>
        
        <br><br><br><br><br>
        

        <label for="B">Digite o terceiro número: </label>    
        <input name="B" type="number" placeholder="Valor  'B'"></input>
        
        <p>*</p>

        <label for="D">Digite o quarto número: </label>    
        <input name="D" type="number" placeholder="Valor  'D'"></input>
        <br>

        <button tipe="submit">Calcular</button>
    </form>
</body>
</html>