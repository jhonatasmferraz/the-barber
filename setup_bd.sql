-- ============================================================
--  The Barber — Criação do Banco de Dados
--  Execute este script no phpMyAdmin ou via terminal MySQL
-- ============================================================

CREATE DATABASE IF NOT EXISTS barbearia
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE barbearia;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(150)  NOT NULL,
    email      VARCHAR(150)  NOT NULL UNIQUE,
    senha      VARCHAR(255)  NOT NULL,
    criado_em  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id  INT,
    nome        VARCHAR(150) NOT NULL,
    data        DATE         NOT NULL,
    hora        TIME         NOT NULL,
    criado_em   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabela de assinaturas
CREATE TABLE IF NOT EXISTS assinaturas (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id   INT          NOT NULL,
    plano        VARCHAR(50)  NOT NULL,
    data_inicio  DATETIME     NOT NULL,
    data_fim     DATETIME     NOT NULL,
    ativo        TINYINT      DEFAULT 1,
    criado_em    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;
