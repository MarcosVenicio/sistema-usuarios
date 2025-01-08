<?php
// Definindo constantes para as credenciais do banco de dados
define('DB_SERVER', 'sql107.infinityfree.com');
define('DB_USERNAME', 'if0_38068865');
define('DB_PASSWORD', 'bjA7al5I4c');
define('DB_NAME', 'if0_38068865_sistema_usuarios');

// Tentativa de conexão com o banco de dados MySQL
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Função para fechar a conexão com o banco de dados
function fecharConexao($conn) {
    $conn->close();
}
?>