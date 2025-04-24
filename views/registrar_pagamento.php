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

// Buscar consultas para o select
try {
    global $pdo;
    $consultas = $pdo->query("
        SELECT c.id, c.data_consulta, p.nome as paciente_nome 
        FROM consultas c 
        JOIN pacientes p ON c.paciente_id = p.id 
        ORDER BY c.data_consulta DESC
    ")->fetchAll();
} catch (PDOException $e) {
    $erro = "Erro ao carregar dados: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consulta_id = filter_input(INPUT_POST, 'consulta_id', FILTER_VALIDATE_INT);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
    
    // Validação básica
    if (!$consulta_id || !$valor || $valor <= 0) {
        $erro = "Todos os campos são obrigatórios e o valor deve ser maior que zero";
    } else {
        try {
            registrarPagamento($consulta_id, $valor);
            $mensagem = "Pagamento registrado com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao registrar pagamento: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pagamento - Odonto-GPT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Registrar Pagamento</h1>
            
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
                    <label for="consulta_id">Consulta *</label>
                    <select class="form-control" id="consulta_id" name="consulta_id" required>
                        <option value="">Selecione uma consulta</option>
                        <?php foreach ($consultas as $consulta): ?>
                            <option value="<?php echo $consulta['id']; ?>">
                                <?php 
                                echo htmlspecialchars(
                                    $consulta['paciente_nome'] . ' - ' . 
                                    date('d/m/Y H:i', strtotime($consulta['data_consulta']))
                                ); 
                                ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="valor">Valor (R$) *</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="valor" name="valor" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html> 