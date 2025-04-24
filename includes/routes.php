<?php
// Definir constantes para as rotas
define('BASE_URL', 'http://localhost/Odonto-GPT');

// Função para redirecionar
function redirect($path) {
    header('Location: ' . BASE_URL . '/' . $path);
    exit;
}

// Função para verificar se o usuário está logado
function checkAuth() {
    if (!isset($_SESSION['usuario_logado'])) {
        redirect('views/login.php');
    }
}

// Função para verificar se o usuário é admin
function checkAdmin() {
    global $pdo;
    
    if (!isset($_SESSION['usuario_logado']) || !isset($_SESSION['usuario_email'])) {
        redirect('views/login.php');
    }
    
    $email = $_SESSION['usuario_email'];
    $stmt = $pdo->prepare("SELECT tipo FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if (!$usuario || $usuario['tipo'] !== 'admin') {
        redirect('views/dashboard.php');
    }
}

// Função para verificar se o usuário é dentista
function checkDentista() {
    global $pdo;
    
    if (!isset($_SESSION['usuario_logado']) || !isset($_SESSION['usuario_email'])) {
        redirect('views/login.php');
    }
    
    $email = $_SESSION['usuario_email'];
    $stmt = $pdo->prepare("SELECT tipo FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if (!$usuario || $usuario['tipo'] !== 'dentista') {
        redirect('views/dashboard.php');
    }
}

// Função para verificar se o usuário é assistente
function checkAssistente() {
    global $pdo;
    
    if (!isset($_SESSION['usuario_logado']) || !isset($_SESSION['usuario_email'])) {
        redirect('views/login.php');
    }
    
    $email = $_SESSION['usuario_email'];
    $stmt = $pdo->prepare("SELECT tipo FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    if (!$usuario || $usuario['tipo'] !== 'assistente') {
        redirect('views/dashboard.php');
    }
} 