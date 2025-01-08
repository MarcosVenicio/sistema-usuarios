<?php
include 'conexao.php';

$id = (int)$_GET['id'];
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validação de senha com mais de 6 caracteres
    if (strlen($senha) <= 6) {
        echo json_encode(array('error' => 'A senha deve ter mais de 6 caracteres.'));
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    // Verifica se o e-mail já existe e não pertence a este usuário
    $checkEmailQuery = "SELECT email FROM usuarios WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param('si', $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(array('error' => 'Email já cadastrado.'));
        exit;
    } else {
        $query = "UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $nome, $email, $senhaHash, $id);
        if ($stmt->execute()) {
            echo json_encode(array('success' => 'Usuário atualizado com sucesso.'));
        } else {
            echo json_encode(array('error' => 'Erro ao atualizar usuário: ' . $stmt->error));
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <main>
        <header>
            <h1>Editar Usuário</h1>
        </header>
        <section>
            <?php if ($usuario): ?>
                <form id="editarForm" method="POST">
                    <div>
                        <label>Nome:</label>
                        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div>
                        <label>Senha:</label>
                        <input type="password" name="senha" required minlength="7">
                    </div>
                    <button type="submit">Atualizar</button>
                </form>
            <?php else: ?>
                <p>Usuário não encontrado.</p>
            <?php endif; ?>
            <p id="mensagemErro" style="color: red;"></p>
            <button class="voltar" onclick="window.location.href='index.php'">Voltar para Início</button>
        </section>
    </main>

    <script>
        document.getElementById('editarForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('editar.php?id=<?= $usuario['id'] ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('mensagemErro').textContent = data.error;
                } else {
                    window.location.href = 'index.php';
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                document.getElementById('mensagemErro').textContent = 'Erro ao atualizar usuário.';
            });
        });
    </script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
fecharConexao($conn);
?>