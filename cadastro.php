<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Verifica se o e-mail já existe
    $checkEmailQuery = "SELECT email FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(array('error' => 'Email já cadastrado.'));
        exit;
    } else {
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $nome, $email, $senha);
        if ($stmt->execute()) {
            echo json_encode(array('success' => 'Usuário cadastrado com sucesso.'));
        } else {
            echo json_encode(array('error' => 'Erro ao cadastrar usuário: ' . $stmt->error));
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
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <main>
        <header>
            <h1>Cadastrar Usuário</h1>
        </header>
        <section>
            <form id="cadastroForm" method="POST">
                <div>
                    <label>Nome:</label>
                    <input type="text" name="nome" required>
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div>
                    <label>Senha:</label>
                    <input type="password" name="senha" required minlength="6">
                </div>
                <button type="submit">Cadastrar</button>
            </form>
            <p id="mensagemErro" style="color: red;"></p>
            <button class="voltar" onclick="window.location.href='index.php'">Voltar para Início</button>
        </section>
    </main>

    <script>
        document.getElementById('cadastroForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('cadastro.php', {
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
                document.getElementById('mensagemErro').textContent = 'Erro ao cadastrar usuário.';
            });
        });
    </script>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
fecharConexao($conn);
?>