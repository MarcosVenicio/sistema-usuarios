<?php
include 'conexao.php';

$id = (int)$_GET['id'];
$query = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
    header('Location: index.php');
} else {
    echo "Erro ao excluir usuário: " . $stmt->error;
}

// Fechar a conexão com o banco de dados
fecharConexao($conn);
?>