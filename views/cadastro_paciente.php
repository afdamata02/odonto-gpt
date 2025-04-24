<?php
session_start();
require_once '../includes/functions.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
    
    // Validação básica
    if (empty($nome) || empty($data_nascimento) || empty($email) || empty($telefone)) {
        $erro = "Todos os campos obrigatórios devem ser preenchidos";
    } else {
        try {
            adicionarPaciente($nome, $data_nascimento, $email, $telefone, $endereco);
            $mensagem = "Paciente cadastrado com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao cadastrar paciente: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente - Odonto-GPT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Cadastro de Paciente</h1>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($mensagem); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento *</label>
                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone *</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" required>
                </div>
                
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>
                
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>
    </div>
</body>
</html> 