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

// Buscar pacientes e dentistas para o select
try {
    global $pdo;
    $pacientes = $pdo->query("SELECT id, nome FROM pacientes ORDER BY nome")->fetchAll();
    $dentistas = $pdo->query("SELECT id, nome FROM usuarios WHERE tipo = 'dentista' ORDER BY nome")->fetchAll();
} catch (PDOException $e) {
    $erro = "Erro ao carregar dados: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = filter_input(INPUT_POST, 'paciente_id', FILTER_VALIDATE_INT);
    $dentista_id = filter_input(INPUT_POST, 'dentista_id', FILTER_VALIDATE_INT);
    $data_consulta = filter_input(INPUT_POST, 'data_consulta', FILTER_SANITIZE_STRING);
    
    // Validação básica
    if (!$paciente_id || !$dentista_id || empty($data_consulta)) {
        $erro = "Todos os campos são obrigatórios";
    } else {
        try {
            agendarConsulta($paciente_id, $dentista_id, $data_consulta);
            $mensagem = "Consulta agendada com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao agendar consulta: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta - Odonto-GPT</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Agendar Consulta</h1>
            
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
                    <label for="paciente_id">Paciente *</label>
                    <select class="form-control" id="paciente_id" name="paciente_id" required>
                        <option value="">Selecione um paciente</option>
                        <?php foreach ($pacientes as $paciente): ?>
                            <option value="<?php echo $paciente['id']; ?>">
                                <?php echo htmlspecialchars($paciente['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="dentista_id">Dentista *</label>
                    <select class="form-control" id="dentista_id" name="dentista_id" required>
                        <option value="">Selecione um dentista</option>
                        <?php foreach ($dentistas as $dentista): ?>
                            <option value="<?php echo $dentista['id']; ?>">
                                <?php echo htmlspecialchars($dentista['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="data_consulta">Data e Hora da Consulta *</label>
                    <input type="datetime-local" class="form-control" id="data_consulta" name="data_consulta" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Agendar</button>
            </form>
        </div>
    </div>
</body>
</html> 