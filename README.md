# Encurtador de URL

Este é um projeto de encurtador de URL desenvolvido com Laravel e Vue.js.

## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em seu ambiente de desenvolvimento:

- PHP 8
- Laravel 10
- Node.js v18
- Composer

## Configuração Inicial

1. Clone este repositório:

    ```bash
    git clone https://github.com/arthurzera-s/encurtador
    ```

2. Instale as dependências do Laravel:

    ```bash
    composer install
    ```

3. Copie o arquivo `.env.example` para `.env` e configure suas variáveis de ambiente, incluindo a porta:

    ```bash
    cp .env.example .env
    ```

4. Gere a chave de aplicação:

    ```bash
    php artisan key:generate
    ```

5. Execute as migrações do banco de dados:

    ```bash
    php artisan migrate
    ```

6. Instale as dependências do Node.js e compile os ativos:

    ```bash
    npm install
    npm run dev
    ```

## Executando o Servidor

Execute o servidor Laravel:

```bash
php artisan serve
