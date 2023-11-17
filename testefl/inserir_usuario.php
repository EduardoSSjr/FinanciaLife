
<?php
$nome = $_POST['cadastro_nome'];
$email = $_POST['cadastro_email'];
$senha = $_POST['cadastro_senha'];

// Conexão com o banco de dados
$conn = mysqli_connect('localhost', 'root', '', 'financialife');

// Verificar a conexão
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Consulta SQL para inserção
$sql = "INSERT INTO USUARIO (cadastro_nome, cadastro_email, cadastro_senha) VALUES ('$nome', '$email', '$senha')";

// Executar a consulta e verificar se foi bem-sucedida
if ($conn->query($sql) === TRUE) {
    // Redirecione para a página principal ou exiba uma mensagem de sucesso
    header("Location: listar_valores.php");
} else {
    // Exiba uma mensagem de erro em caso de falha na atualização
    echo "Erro ao inserir a despesa: " . $conn->error;
}
// Fechar a conexão com o banco de dados
mysqli_close($conn);
?>

<?php

    session_start();

    function OpenAlert($message) {
        echo "<script>alert('$message');</script>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Conexão com o banco de dados usando MySQLi
        
        include 'CONFIG.php';

        // $user_name = $_POST['signup_user_input'];
        // $user_pw = $_POST['signup_password_input'];
        // $user_email = $_POST['signup_email_input'];

        $nome = $_POST['cadastro_nome'];
        $email = $_POST['cadastro_email'];
        $senha = $_POST['cadastro_senha'];

        // Consulta SQL com prepared statement para evitar SQL injection
        $query_select = "SELECT nome FROM USUARIO WHERE nome = ?";
        $session_id_select = "SELECT user_id FROM USUARIO WHERE email = ?";
        $stmt = $conn->prepare($query_select);
        $stmt->bind_param("s", $nome);

        // Executar a consulta
        $stmt->execute();

        // Obter o resultado da consulta
        $result = $stmt->get_result();

        // Verificar se o usuário já existe
        if ($result->num_rows > 0) {
            // Usuário já existez
            OpenAlert("Usuário já existe.");
            die();
        } else {
            // Usuário não existe, vamos inseri-lo no banco de dados

            // Consulta SQL para inserir usuário
            $query_insert = "INSERT INTO USUARIO (USER_NAME, USER_PASSWORD, USER_EMAIL) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($query_insert);

            // Hash da senha
            $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

            // Bind dos parâmetros
            $stmt_insert->bind_param("sss", $nome, $senha, $email);

            // Executar a inserção
            if ($stmt_insert->execute()) {
                // Sucesso no cadastro
                $_SESSION['user_id'] = $session_id_select;
                OpenAlert("Usuário Cadastrado.");
                echo "<script language='javascript' type='text/javascript'>window.location.href='./listar_valores.php';</script>";
            } else {
                // Erro na inserção
                OpenAlert("Erro ao Cadastrar.");
            }
        }


    // Fechar a conexão
    $stmt->close();
    $stmt_insert->close();
    $conn->close();
    
}