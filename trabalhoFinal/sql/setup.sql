-- PostgreSQL setup script for Sistema de Avaliação
-- Run with: psql -U <user> -d <dbname> -f setup.sql

CREATE TABLE IF NOT EXISTS dispositivos (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  status BOOLEAN NOT NULL DEFAULT true
);

CREATE TABLE IF NOT EXISTS setores (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS perguntas (
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  status BOOLEAN NOT NULL DEFAULT true
);

CREATE TABLE IF NOT EXISTS avaliacoes (
  id SERIAL PRIMARY KEY,
  setor_id INTEGER REFERENCES setores(id) ON DELETE SET NULL,
  pergunta_id INTEGER REFERENCES perguntas(id) ON DELETE CASCADE,
  dispositivo_id INTEGER REFERENCES dispositivos(id) ON DELETE SET NULL,
  resposta INTEGER NOT NULL CHECK (resposta >= 0 AND resposta <= 10),
  feedback TEXT,
  created_at TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TABLE IF NOT EXISTS usuarios (
  id SERIAL PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

INSERT INTO setores (nome) VALUES ('Recepção') ON CONFLICT DO NOTHING;
INSERT INTO setores (nome) VALUES ('Vendas') ON CONFLICT DO NOTHING;
INSERT INTO setores (nome) VALUES ('Caixa') ON CONFLICT DO NOTHING;

INSERT INTO dispositivos (nome, status) VALUES ('Tablet A - Recepção', true) ON CONFLICT DO NOTHING;

INSERT INTO perguntas (texto, status) VALUES ('Como você avalia o atendimento recebido?', true) ON CONFLICT DO NOTHING;
INSERT INTO perguntas (texto, status) VALUES ('Como avalia a limpeza do ambiente?', true) ON CONFLICT DO NOTHING;
INSERT INTO perguntas (texto, status) VALUES ('Como avalia a agilidade do serviço?', true) ON CONFLICT DO NOTHING;

-- <?php echo password_hash('sua_senha', PASSWORD_DEFAULT); ?>
-- a senha é teste123 e o usuario é admin

INSERT INTO usuarios (username, password) VALUES ('admin', '$2y$10$rcYZa0GXBk2cweFaJ.g9OuzXmxxc8m8ROwmpbP4MxM/XwpYZR3EiW');
