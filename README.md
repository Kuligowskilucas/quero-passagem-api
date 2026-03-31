# Quero Passagem - API

Backend da aplicação de busca de passagens de ônibus, construído com Laravel 13. Integra com a API do Quero Passagem para buscar cidades, viagens e poltronas.

## Tecnologias

- PHP 8.3
- Laravel 13
- Guzzle HTTP Client

## Requisitos

- PHP >= 8.3
- Composer

## Instalação
```bash
git clone https://github.com/Kuligowskilucas/quero-passagem-api.git
cd quero-passagem-api
composer install
cp .env.example .env
php artisan key:generate
```

Configure as variáveis no `.env`:
```
QUERO_PASSAGEM_BASE_URL=https://queropassagem.qpdevs.com/ws_v4
QUERO_PASSAGEM_USER=seu_usuario
QUERO_PASSAGEM_PASS=sua_senha
QUERO_PASSAGEM_AFFILIATE=seu_codigo

SESSION_DRIVER=file
CACHE_STORE=file
```

## Executando
```bash
php artisan serve
```

A API ficará disponível em `http://localhost:8000`.

## Endpoints

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | /api/stops | Lista todas as cidades e rodoviárias |
| POST | /api/travels/search | Busca viagens disponíveis |
| POST | /api/travels/seats | Retorna mapa de poltronas |
| GET | /api/companies/{id} | Detalhes e logo da empresa |

## Estrutura
```
app/
├── Controllers/
│   ├── StopController.php
│   ├── TravelController.php
│   └── CompanyController.php
├── Exceptions/
│   └── QueroPassagemException.php
├── Http/
│   ├── Middleware/
│   │   └── ForceJsonResponse.php
│   └── Requests/
│       ├── SearchTravelRequest.php
│       └── GetSeatsRequest.php
└── Services/
    └── QueroPassagemService.php
```

## Decisões Técnicas

- **Service Pattern**: Centraliza toda comunicação com a API externa em um único service, facilitando manutenção e testes.
- **Cache**: Stops e dados de empresas são cacheados por 1 hora, reduzindo chamadas à API externa.
- **Form Requests**: Validação separada dos controllers, com mensagens em português.
- **Custom Exception**: Exceções específicas da integração para facilitar tratamento de erros.
- **ForceJsonResponse Middleware**: Garante que a API sempre retorne JSON, mesmo sem o header Accept.