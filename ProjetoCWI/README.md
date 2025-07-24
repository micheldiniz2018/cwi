Documentação do Projeto Laravel - API de Health Check
📋 Pré-requisitos
Docker e Docker Compose instalados

PHP 8.2+

Composer 2.5+

🚀 Instalação
1. Clone o repositório
git clone https://github.com/micheldiniz2018/cwi
cd ProjetoCWI

2. Configure o ambiente
Copie o arquivo .env.example para .env:
cp .env.example .env
Edite o .env e configure:
EXTERNAL_HEALTH_CHECK_URL=http://localhost:3000/health
APP_URL=http://localhost:8000

3. Instale as dependências
docker-compose run --rm composer install

4. Inicie os containers
docker-compose up -d

🌐 Rotas da API
POST /api/health
Verifica o status da API externa configurada.

Requisição:
curl -X POST http://localhost:8000/api/health \
  -H "Content-Type: application/json"
Respostas:
Sucesso (API externa saudável):
{
  "status": "healthy",
  "external_api_status": 200,
  "response_time_ms": 125.42,
  "checked_at": "2023-11-15 14:30:45"
}
Falha (API externa com problemas):
{
  "status": "unhealthy",
  "external_api_status": 503,
  "response_time_ms": 250.15,
  "checked_at": "2023-11-15 14:31:22"
}
Erro (API inacessível):
{
  "status": "unreachable",
  "error": "Connection timed out",
  "checked_at": "2023-11-15 14:32:10"
}