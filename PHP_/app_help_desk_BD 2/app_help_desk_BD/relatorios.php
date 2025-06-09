<?php
require_once "validador_acesso.php";
require_once "config.php";

// Inicializando as variáveis 
$totalAbertos = 0; 
$totalAndamento = 0; 
$totalFinalizados = 0; 

// Consulta para obter todos os chamados 
$sql = "SELECT statuschamado FROM chamados"; 
$res = $conexao->query($sql); 

// Verifica se a consulta retornou resultados 
if ($res) { 
  // Itera sobre cada registro retornado 
  while ($row = $res->fetch_assoc()) { 
    switch ($row['statuschamado']) { 
      case 'Aberto': 
        $totalAbertos++; 
        break; 
      case 'Andamento': 
        $totalAndamento++; 
        break; 
      case 'Finalizado': 
        $totalFinalizados++; 
        break; 
      } 
    } 
  }
?>

<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

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
        <a class="nav-link btn btn-secondary btn-sm" href="home.php">SAIR</a> </li>
    </ul>
  </nav>

  <div class="container">
    <div class="row w-100 justify-content-center"> <div class="card-home-summary"> <div class="card">
          <div class="card-header">
            Chamados
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-4 d-flex justify-content-center">
                <a href="abertos.php" class="summary-link summary-abertos"> <img src="imagens/abertos.png" width="70" height="70">
                  <p>Abertos(<?php print($totalAbertos); ?>)</p>
                </a>
              </div>

              <div class="col-4 d-flex justify-content-center">
                <a href="andamento.php" class="summary-link summary-andamento"> <img src="imagens/andamento.png" width="70" height="70">
                  <p>Andamento(<?php print($totalAndamento); ?>)</p>
                </a>
              </div>

              <div class="col-4 d-flex justify-content-center">
                <a href="finalizado.php" class="summary-link summary-finalizados"> <img src="imagens/finalizados.png" width="70" height="70">
                  <p>Finalizados(<?php print($totalFinalizados); ?>)</p>
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>