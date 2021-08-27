# Sistema de Ponto Eletrônico em Laravel

Sistema de ponto eletrônico simplificado, desenvolvido em LARAVEL, para empresas que estão iniciando ou estudos.

## 🔧 Funcionalidades

* Inclusão, exclusão e modificação de Funcionário
* Ponto de entrada
* Ponto de saída
* Justificativa de falta
* Ajuste de ponto
* Aprovação de ponto
* Relatório de ponto mensal por Funcionário com percentual de presença, dias de faltas e justificativas.


## 🚀 Instalação
    
Desenvolvido utilizando Laravel 7.0

Configure no seu arquivo .env as conexões com o mySQL.

No seu cmd ou terminal, na pasta do projeto, inicie a instalação do sistema.

```
composer install
```

```
php artisan key:generate
```

```
php artisan migrate
```
 

### 💻 Demo

Funcionário: Registro do ponto (Entrada e Saída), correções de registros e justificativas.

Supervisor: Registro de funcionários, Aprovação/Rejeição de ponto, Relatórios de presença e horas

https://pontoeletronico.ilab4.me

### 📄 Licença

Este projeto está sob a licença MIT
