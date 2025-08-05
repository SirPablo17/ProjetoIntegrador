# Projeto Integrador

Aplicação web para **agendamento de consultas online**, desenvolvida como projeto acadêmico. A plataforma permite que usuários realizem agendamentos de forma simples e eficiente, contribuindo para a modernização da gestão de atendimentos.

---

## ✨ Funcionalidades

- Cadastro de usuários e pacientes  
- Controle de acesso baseado em perfil (Administrador e Usuário Comum)  
- Agendamento e visualização de consultas  
- Interface simples e intuitiva  
- Agendamento e visualização por meio de um **calendário interativo**  
- Exportação para Excel das consultas agendadas  
- Exportação para Excel dos usuários do sistema  

---

## 🚀 Tecnologias Utilizadas

- HTML  
- CSS  
- JavaScript  
- PHP  
- SQL Server  

---

## ⚙️ Como Instalar e Executar o Projeto

### 1. Instale o XAMPP  
Faça o download e instale o [XAMPP](https://www.apachefriends.org/pt_br/index.html) em sua máquina.

### 2. Baixe e configure o driver de conexão SQL Server para PHP

#### Passos para configuração:

1. Acesse o site oficial da Microsoft:  
   [Drivers PHP para SQL Server](https://learn.microsoft.com/pt-br/sql/connect/php/download-drivers-php-sql-server)

2. Baixe o driver compatível com a versão do PHP do seu XAMPP e sua arquitetura (x86 ou x64).

3. Extraia os arquivos `.dll` do arquivo baixado.

4. Copie os arquivos `php_sqlsrv.dll` e `php_pdo_sqlsrv.dll` para a pasta de extensões do PHP no XAMPP, geralmente:  
   `C:\xampp\php\ext`

5. Edite o arquivo `php.ini` (normalmente em `C:\xampp\php\php.ini`) adicionando as linhas abaixo no final do arquivo:  
   ```ini
   extension=php_sqlsrv.dll
   extension=php_pdo_sqlsrv.dll

---

## Colaboradores do Projeto:
Pablo Nascimento – https://www.linkedin.com/in/pablo-nascimento-b9a571226/

Arthur Yukio – https://www.linkedin.com/in/arthur-yukio-nishimura-vieira-2133a017a/

Cauê Rodrigues – https://www.linkedin.com/in/cau%C3%AA-rodrigues-746636207/

Isaque Carlos – https://www.linkedin.com/in/isaquecarlos/
