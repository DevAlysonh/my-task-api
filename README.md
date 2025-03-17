## My tasks API Guia

### Requisitos:
* docker;
* nodeJS mais recente;

### Primeiro clone este repositorio:
```
git clone git@github.com:DevAlysonh/my-task-api.git
```

### Com o repositório clonado, siga os seguintes passos:
```
cd my-task_api
cd backend
```
### Já dentro do diretorio backend, faça as seguintes configurações:
```
cp .env.example .env
cp .env.example .env.testing
```

### Então edite os aquivos com as credenciais de acesso ao banco, e com o nome correto do ambiente:
```
.env:
  APP_ENV=local

  DB_CONNECTION=mysql
  DB_HOST=my-tasks-db
  DB_PORT=3306
  DB_DATABASE=my_tasks_api_development
  DB_USERNAME=root
  DB_PASSWORD=rootsecret

.env.testing:
  APP_ENV=testing

  DB_CONNECTION=mysql
  DB_HOST=my-tasks-db
  DB_PORT=3306
  DB_DATABASE=my_tasks_api_testing
  DB_USERNAME=root
  DB_PASSWORD=rootsecret
```

### Agora, ainda dentro do diretorio backend, suba os containers, e instale as dependencias:
```
docker-compose up -d
docker exec -it my-tasks-php composer install
docker exec -it my-tasks-php php artisan key:generate
docker exec -it my-tasks-php php artisan key:generate --env=testing
docker exec -it my-tasks-php php artisan migrate
docker exec -it my-tasks-php php artisan db:seed
docker exec -it my-tasks-php php artisan migrate --env=testing
```

### Não há implementação de registro de usuário, reset de senha etc; então para testar a api, você pode criar um usuário manualmente no banco, usando o tinker, ou usar o usuário de testes, que será criado com os seeders:
## email: test@example.com
## password: password

### Na raiz do projeto, há uma collection do postman, com todas as rotas configuradas, caso você queira, pode utilizá-la.

# A API Requer autenticação!

### Se não houve nenhum problema até aqui, a api já deve estar disponível em http://localhost/api/

#### Rotas da API:
##### Auth:
* POST - /login - (Permite ao usuario cadastrado fazer login na aplicação; Parâmetros: email: email, password: string);
* DELETE - /logout - (Permite encerrar a sessão);

##### Tasks:
* GET - /tasks - (Lista todas as tarefas, e pode receber dois filtros: status: string, created_at: date);
* GET - /tasks/{task} - (Encontra informações sobre uma tarefa específica);
* PATH - /tasks/{task} - (Atualiza informações sobre uma tarefa; Parâmetros aceitos: title: string, description: string, status: enum: [pending, process, cancelled, completed]);
* POST - /tasks - (Permite criar uma nova tarefa; Parâmetros aceitos: title:string, description:string; O status inicial será sempre 'Pendente');
* DELETE - /tasks/{task} -> (Permite deletar uma task do DB)
##### Comments:
* POST - /comments - (Permite criar um comentário para uma track; Parâmetros aceitos: task_id: int-required, content: string-required);
* DELETE - /comments/{comment} - (Permite deletar um comentário);
  
## Acessando o front-end:

### Vá até a pasta frontend da raiz do projeto, e execute os comandos:
```
npm install && npm run dev
```

### Se tudo ocorreu bem, você pode acessar http://localhost:5173/
