-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS `odonto-gpt` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `odonto-gpt`;

-- Criar tabela de usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `tipo` ENUM('admin', 'dentista', 'assistente') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criar tabela de pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(20) NOT NULL,
    `endereco` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criar tabela de consultas
CREATE TABLE IF NOT EXISTS `consultas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `paciente_id` INT NOT NULL,
    `dentista_id` INT NOT NULL,
    `data_consulta` DATETIME NOT NULL,
    `status` ENUM('agendada', 'realizada', 'cancelada') DEFAULT 'agendada',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`dentista_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `dentista_data` (`dentista_id`, `data_consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criar tabela de pagamentos
CREATE TABLE IF NOT EXISTS `pagamentos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `consulta_id` INT NOT NULL,
    `valor` DECIMAL(10,2) NOT NULL,
    `forma_pagamento` ENUM('dinheiro', 'cartao', 'pix') NOT NULL,
    `status` ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consultas` (`id`) ON DELETE CASCADE,
    UNIQUE KEY `consulta` (`consulta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir usuário admin padrão
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`) VALUES
('Administrador', 'admin@odontogpt.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); 