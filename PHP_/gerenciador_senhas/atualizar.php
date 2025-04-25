<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>

    <?php
    require './conexao.php';

    $id=$_GET['id'];
    $servico=$_GET['servico'];
    $login=$_GET['login'];
    $senha=$_GET['senha'];

    if($_POST){
        $id = $_POST['id'];
        $servico = $_POST['servico'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        mysqli_query($conexao,"UPDATE tb_info SET SERVICO = '$servico', LOGIN = '$login', SENHA = '$senha' WHERE ID =".$id);
        header('location: index.php');
    }
    ?>


</head>
<body>
<h1 id="Titulo"> Atualização de Senhas </h1>
    <br><hr><br>
    <div>
        <form method="post" action="atualizar.php">
           
            <label> ID<input type="text" name="id" value="<?php echo $id; ?>" readonly> </label>
            <label> Serviço/Site<input type="text" name="servico" value="<?php echo $servico; ?>" required></label>
            <label> Login<input type="text"  name="login" value="<?php echo $login; ?>" required></label>
            <label> Senha<input type="text"  name="senha" value="<?php echo $senha; ?>" required></label>
            <button type ="submit"> Atualizar </button>
            <br><br><br><br>
        </form>
    </div>
    <br><hr><br>
</body>
</html>