-- Tabela para setores
CREATE TABLE Setores (
    ID_Setor SERIAL PRIMARY KEY,
    Descricao VARCHAR(50) NOT NULL
);

-- Tabela para dispositivos
CREATE TABLE Dispositivos (
    ID_Dispositivo SERIAL PRIMARY KEY,
    Nome_Dispositivo VARCHAR(255) NOT NULL,
    Status VARCHAR(10) CHECK (Status IN ('ativo', 'inativo')) DEFAULT 'ativo'
);

-- Tabela para perguntas
CREATE TABLE Perguntas (
    ID_Pergunta SERIAL PRIMARY KEY,
    Texto_Pergunta TEXT NOT NULL,
    Status VARCHAR(10) CHECK (Status IN ('ativa', 'inativa')) DEFAULT 'ativa'
);

-- Tabela para usuários administrativos
CREATE TABLE Usuarios_Administrativos (
    ID_Usuario SERIAL PRIMARY KEY,
    Login VARCHAR(255) NOT NULL UNIQUE,
    Senha VARCHAR(255) NOT NULL
);

-- Criar o usuário administrador
INSERT INTO Usuarios_Administrativos (Login, Senha)
VALUES ('adm', 'adm123');

GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE Usuarios_Administrativos TO adm;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO adm;


-- Tabela para armazenar as avaliações
CREATE TABLE Avaliacoes (
    ID_Avaliacao SERIAL PRIMARY KEY,
    ID_Setor INT NOT NULL,
    ID_Pergunta INT NOT NULL,
    ID_Dispositivo INT NOT NULL,
    Resposta SMALLINT NOT NULL CHECK (Resposta BETWEEN 0 AND 10),
    Feedback_Textual TEXT,
    Data_Hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Setor) REFERENCES Setores(ID_Setor),
    FOREIGN KEY (ID_Pergunta) REFERENCES Perguntas(ID_Pergunta),
    FOREIGN KEY (ID_Dispositivo) REFERENCES Dispositivos(ID_Dispositivo)
);
