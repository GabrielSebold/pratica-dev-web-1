CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto VARCHAR(255) NOT NULL,
    ordem INTEGER NOT NULL,
    tipo VARCHAR(20) NOT NULL DEFAULT 'scale',
    escala_min INTEGER DEFAULT 0,
    escala_max INTEGER DEFAULT 10,
    descricao_min VARCHAR(50) DEFAULT 'Pouco satisfeito',
    descricao_max VARCHAR(50) DEFAULT 'Muito satisfeito'
);

CREATE TABLE avaliacoes (
  id SERIAL PRIMARY KEY,
  criado_em TIMESTAMP WITHOUT TIME ZONE DEFAULT now()
);

ALTER TABLE avaliacoes DROP COLUMN IF EXISTS id_setor;
ALTER TABLE avaliacoes DROP COLUMN IF EXISTS id_dispositivo;

CREATE TABLE respostas (
  id SERIAL PRIMARY KEY,
  avaliacao_id INTEGER REFERENCES avaliacoes(id) ON DELETE CASCADE,
  pergunta_id INTEGER REFERENCES perguntas(id) ON DELETE CASCADE,
  nota INTEGER,
  texto TEXT,
  pergunta_texto TEXT
);
