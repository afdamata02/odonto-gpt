# Documentação do Sistema Odonto-GPT

## Visão Geral
O Odonto-GPT é um sistema de gerenciamento para consultórios e clínicas odontológicas, desenvolvido em PHP com banco de dados MySQL. O sistema permite o gerenciamento de pacientes, agendamento de consultas e registro de pagamentos.

## Estrutura do Projeto
```
Odonto-GPT/
├── assets/
│   └── css/
│       └── style.css
├── includes/
│   ├── config.php
│   ├── functions.php
│   ├── navbar.php
│   └── routes.php
└── views/
    ├── login.php
    ├── cadastro_paciente.php
    ├── agendar_consulta.php
    ├── registrar_pagamento.php
    └── logout.php
```

## Banco de Dados
O sistema utiliza as seguintes tabelas:

### usuarios
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nome (VARCHAR)
- email (VARCHAR, UNIQUE)
- senha (VARCHAR)
- tipo (ENUM: 'admin', 'dentista', 'assistente')

### pacientes
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- nome (VARCHAR)
- data_nascimento (DATE)
- email (VARCHAR, UNIQUE)
- telefone (VARCHAR)
- endereco (TEXT)

### consultas
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- paciente_id (INT, FOREIGN KEY)
- dentista_id (INT, FOREIGN KEY)
- data_consulta (DATETIME)

### pagamentos
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- consulta_id (INT, FOREIGN KEY)
- valor (DECIMAL)

## Funcionalidades

### Autenticação
- Login de usuários (admin, dentista, assistente)
- Validação de credenciais
- Controle de sessão
- Logout seguro

### Gerenciamento de Pacientes
- Cadastro de novos pacientes
- Validação de dados
- Verificação de email duplicado

### Agendamento de Consultas
- Seleção de paciente e dentista
- Verificação de disponibilidade de horário
- Validação de dados

### Registro de Pagamentos
- Associação com consultas
- Validação de valores
- Verificação de pagamentos duplicados

## Segurança
- Criptografia de senhas (password_hash)
- Prevenção contra SQL Injection (prepared statements)
- Validação de dados de entrada
- Sanitização de dados
- Controle de acesso baseado em tipo de usuário

## Rotas e Permissões
- BASE_URL: http://localhost/Odonto-GPT
- Funções de verificação de permissão:
  - checkAuth(): Verifica se o usuário está logado
  - checkAdmin(): Verifica se o usuário é administrador
  - checkDentista(): Verifica se o usuário é dentista
  - checkAssistente(): Verifica se o usuário é assistente

## Estilos e Interface
- Design responsivo
- Cores principais:
  - Primária: #2c3e50
  - Secundária: #3498db
  - Sucesso: #2ecc71
  - Perigo: #e74c3c
- Componentes:
  - Formulários
  - Botões
  - Cards
  - Alertas
  - Navbar

## Variáveis de Sessão
- usuario_logado: Indica se o usuário está autenticado
- usuario_email: Armazena o email do usuário logado

## Funções Principais
1. validarLogin($email, $senha)
2. adicionarUsuario($nome, $email, $senha, $tipo)
3. adicionarPaciente($nome, $data_nascimento, $email, $telefone, $endereco)
4. agendarConsulta($paciente_id, $dentista_id, $data_consulta)
5. registrarPagamento($consulta_id, $valor)

## Validações Implementadas
- Campos obrigatórios
- Formato de email
- Unicidade de email
- Existência de registros relacionados
- Valores numéricos positivos
- Conflitos de horário
- Duplicidade de pagamentos

## Mensagens de Erro
- "Todos os campos são obrigatórios"
- "Email inválido"
- "Email já cadastrado"
- "Tipo de usuário inválido"
- "Paciente não encontrado"
- "Dentista não encontrado"
- "Já existe uma consulta agendada para este horário"
- "Consulta não encontrada"
- "Já existe um pagamento registrado para esta consulta" 