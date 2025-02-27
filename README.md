<p align="center"><img src="https://spassu.zohorecruit.com/recruit/viewCareerImage.do?page_id=678402000000417658&type=logo&file_name=MicrosoftTeams-image__37_.png" width="400" alt="Spassu Logo"></p>
<p align="center">
<b>Posição:</b> Especialista Desenvolvedor Sênior - PHP (eProc) <br>
<b>Candidato:</b> José Ricardo Junior</p>

<p align="center">
<a href="https://github.com/terraze/spassu/actions"><img src="https://github.com/terraze/spassu/actions/workflows/laravel.yml/badge.svg?branch=master" alt="Build Status"></a>
</p>

## Requisitos

- Docker
- PHP 8.3
- Composer

## Instalação

Comandos a serem executados em terminal linux (ou WSL2):

```bash
# Clonar o repositório
git clone https://github.com/terraze/spassu.git

# Acessar o diretório do projeto
cd spassu

# Instalar as dependências
composer install

# Iniciar o container do Docker
./vendor/bin/sail up -d

# Executar as migrações
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

Pronto, basta acessar a aplicação no navegador:

```bash
http://localhost:8000
```

## Comandos utilizado para desenvolver o projeto (neste ordem)

```bash
# Inicialização do projeto
composer global require laravel/installer
laravel new spassu-php
php artisan sail:install
php artisan key:generate

# Inicialização do repositório
git init
git add .
git commit -m "Commit inicial"
git remote add origin https://github.com/terraze/spassu.git
git push -u origin master

# Criação de models com inclusão automática de migrations (m), controllers (c), seeders (s) e pivot (p)
./vendor/bin/sail artisan make:model Assunto -mcs
./vendor/bin/sail artisan make:model Autor -mcs
./vendor/bin/sail artisan make:model Livro -mcs
./vendor/bin/sail artisan make:model Livro_Assunto -msp
./vendor/bin/sail artisan make:model Livro_Autor -msp

# Após criar as migrações e seeders
./vendor/bin/sail artisan migrate -seed
```

## Alterações realizados no SQL
- Corrigido nome da chave primária de Assunto de codAs para CodAs para manter o padrão CamelCase.
- Corrigido nome da chave estrangeira de Livro_Assunto de Assunto_codAs para Assunto_CodAs para manter o padrão CamelCase.
- Corrigido nome da chave primária de Livro de Codl para CodL (e suas referências em chaves estrangeiras) para manter o padrão CamelCase.
- Todas as chaves estão usando Unsigned Integer ao invés de Integer, já que não existe ID negativo.

## Licença

Este projeto deve ser usado apenas para fins de teste das habilidades do candidato.
