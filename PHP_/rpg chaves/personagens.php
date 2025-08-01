<?php
    require 'Classes/classes.php';


    $nome_jogador = isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : 'Aventureiro da Vila';
    $personagem_chaves_selecionado = isset($_GET['personagem_chaves']) ? $_GET['personagem_chaves'] : 'chaves';


    $personagens_map = [
        'sr_madruga' => 'SrMadruga',
        'popis' => 'Popis',
        'chaves' => 'Chaves',
        'chapolin' => 'Chapolin',
        'sr_barriga' => 'SrBarriga',
        'dona_florinda' => 'DonaFlorinda',
        'dona_clotilde' => 'DonaClotilde',
        'satanas' => 'Satanas',
        'godinez' => 'Godinez',
        'prof_girafales' => 'ProfGirafales',
        'nono' => 'Nono',
        'jaiminho' => 'Jaiminho'
    ];


    $classe_do_personagem = $personagens_map[$personagem_chaves_selecionado] ?? 'Chaves';


    $personagem = new $classe_do_personagem();
?>

<html>

<head>
    <meta charset="utf-8" />
    <title>Chaves RPG: Sua Aventura na Vila!</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="estilos/style.css">

    <style>
        body {
            background-image: url('img/vila_chaves_bg.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #333;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-login {
            padding: 30px 0;
            width: 550px; 
            margin: 0 auto;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9) !important; 
            backdrop-filter: blur(8px) !important; 
            opacity: 100% !important; 
            border: none;
        }

        .card-header {
            background-color: #071222;
            color: white;
            font-size: 1.3rem;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px; 
        }

        .card-header h3 {
            margin: 0;
            padding: 0;
            font-size: 2.2rem; 
            width: 100%; 
            text-align: center;
        }

        .card-header p {
            margin: 10px 0 0 0;
            font-size: 0.9em;
            text-align: center;
            line-height: 1.4;
        }

        .card-body {
            padding: 25px;
        }

        .character-details {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            margin-bottom: 20px;
        }

        .character-details img {
            width: 180px; 
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #071222;
            margin-right: 20px; 
        }

        .character-info-text {
            flex-grow: 1; 
            text-align: left; 
            color: #333; 
        }

        .character-info-text strong {
            color: #071222;
        }

        hr {
            background-color: #071222; 
            margin: 25px 0;
        }

        .attributes, .actions {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .attributes h3, .actions h3 {
            color: #071222;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .attributes p, .actions p {
            margin: 5px 0;
            font-size: 1.1em;
            line-height: 1.5;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 20px; 
            margin-top: 20px;
        }

        .actions-grid div {
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #eee;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark" style="background-color:#071222; margin-bottom:35px">
        <a class="navbar-brand" href="#">
            <img src="img/chaves_logo.jpg" style="border-radius: 50%; margin-right: 10px;" width="40" height="40"
                class="d-inline-block align-top" alt="">
            Chaves RPG: O Resgate do Barril!
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.html">VOLTAR E ESCOLHER OUTRO PERSONAGEM</a>
            </li>
        </ul>
    </nav>

    <div style="display:flex; height:85%; flex-flow:row; justify-content:center; align-items:center;">
        <div class="container">
            <div class="row">
                <div class="card-login">
                    <div class="card">
                        <div class="card-header">
                            <h3><?php echo $nome_jogador; ?></h3>
                            <p><?php echo "Sua aventura começa como **{$personagem->nome_completo}**!"; ?></p>
                        </div>
                        <div class="card-body">
                            <div class="character-details">
                                <img src="img/<?php echo $personagem->img; ?>.jpg" alt="<?php echo $personagem->nome_completo; ?>">
                                <div class="character-info-text">
                                    <p><strong>Personagem:</strong> <?php echo $personagem->nome_completo; ?></p>
                                    <p><strong>Descrição:</strong> <?php echo $personagem->descricao; ?></p>
                                </div>
                            </div>

                            <hr>

                            <div class="attributes">
                                <h3>Atributos de <?php echo $personagem->nome_completo; ?></h3>
                                <p><strong>Vida:</strong> <?php echo $personagem->vida; ?></p>
                                <p><strong>Força:</strong> <?php echo $personagem->forca; ?></p>
                                <p><strong>Defesa:</strong> <?php echo $personagem->defesa; ?></p>
                                <p><strong>Agilidade:</strong> <?php echo $personagem->agilidade; ?></p>
                                <p><strong>Inteligência/Sorte:</strong> <?php echo $personagem->inteligencia; ?></p>
                            </div>

                            <hr>

                            <div class="actions">
                                <h3>Ações e Especiais</h3>
                                <div class="actions-grid">
                                    <div>
                                        <h4>Ações Comuns</h4>
                                        <p><?php echo $personagem->acaoComum(); ?></p>
                                        <p><?php echo $personagem->esquivar(); ?></p>
                                        <p><?php echo $personagem->pedirAjuda(); ?></p>
                                        <p><?php echo $personagem->fugir(); ?></p>
                                    </div>
                                    <div>
                                        <h4>Ações Especiais de <?php echo $personagem->nome_completo; ?></h4>
                                        <?php $personagem->acaoEspecial(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>