# Sistema Gerenciador de Backlog (SGB)

## Descrição Curta
O SGB (Sistema Gerenciador de Backlog) é uma aplicação web desenvolvida para auxiliar no gerenciamento eficiente de backlogs de projetos, permitindo o cadastro, acompanhamento e organização de objetivos estratégicos, funcionalidades, tarefas e seus respectivos status, responsáveis e prazos.

**Status do Projeto:** Em Desenvolvimento (20 de Maio de 2025)

---

## Índice
1.  [Visão Geral Detalhada](#visão-geral-detalhada)
2.  [Funcionalidades Principais](#funcionalidades-principais)
3.  [Stack Tecnológico](#stack-tecnológico)
4.  [Pré-requisitos](#pré-requisitos)
5.  [Instalação e Configuração (Ambiente de Desenvolvimento)](#instalação-e-configuração-ambiente-de-desenvolvimento)
6.  [Executando a Aplicação](#executando-a-aplicação)
7.  [Importação de Dados Iniciais (CSV)](#importação-de-dados-iniciais-csv)
8.  [Estrutura do Projeto (Principais Diretórios Laravel)](#estrutura-do-projeto-principais-diretórios-laravel)
9.  [Deploy (Passos Gerais para Produção)](#deploy-passos-gerais-para-produção)
10. [Roadmap e Funcionalidades Futuras (Sugestões)](#roadmap-e-funcionalidades-futuras-sugestões)
11. [Como Contribuir (Opcional)](#como-contribuir-opcional)
12. [Autores](#autores)

---

## Visão Geral Detalhada
Este projeto visa substituir o gerenciamento de backlog baseado em planilhas por uma solução web centralizada e colaborativa. O SGB permite uma visão hierárquica do trabalho, desde objetivos trimestrais/semestrais até as tarefas individuais necessárias para alcançá-los. Ele também facilita a categorização de itens por sistemas, módulos e sprints, além de permitir o acompanhamento do progresso através de status e responsáveis.

O sistema foi inicialmente concebido para importar dados de planilhas CSV (`Backlog_GIMB_Organizado.xlsx - Visão Geral.csv` e `Backlog_GIMB_Organizado.xlsx - Tarefas.csv`).

## Funcionalidades Principais
* **Dashboard:** Tela inicial com visão geral e links rápidos.
* **Gerenciamento de Períodos (Quarters):** Criação e organização de trimestres/semestres para planejamento.
* **Gerenciamento de Objetivos Principais:** Definição de metas estratégicas vinculadas a períodos.
* **Gerenciamento de Funcionalidades (Features):** Detalhamento de entregáveis que contribuem para os objetivos.
* **Gerenciamento de Tarefas:** Criação, atribuição e acompanhamento de itens de trabalho detalhados.
    * Campos como título, descrição, tipo, prioridade, status, estimativa, datas, responsável, solicitante.
    * Associação a funcionalidades, sistemas, módulos e sprints.
* **Gerenciamento de Comentários em Tarefas:** Espaço para discussão e atualizações sobre as tarefas.
* **Gerenciamento de Categorias:**
    * **Sistemas:** Cadastro dos sistemas envolvidos no projeto (ex: APP, WEB, API).
    * **Módulos:** Cadastro de módulos, podendo ser associados a sistemas.
    * **Sprints:** Organização do trabalho em ciclos curtos de desenvolvimento.
* **Busca e Filtragem:** Capacidade de buscar e filtrar itens de backlog.
* **(Inicial) Gerenciamento de Usuários:** (Com estrutura para login e atribuição de responsáveis/solicitantes).

## Stack Tecnológico
* **Linguagem Backend:** PHP 8.x
* **Framework Backend:** Laravel 10.x
* **Banco de Dados:** MySQL 8.x
* **Frontend:** HTML5, CSS3, JavaScript (utilizando Blade Templates do Laravel)
* **Servidor Web (Desenvolvimento):** Servidor embutido do Laravel (`php artisan serve`)
* **Servidor Web (Produção):** Nginx ou Apache
* **Gerenciador de Dependências PHP:** Composer
* **Controle de Versão:** Git

## Pré-requisitos
Para rodar este projeto em um ambiente de desenvolvimento, você precisará ter instalado:
* PHP (versão compatível com Laravel 10.x, ex: >= 8.1)
* Composer
* Node.js e NPM (ou Yarn) - para dependências frontend e compilação de assets, se utilizado Vite/Mix.
* MySQL (ou outro SGBD compatível com Laravel, mas o projeto está configurado para MySQL)
* Git

## Instalação e Configuração (Ambiente de Desenvolvimento)

1.  **Clonar o Repositório:**
    ```bash
    git clone [URL_DO_SEU_REPOSITORIO_GIT] sgb-backlog
    cd sgb-backlog
    ```

2.  **Instalar Dependências PHP:**
    ```bash
    composer install
    ```

3.  **Instalar Dependências Frontend (se aplicável):**
    ```bash
    npm install
    # ou yarn install
    ```

4.  **Configurar Arquivo de Ambiente:**
    * Copie o arquivo de exemplo `.env.example` para `.env`:
        ```bash
        cp .env.example .env
        ```
    * Abra o arquivo `.env` e configure as variáveis de ambiente, especialmente as de conexão com o banco de dados (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`):
        ```env
        APP_NAME="SGB Backlog"
        APP_ENV=local
        APP_KEY=
        APP_DEBUG=true
        APP_URL=http://localhost:8000

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=sgb_backlog_db # Crie este banco de dados no seu MySQL
        DB_USERNAME=root # Seu usuário do MySQL
        DB_PASSWORD= # Sua senha do MySQL
        ```

5.  **Gerar Chave da Aplicação:**
    ```bash
    php artisan key:generate
    ```

6.  **Executar Migrations (Criar Tabelas no Banco de Dados):**
    Certifique-se de que seu servidor MySQL está rodando e que o banco de dados (`sgb_backlog_db` ou o nome que você definiu) foi criado.
    ```bash
    php artisan migrate
    ```

7.  **Executar Seeders (Popular Dados Iniciais, como usuário admin):**
    ```bash
    php artisan db:seed # Isso executará o UserSeeder e outros que você adicionar ao DatabaseSeeder.php
    ```

8.  **Compilar Assets Frontend (se aplicável com Vite/Mix):**
    ```bash
    npm run dev # Para desenvolvimento
    # ou npm run build # Para produção
    ```

## Executando a Aplicação
Para iniciar o servidor de desenvolvimento local do Laravel:
```bash
php artisan serve