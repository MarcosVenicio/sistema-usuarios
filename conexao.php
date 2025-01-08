<?php
// Definindo constantes para as credenciais do banco de dados
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sistema_usuarios');

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