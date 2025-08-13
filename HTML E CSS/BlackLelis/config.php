<?php
// Arquivo de Configuração do Banco de Dados
 
// Defina as constantes com as suas credenciais
define('DB_SERVER', 'localhost');    // O servidor do seu banco de dados (geralmente localhost)
define('DB_USERNAME', 'root');       // O seu nome de usuário do MySQL (o padrão do XAMPP é 'root')
define('DB_PASSWORD', '');           // A sua senha do MySQL (o padrão do XAMPP é em branco)
define('DB_NAME', 'blacklelis_bd');  // O nome do seu banco de dados
 
// Tenta criar a conexão com o banco de dados
$conexao = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Verifica se a conexão falhou
if ($conexao->connect_error) {
    // Se falhar, interrompe o script e exibe o erro.
    // Em um ambiente de produção, você pode querer registrar este erro em vez de exibi-lo.
    die("Erro de Conexão: " . $conexao->connect_error);
}
 
// Define o charset para UTF-8 para evitar problemas com acentuação
$conexao->set_charset("utf8");
 
?>