<html>

<head>
  <meta charset="utf-8" />
  <title>App Help Desk</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="icon" href="imagens/logo.png" type="image/x-icon">

  <style>
    .card-login {
      padding: 30px 0 0 0;
      width: 350px;
      margin: 0 auto;
    }
  </style>
</head>


<body>

  <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
      <img src="../app_help_desk_bd/imagens/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      App Help Desk
    </a>
  </nav>

  <div class="container">
    <div class="row">

      <div class="card-login">
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">
            <form action="valida_login.php" method="POST">
              <div class="form-group">
                <img src="imagens/user.png" style="padding-bottom: 15px; width: 200px; margin-left:50px;" alt="Ícone de usuário">
                <input name="email" type="email" class="form-control" placeholder="E-mail" autofocus>
              </div>
              <div class="form-group">
                <input name="senha" type="password" class="form-control" placeholder="Senha">
                <div class="text-primary" style="text-align: right;">
                  <a href="cadastro.php">Novo? Cadastre-se!</a>
                </div>
              </div>

              <?php
                //SE CADASTRO TIVER SIDO EFETUADO
                if (isset($_GET['usuario']) && $_GET['usuario'] === 'sucesso') { //
                    echo '<div class="text-success text-center">Usuário cadastrado com sucesso!</div>';
                } else if (isset($_GET['usuario']) && $_GET['usuario'] === 'falha') { // Nova condição para falha no cadastro
                    echo '<div class="text-danger text-center">Erro ao cadastrar usuário. Tente novamente.</div>';
                }
              ?>

              <?php
                // VALIDA SE O PARÂMETRO LOGIN EXISTE E SE FOI AUTENTICADO
                // A chave 'login' só é acessada se 'isset($_GET['login'])' for verdadeiro.
                if (isset($_GET['login'])) { //
                    if ($_GET['login'] === 'erro') { //
              ?>
                        <div class="text-danger text-center"> Usuário ou senha inválido(s)!</div>
              <?php
                    } else if ($_GET['login'] === 'erro2') { //
              ?>
                        <div class="text-danger text-center"> Login obrigatório!</div>
              <?php
                    } else if ($_GET['login'] === 'erro_interno') { // Nova condição para erro interno
              ?>
                        <div class="text-danger text-center"> Erro interno no servidor. Tente novamente mais tarde.</div>
              <?php
                    }
                }
              ?>

              <button class="btn btn-lg btn-info btn-block" type="submit">Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</body>

</html>