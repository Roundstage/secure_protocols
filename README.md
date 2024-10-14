# Projeto Secure Protocols

Olá! Eu sou o Allison e esse aqui é o meu desafio técnico para a eSocial. Baseado na conversa que tive na entrevista,
achei que poderia ser interessante desenvolver uma solução nesse aspecto. Secure Protocols é uma aplicação simples que
serve apenas para registrar protocolos de segurança para um usuário.

Nessa aplicação, teremos um login básico que é o "Manager". Ele cuidará dos processos de registros, entrega de cargos e
poderá operar no sistema. Também teremos a "Staff", que são os funcionários que utilizam o sistema. Os funcionários têm
acesso apenas à homepage onde estão seus protocolos de segurança e uma descrição dos seus trabalhos.

Escolhi utilizar Laravel, VueJS e Inertia para facilitar o desenvolvimento da single page application. Usei middlewares
e requests para uma dupla camada de segurança, e não utilizei serviços no back-end, devido à simplicidade das funções,
cada controller foi separado em uma classe única. Utilizei Bootstrap pois soube na entrevista que a eSocial também
costuma utilizar, e como um desafio para mim mesmo, me forcei a aprender PrimeVue, semelhante ao Bootstrap, mas feito
para o Vue.

## Passo a Passo para Executar o Projeto

### Requisitos

- Docker

### Configuração do Projeto
1. Execute as configurações básicas, podem ser alteradas depois.
```
[ ! -f .env ] && cp .env.example .env; docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php82-composer:latest composer install && sail up -d && sail artisan key:generate && sail npm install && sail artisan migrate --seed
```
2. **Execute o Sail**
   ```
   sail up -d
   ```
3. **Execute o vite**
   ```
   npm run dev
   ```

Com esse passo a passo acima, você deve conseguir entrar e executar o projeto. Basta entrar na URL definida no Env,
padrão Localhost, e você será redirecionado à página de login, onde deve entrar com o usuário padrão do sistema.

```
email: test@example.com
password: password
```
Nisso você tem acesso pra criar e editar, usuários, papeis, protocolos e alterar os papeis das roles.

Qualquer dúvida pode me chamar!
