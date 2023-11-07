<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexão com o banco de dados usando MySQLi
    
    include 'conexao.php';

    $user_name = $_POST['signup_user_input'];
    $user_pw = $_POST['signup_password_input'];
    $user_email = $_POST['signup_email_input'];

    // Consulta SQL com prepared statement para evitar SQL injection
    $query_select = "SELECT USER_NAME FROM bz_user WHERE USER_NAME = ?";
    $session_id_select = "SELECT USER_ID FROM bz_user WHERE USER_EMAIL = ?";
    $stmt = $conn->prepare($query_select);
    $stmt->bind_param("s", $user_name);

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
        $query_insert = "INSERT INTO bz_user (USER_NAME, USER_PASSWORD, USER_EMAIL) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($query_insert);

        // Hash da senha
        $hashed_password = password_hash($user_pw, PASSWORD_DEFAULT);

        // Bind dos parâmetros
        $stmt_insert->bind_param("sss", $user_name, $hashed_password, $user_email);

        // Executar a inserção
        if ($stmt_insert->execute()) {
            // Sucesso no cadastro
            $_SESSION['USER_ID'] = $session_id_select;
            echo "<script language='javascript' type='text/javascript'>window.location.href='../HTML/ABRE_MENU.php';</script>";
        } else {
            // Erro na inserção
            OpenAlert("Erro ao Cadastrar.");
        }
    }

    function OpenAlert($message) {
        echo "<script>alert('$message');</script>";
    }

    // Fechar a conexão
    $stmt->close();
    $stmt_insert->close();
    $conn->close();
    
}