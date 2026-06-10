# 🩸 iDonate

Plataforma de doação desenvolvida como trabalho da disciplina de **Engenharia de Software** — 5° período UNIVALI.

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- [PHP 8.1+](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [Node.js 18+](https://nodejs.org/) e npm
- [PostgreSQL 15+](https://www.postgresql.org/download/)
- [Git](https://git-scm.com/)

---

## 🐘 1. Instalando o PHP

### Windows

1. Acesse [https://windows.php.net/download](https://windows.php.net/download) e baixe a versão **Thread Safe** mais recente (ZIP).
2. Extraia o conteúdo para `C:\php`.
3. Adicione `C:\php` às variáveis de ambiente do sistema (`PATH`).
4. Renomeie o arquivo `php.ini-development` para `php.ini` dentro da pasta `C:\php`.
5. Abra o `php.ini` e habilite as extensões necessárias removendo o `;` das linhas:
   ```
   extension=pdo_pgsql
   extension=pgsql
   extension=mbstring
   extension=openssl
   extension=fileinfo
   extension=curl
   ```
6. Verifique a instalação:
   ```bash
   php -v
   ```

### Linux (Ubuntu/Debian)

```bash
sudo apt update
sudo apt install php php-cli php-mbstring php-xml php-curl php-zip php-pgsql unzip -y
php -v
```

### macOS (via Homebrew)

```bash
brew install php
php -v
```

---

## 🎼 2. Instalando o Composer

O Composer é o gerenciador de dependências do PHP, necessário para instalar o Laravel.

### Windows

Baixe e execute o instalador em: [https://getcomposer.org/Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)

### Linux / macOS

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

---

## 🚀 3. Instalando o Laravel

O Laravel é instalado via Composer. Para instalar globalmente o instalador:

```bash
composer global require laravel/installer
```

> **Nota:** Este repositório já é um projeto Laravel existente. Não é necessário criar um novo projeto, apenas clonar e instalar as dependências (veja a seção de configuração abaixo).

---

## 🔪 4. Sobre o Blade

O **Blade** é a engine de templates nativa do Laravel — não requer instalação separada, pois já vem incluído com o framework. Os arquivos Blade ficam em `resources/views/` e utilizam a extensão `.blade.php`.

---

## 🐘 5. Instalando o PostgreSQL

### Windows

1. Baixe o instalador em: [https://www.postgresql.org/download/windows](https://www.postgresql.org/download/windows)
2. Execute o instalador e siga o assistente. Anote a **senha** definida para o usuário `postgres`.
3. Após a instalação, use o **pgAdmin** (incluído) ou o terminal `psql` para criar o banco:
   ```sql
   CREATE DATABASE idonate;
   ```

### Linux (Ubuntu/Debian)

```bash
sudo apt update
sudo apt install postgresql postgresql-contrib -y
sudo systemctl start postgresql
sudo systemctl enable postgresql

# Acessar o PostgreSQL e criar o banco
sudo -u postgres psql
```
```sql
CREATE DATABASE idonate;
CREATE USER seu_usuario WITH PASSWORD 'sua_senha';
GRANT ALL PRIVILEGES ON DATABASE idonate TO seu_usuario;
\q
```

### macOS (via Homebrew)

```bash
brew install postgresql@15
brew services start postgresql@15

# Criar o banco
psql postgres
```
```sql
CREATE DATABASE idonate;
\q
```

---

## ⚙️ 6. Configurando o Projeto

### Clone o repositório

```bash
git clone https://github.com/HanryLedoux/iDonate.git
cd iDonate
```

### Instale as dependências PHP

```bash
composer install
```

### Instale as dependências JavaScript

```bash
npm install
```

### Configure o arquivo de ambiente

```bash
cp .env.example .env
php artisan key:generate
```

> Edite o arquivo `.env` com as configurações do seu banco de dados:
> ```
> DB_CONNECTION=pgsql
> DB_HOST=127.0.0.1
> DB_PORT=5432
> DB_DATABASE=idonate
> DB_USERNAME=seu_usuario
> DB_PASSWORD=sua_senha
> ```

### Execute as migrations

```bash
php artisan migrate
```

---

## ▶️ 7. Iniciando o Servidor

### Iniciar o servidor PHP (Laravel)

```bash
php artisan serve
```

O projeto estará disponível em: **[http://localhost:8000](http://localhost:8000)**

### Compilar os assets (Tailwind + Vite) — em outro terminal

```bash
npm run dev
```

> Para gerar os assets para produção:
> ```bash
> npm run build
> ```

---

## 🛠️ Tecnologias Utilizadas

| Tecnologia | Função |
|---|---|
| PHP | Linguagem back-end |
| Laravel | Framework PHP |
| Blade | Engine de templates |
| PostgreSQL | Banco de dados |
| Tailwind CSS | Estilização |
| Vite | Bundler de assets |
| TypeScript | Scripts front-end |
