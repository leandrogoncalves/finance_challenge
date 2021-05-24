<h1 align="center">
Desafio de produto financeiro
</h1>

<p align="center">Este projeto foi desenvolvido exclusivamente para teste de conhecimento técnico</p>

<p align="center">
  <a href="https://github.com/leandrogoncalves/nestjs_smartranking_api/graphs/contributors">
    <img src="https://img.shields.io/github/contributors/leandrogoncalves/nestjs_smartranking_api?color=%237159c1&logoColor=%237159c1&style=flat" alt="Contributors">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/github/license/leandrogoncalves/nestjs_smartranking_api?color=%237159c1&logo=mit" alt="License">
  </a>
</p>

<hr>

## Participantes

| [<img src="https://avatars3.githubusercontent.com/u/12039813?s=460&u=78af286aeb7f9d808dc21635e331d0ecdb08e8a7&v=4" width="75px;"/>](https://github.com/leandrogoncalves) |
| :----------------------------------------------------------------------------------------------------------------------------------------------------------------------: |

| [Leandro Gonçalves](https://github.com/leandrogoncalves)


## Dependências

- Docker: 20.10.5
- Docker-compose: 1.28.5
- PHP : 7.3.15
- Laravel : 8.42.1

## Configuração inicial

1. Clone o repositório: `git clone git@github.com:leandrogoncalves/finance_challenge.git`
1. Acesse a pasta do projeto: `cd finance_challenge`
1. Execute os containers no Docker: `docker-compose up`
1. Atribua permissão de execução no script de inicialização: `chmod +x ./scripts/startup.sh`
1. Execute o script de inicialização: `./scripts/setup.sh`

## Documentação

- Acesse http://localhost:8081/api/documentation

## Testes

1. Acesse a pasta do projeto: `cd finance_challenge`
1. Execute no terminal `docker exec -ti finance_challenge_app_1 bash -c "php artisan test"`
