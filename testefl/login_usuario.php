<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados
    $conn = mysqli_connect('localhost', 'root', '', 'financialife');

    // Verificar a conexão
    if (!$conn) {
        die("Erro de conexão: " . mysqli_connect_error());
    }

    // Sanitize para evitar SQL injection (não é tão seguro quanto as instruções preparadas)
    $email = mysqli_real_escape_string($conn, $email);
    $senha = mysqli_real_escape_string($conn, $senha);

    // Consulta SQL para verificar o login
    $sql = "SELECT * FROM USUARIO WHERE email = '$email' AND senha = '$senha'";
    
    // Executar a consulta
    $result = mysqli_query($conn, $sql);

    // Verificar se há uma linha correspondente (login bem-sucedido)
    if ($row = mysqli_fetch_assoc($result)) {
        // Armazenar informações do usuário na sessão, se necessário
        $_SESSION['user_id'] = $row['id_usuario'];
        $_SESSION['nome'] = $row['cadastro_nome'];

        // Redirecionar para a página principal ou exibir uma mensagem de sucesso
        header("Location: listar_valores.php");
    } else {
        echo "Login inválido. Verifique suas credenciais.";
    }

    // Fechar a conexão com o banco de dados
    mysqli_close($conn);
}
?>