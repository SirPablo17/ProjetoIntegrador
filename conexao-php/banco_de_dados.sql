

CREATE DATABASE ProjetoIntegrador2

-- Tabela: tblUsuario
CREATE TABLE tblUsuario (
    usuarioID INT PRIMARY KEY IDENTITY(1,1),
    roleUsuario VARCHAR(50),
    nome VARCHAR(100),
    CPF CHAR(11),
    endereco VARCHAR(200),
	NumeroCasa VARCHAR(15),
    emailUsuario VARCHAR(100),
    senhaUsuario VARCHAR(100),
    CEP CHAR(8),
    telefoneUsuario VARCHAR(20),
    usuarioAtivoInativo BIT,
    dataNascimento DATE,
    dataCadastro DATETIME DEFAULT GETDATE(),
    quantidadeTentativas INT
);

-- Tabela: tblConsulta
CREATE TABLE tblConsulta (
    consultaID INT PRIMARY KEY IDENTITY(1,1),
    usuarioID INT,
    valorConsulta DECIMAL(10, 2),
    dataConsulta DATETIME,
    consultaConfirmada BIT,
    FOREIGN KEY (usuarioID) REFERENCES tblUsuario(usuarioID)
);

-- Tabela: tblProcedimentos
CREATE TABLE tblProcedimentos (
    procedimentoID INT PRIMARY KEY IDENTITY(1,1),
    valorProcedimento DECIMAL(10, 2),
    tempoProcedimento INT, -- Em minutos
    descricaoProcedimento VARCHAR(200)
);

-- Tabela: tblConsultaProcedimento (Relacionamento N:N)
CREATE TABLE tblConsultaProcedimento (
    consultaID INT,
    procedimentoID INT,
    PRIMARY KEY (consultaID, procedimentoID),
    FOREIGN KEY (consultaID) REFERENCES tblConsulta(consultaID),
    FOREIGN KEY (procedimentoID) REFERENCES tblProcedimentos(procedimentoID)
);
