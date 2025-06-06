# Meu Banco App

Um sistema de banco simplificado desenvolvido com Laravel, permitindo aos usuários realizar depósitos e transferências bancárias de forma segura e intuitiva. Este projeto simula operações bancárias básicas para fins educacionais e de demonstração.

## Funcionalidades

* **Autenticação de Usuário:** Login e registro de novos usuários.
* **Visão Geral:** Visão geral da conta do usuário.
* **Realizar Depósitos:** Adicionar fundos à conta.
* **Realizar Transferências:** Enviar fundos para outras contas dentro do sistema.
* **Mensagens de Confirmação:** Pop-ups de confirmação antes de depósitos e transferências.
* **Validação de Formulários:** Feedback visual para campos obrigatórios e formato correto.

## Tecnologias Utilizadas

* **Backend:** PHP  8.3+, Laravel  12.x
* **Banco de Dados:** MySQL (ou MariaDB, PostgreSQL)
* **Gerenciador de Dependências PHP:** Composer
* **Frontend:** HTML, CSS, JavaScript, Bootstrap 5.3.3

## Pré-requisitos

Certifique-se de ter os seguintes softwares instalados em seu ambiente de desenvolvimento:

* **PHP:** Versão 8.3 ou superior.
* **Composer:** Gerenciador de dependências para PHP.
* **Node.js e npm:** Para gerenciar e compilar os assets frontend.
* **Servidor de Banco de Dados:**  MySQL.
* **Servidor Web:** Ex: Nginx, Apache, ou o servidor embutido do PHP (`php artisan serve`).

## Instalação

Siga os passos abaixo para configurar e rodar o projeto em sua máquina local:

1.  **Clone o repositório:**
    git clone [https://github.com/](https://github.com/)[seu-usuario]/[seu-projeto].git
    cd [seu-projeto]
    *Substitua `[seu-usuario]/[seu-projeto]` pelo caminho real do seu repositório.*

2.  **Instale as dependências PHP:**
    composer install

3.  **Configure o arquivo de ambiente (`.env`):**
    * Copie o arquivo de exemplo:
        cp .env.example .env
    * Abra o arquivo `.env` recém-criado e configure as credenciais do seu banco de dados e outras variáveis de ambiente necessárias:
        ```env
        APP_NAME="Meu Banco App"
        APP_ENV=local
        APP_KEY=
        APP_DEBUG=true
        APP_URL=http://localhost

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=seu_banco_de_dados_aqui
        DB_USERNAME=seu_usuario_do_banco
        DB_PASSWORD=sua_senha_do_banco
        ```
        *Lembre-se de substituir `seu_banco_de_dados_aqui`, `seu_usuario_do_banco`, e `sua_senha_do_banco` pelas suas credenciais reais.*

4.  **Gere a chave da aplicação:**
    php artisan key:generate

5.  **Execute as migrações do banco de dados:**
    php artisan migrate

7.  **Inicie o servidor de desenvolvimento Laravel:**
    php artisan serve

## Utilização

Após a conclusão de todos os passos de instalação, abra seu navegador e acesse:

`http://127.0.0.1:8000`





