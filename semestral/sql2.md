INSERT INTO Setores (Descricao) VALUES ('Setor Geral');

INSERT INTO Dispositivos(Nome_Dispositivo) VALUES('Tablet');


INSERT INTO Perguntas (texto_pergunta) 
VALUES ('Como você avalia, de forma geral, o nosso hospital?');


SELECT * FROM Avaliacoes 
JOIN Perguntas ON Avaliacoes.id_pergunta = Perguntas.id_pergunta;
