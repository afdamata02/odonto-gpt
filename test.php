<?php
include 'includes/functions.php';

// Teste: Adicionar um usuário
adicionarUsuario('João Silva', 'joao@exemplo.com', 'senha123', 'admin');

// Teste: Adicionar paciente
adicionarPaciente('Maria Oliveira', '1990-05-15', 'maria@exemplo.com', '123456789', 'Rua Exemplo, 123');

// Teste: Agendar consulta
agendarConsulta(1, 1, '2025-05-01 10:00:00');

// Teste: Registrar pagamento
registrarPagamento(1, 150.00);

echo "Testes realizados com sucesso!";
