-- Criação da tabela de usuários (administradores)
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,                       -- Identificador único do usuário
    nome_usuario VARCHAR(50) UNIQUE NOT NULL,   -- Nome de usuário (único e obrigatório)
    senha VARCHAR(255) NOT NULL                 -- Senha (obrigatória)
);

-- Inserção do administrador inicial
INSERT INTO usuarios (nome_usuario, senha) 
VALUES ('adm', 'adm123');

-- Criação da tabela de perguntas
CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,       -- Identificador único da pergunta
    pergunta TEXT NOT NULL       -- Texto da pergunta (obrigatório)
);

-- Criação da tabela de respostas (respostas anônimas)
CREATE TABLE respostas (
    id SERIAL PRIMARY KEY,                                    -- Identificador único da resposta
    id_pergunta INT REFERENCES perguntas(id) ON DELETE CASCADE, -- Relacionamento com perguntas
    valor_resposta INT CHECK (valor_resposta BETWEEN 0 AND 10), -- Valor entre 0 e 10
    comentario TEXT                                           -- Comentário opcional
);

-- Adicionando colunas para feedback às respostas
ALTER TABLE respostas
ADD COLUMN valor_feedback INT CHECK (valor_feedback BETWEEN 0 AND 10), -- Pontuação do feedback (0-10)
ADD COLUMN comentario_feedback TEXT;                                   -- Comentário do feedback

-- Criação da role para o administrador
CREATE ROLE adm WITH LOGIN PASSWORD 'adm123';

-- Concessão de privilégios ao administrador
GRANT ALL PRIVILEGES ON DATABASE semestral TO adm;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO adm;

-- Permissões de uso e seleção de sequências associadas às tabelas
GRANT USAGE, SELECT ON SEQUENCE perguntas_id_seq TO adm;
GRANT USAGE, SELECT ON SEQUENCE respostas_id_seq TO adm;

-- Inserção na tabela perguntas (corrigido)
INSERT INTO perguntas (pergunta)
VALUES ('Como você nos avalia?');

-- Consulta para recuperar dados
SELECT p.pergunta, r.valor_resposta, r.comentario, r.valor_feedback, r.comentario_feedback
FROM perguntas p
LEFT JOIN respostas r ON p.id = r.id_pergunta;


SELECT p.pergunta, r.valor_feedback, r.comentario_feedback
FROM perguntas p
LEFT JOIN respostas r ON p.id = r.id_pergunta;

