# Sistema de Usuários

Este é um sistema de gerenciamento de usuários desenvolvido em PHP com MySQL. O projeto permite cadastrar, editar, excluir e listar usuários.

## Caso você não queira instalar o projeto localmente fiz a instalação dele em um servidor gratuito e você pode visualizar por esse link:

https://marcosvenicio.kesug.com/

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados:

- [PHP](https://www.php.net/downloads.php) >= 7.4
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Composer](https://getcomposer.org/download/)
- [Git](https://git-scm.com/downloads)

## Instalação

### Clonando o Repositório

Primeiro, clone o repositório para o seu ambiente local:

```bash
git clone https://github.com/SeuUsuario/sistema-usuarios.git
cd sistema-usuarios

Crie um banco de dados MySQL:

CREATE DATABASE sistema_usuarios;

Atualize o arquivo conexao.php com as credenciais do banco de dados:

<?php
// Definindo constantes para as credenciais do banco de dados
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'seu_usuario');
define('DB_PASSWORD', 'sua_senha');
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

Rodando o Projeto Localmente

Instale as dependências do projeto:

php -S localhost:8000

http://localhost:8000

### Conclusão

Este README fornece instruções detalhadas sobre como configurar e rodar o projeto localmente. Mas também dá a opção para ver o projeto rodando em uma url real hospedada em um servidor gratuito na internet com ssl.