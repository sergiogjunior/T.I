<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>

    <?php
    //echo"<pre>";
    //print_r($_POST);
    //echo"</pre>";

    $conexao = mysqli_connect('localhost', 'root', '', 'senhas');
    //CREATE
     if($_POST){
        
        $servico = $_POST["servico"];
        $login = $_POST["login"];
        $senha = $_POST["senha"];

        mysqli_query($conexao,"INSERT INTO tb_info (SERVICO, LOGIN, SENHA) VALUES ('$servico', '$login', '$senha')");

        unset ($_POST);
        header('location: index.php');
     }

     //DELETE
     if($_GET && $_GET['acao'] = 'excluir'){
     mysqli_query($conexao,'DELETE FROM tb_info WHERE ID = '.$_GET['id']);
     }

     //READ
     $resultado = mysqli_query($conexao,'SELECT * FROM tb_info');
    ?>

    <title>Crud Simples</title>
</head>

<body>
    <h1 id="Titulo"> Gerenciar Senhas </h1>
    <br><hr><br>
    <div>
        <form method="post" action="index.php">
           
            <label> Serviço/Site<input type="text" name="servico" required></label>
            <label> Login<input type="text"  name="login" required></label>
            <label> Senha<input type="text"  name="senha" required></label>
            <button type ="submit">  Cadastrar </button>
            <br><br><br><br>
        </form>
    </div>
    <br><hr><br>
    <table class="table">
        <thead>
            <tr class="tr">
                <th class="th">ID</th>
                <th>Serviço/Site</th>
                <th>Login</th>
                <th>Senha</th>
                <th>Status</th>
            </tr>
        </thead>
 
        <tbody>
            <?php
            while($dados = mysqli_fetch_assoc($resultado)){
            echo"<tr>";
                echo" <td>".$dados['ID']."</td>";
                echo" <td>".$dados['SERVICO']."</td>";
                echo" <td>".$dados['LOGIN']."</td>";
                echo" <td>".$dados['SENHA']."</td>";
                echo" <td>
                    <button class='btn-edit'> <a href = 'atualizar.php?
                    id=".$dados['ID']."
                    &servico=".$dados['SERVICO']."
                    &login=".$dados['LOGIN']."
                    &senha=".$dados['SENHA']."
                    '> Atualizar</a></button>

                    <button class='btn-delete'> <a href = 'index.php?
                    acao=excluir&id=".$dados['ID']."'>Excluir</a> </button>
                </td>";
            echo "</tr>";
            }
            ?>
        </tbody>
 
    </table>
 
</body>
 
 
</html>