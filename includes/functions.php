<?php
include 'config.php';

// Função para validar login
function validarLogin($email, $senha) {
    global $pdo;
    
    try {
        $sql = "SELECT id, senha FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return true;
        }
        return false;
    } catch (PDOException $e) {
        error_log("Erro ao validar login: " . $e->getMessage());
        return false;
    }
}

// Função para adicionar usuário (admin, dentista, assistente)
function adicionarUsuario($nome, $email, $senha, $tipo) {
    global $pdo;
    
    // Validação dos dados
    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        throw new Exception("Todos os campos são obrigatórios");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido");
    }
    
    if (!in_array($tipo, ['admin', 'dentista', 'assistente'])) {
        throw new Exception("Tipo de usuário inválido");
    }
    
    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception("Email já cadastrado");
    }
    
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senha_hash, $tipo]);
}

// Função para adicionar paciente
function adicionarPaciente($nome, $data_nascimento, $email, $telefone, $endereco) {
    global $pdo;
    
    // Validação dos dados
    if (empty($nome) || empty($data_nascimento) || empty($email) || empty($telefone)) {
        throw new Exception("Todos os campos obrigatórios devem ser preenchidos");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido");
    }
    
    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM pacientes WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception("Email já cadastrado");
    }
    
    $sql = "INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $data_nascimento, $email, $telefone, $endereco]);
}

// Função para agendar consulta
function agendarConsulta($paciente_id, $dentista_id, $data_consulta) {
    global $pdo;
    
    // Validação dos dados
    if (empty($paciente_id) || empty($dentista_id) || empty($data_consulta)) {
        throw new Exception("Todos os campos são obrigatórios");
    }
    
    // Verificar se o paciente existe
    $stmt = $pdo->prepare("SELECT id FROM pacientes WHERE id = ?");
    $stmt->execute([$paciente_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Paciente não encontrado");
    }
    
    // Verificar se o dentista existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ? AND tipo = 'dentista'");
    $stmt->execute([$dentista_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Dentista não encontrado");
    }
    
    // Verificar se já existe consulta no mesmo horário
    $stmt = $pdo->prepare("SELECT id FROM consultas WHERE dentista_id = ? AND data_consulta = ?");
    $stmt->execute([$dentista_id, $data_consulta]);
    if ($stmt->fetch()) {
        throw new Exception("Já existe uma consulta agendada para este horário");
    }
    
    $sql = "INSERT INTO consultas (paciente_id, dentista_id, data_consulta) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$paciente_id, $dentista_id, $data_consulta]);
}

// Função para registrar pagamento
function registrarPagamento($consulta_id, $valor) {
    global $pdo;
    
    // Validação dos dados
    if (empty($consulta_id) || empty($valor) || $valor <= 0) {
        throw new Exception("Todos os campos são obrigatórios e o valor deve ser maior que zero");
    }
    
    // Verificar se a consulta existe
    $stmt = $pdo->prepare("SELECT id FROM consultas WHERE id = ?");
    $stmt->execute([$consulta_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Consulta não encontrada");
    }
    
    // Verificar se já existe pagamento para esta consulta
    $stmt = $pdo->prepare("SELECT id FROM pagamentos WHERE consulta_id = ?");
    $stmt->execute([$consulta_id]);
    if ($stmt->fetch()) {
        throw new Exception("Já existe um pagamento registrado para esta consulta");
    }
    
    $sql = "INSERT INTO pagamentos (consulta_id, valor) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$consulta_id, $valor]);
}
