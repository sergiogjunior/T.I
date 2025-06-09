<?php
    require_once "validador_acesso.php";
    require "config.php";

// Inicializando as variáveis 
$totalAndamento = 0; 

// Consulta para obter o total de chamados em andamento
$sql = "SELECT count(statuschamado) as 'Total' FROM chamados WHERE statuschamado ='Andamento'";
$res = $conexao->query($sql);
$row = $res->fetch_assoc(); 
$totalAndamento = $row['Total'];

// Consulta para obter os detalhes dos chamados em andamento
$sql = "SELECT * FROM chamados WHERE statuschamado ='Andamento'";
$res = $conexao->query($sql);
$qtd = $res->num_rows;

// Consulta para obter os usuários (necessária para exibir o nome do usuário)
$sql = "SELECT * FROM usuarios";
$resusuarios = $conexao->query($sql);
$qtdusuarios = $resusuarios->num_rows;
?>

<html>
<head>
  <meta charset="utf-8" />
  <title>App Help Desk - Chamados em Andamento</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="icon" href="imagens/logo.png" type="image/x-icon">
  
  <link rel="stylesheet" href="CSS/style.css"> 

</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php">
      <img src="imagens/logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logo App Help Desk">
      App Help Desk
    </a>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link btn btn-secondary btn-sm" href="relatorios.php">VOLTAR</a>
      </li>
    </ul>
  </nav>

  <div class="container admin-table-container"> <br>
    <?php
        if($qtd > 0){
            print "<div class='table-responsive custom-table-responsive'>";
            print "<table class='table table-hover table-bordered table-sm custom-admin-table'>";
            print "<thead class='thead-dark'>"; print "<tr>";
            print "<th class='status-header status-andamento-bg' colspan='2'> Status em Andamento </th>"; print "<th colspan='3' class='total-chamados-header'> Total de Chamados em Andamento: $totalAndamento</th>"; print "</tr>";
            print "<tr>";
            print "<th scope='col'>Chamado</th>";
            print "<th scope='col'>Título</th>";
            print "<th scope='col' class='hide-on-small'>Categoria</th>";
            print "<th scope='col' class='hide-on-small'>Descrição</th>";
            print "<th scope='col'>Usuário</th>";
            print "</tr>";
            print "</thead>";
            print "<tbody>";

            while($row = $res->fetch_object()){
                print "<tr>";
                print "<td>" . $row -> id_chamado . "</td>";
                print "<td>" . $row -> titulo . "</td>";
                print "<td class='hide-on-small'>" . $row -> categoria . "</td>";
                print "<td class='hide-on-small'>" . $row -> descricao . "</td>";
                
                $idchamado = $row -> id_chamado;
                $idusuario = $row -> id_usuario;
                $resusuarios->data_seek(0);
                while ($user = $resusuarios->fetch_object()){
                    if ($user -> id_usuario == $idusuario){
                        print "<td>" . $user -> nome . "</td>";
                        break;
                    }
                }
                print "</tr>";
            }
            print "</tbody>";
            print "</table>";
            print "</div>";
        } else {
             print "<div class='no-chamados-message'>Nenhum chamado 'Em Andamento' encontrado.</div>";
        }
    ?>
  </div>
</body>
</html>