<?php
include 'components/conexao.php';

$sqls = [
    "CREATE TABLE IF NOT EXISTS usuarios (
        id        SERIAL PRIMARY KEY,
        nome      VARCHAR(100)  NOT NULL,
        email     VARCHAR(150)  UNIQUE NOT NULL,
        senha     VARCHAR(255)  NOT NULL,
        criado_em TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS agendamentos (
        id         SERIAL PRIMARY KEY,
        usuario_id INTEGER,
        nome       VARCHAR(100) NOT NULL,
        data       DATE         NOT NULL,
        hora       TIME         NOT NULL,
        criado_em  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
    )",
    "CREATE TABLE IF NOT EXISTS assinaturas (
        id          SERIAL PRIMARY KEY,
        usuario_id  INTEGER      NOT NULL,
        plano       VARCHAR(50)  NOT NULL,
        data_inicio TIMESTAMP    NOT NULL,
        data_fim    TIMESTAMP    NOT NULL,
        ativo       SMALLINT     DEFAULT 1,
        criado_em   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
    )",
];

$erros = [];
foreach ($sqls as $sql) {
    try {
        $pdo->exec($sql);
    } catch (PDOException $e) {
        $erros[] = $e->getMessage();
    }
}

if (empty($erros)) {
    echo '✅ Tabelas criadas com sucesso! Pode deletar este arquivo.';
} else {
    echo '❌ Erros:<br>' . implode('<br>', $erros);
}
