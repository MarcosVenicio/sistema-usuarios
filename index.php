<?php
include 'conexao.php';

// Consulta para selecionar todos os usuários
$query = "SELECT * FROM usuarios";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se a consulta foi bem-sucedida
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <main>
        <header>
            <h1>Usuários</h1>
            <a href="cadastro.php">Cadastrar Novo Usuário</a>
        </header>
        <section>
            <?php while ($row = $result->fetch_assoc()): ?>
                <article>
                    <header>
                        <h2><?= htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') ?></h2>
                    </header>
                    <p>Email: <?= htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p>
                        <a href="editar.php?id=<?= (int)$row['id'] ?>">Editar</a>
                        <a href="excluir.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </p>
                </article>
            <?php endwhile; ?>
        </section>
    </main>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
fecharConexao($conn);
?>