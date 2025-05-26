<?php
require_once "validador_acesso.php";

$id = str_replace('|', '-', $_SESSION['id']);
$perfil = str_replace('|', '-', $_SESSION['perfil']);
$nome = str_replace('|', '-', $_SESSION['nome']);
$titulo = isset($_POST['titulo']) ? str_replace('|', '-', $_POST['titulo']) : '';
$categoria = isset($_POST['categoria']) ? str_replace('|', '-', $_POST['categoria']) : '';
$descricao = isset($_POST['descricao']) ? str_replace('|', '-', $_POST['descricao']) : '';

$dados = $id . '|' . $perfil . '|' . $nome . '|' . $titulo . '|' . $categoria . '|' . $descricao . PHP_EOL;
var_dump($dados);

$arquivo = fopen('../../../registros/registro.hd', 'a');


if ($arquivo === false) {
    die('Erro ao abrir o arquivo para escrita.');
}

fwrite($arquivo, $dados);
fclose($arquivo);

header('location: abrir_chamado.php?cadastro=sucesso');
