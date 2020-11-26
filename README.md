# Back End Test
Esse repositório pertence a solução do teste BackEnd proposto pela Coderockr.

## Tecnologias utilizadas
1. PHP 7.2.5;
2. Laravel 7.0;
3. MySql 8;
4. JWT Authentication/lcobucci;

## Instruções para instalação

1. Copie o arquivo <strong>.env.exemple</strong> e o renomeie para <strong>.env</strong>;
2. Configure dentro do <strong>.env</strong> o acesso ao banco de dados;
- 2.1 DB_HOST= YOUR DATABASE HOST
- 2.2 DB_PORT= THE DATABASE ACCESS PORT
- 2.3 DB_DATABASE= YOUR EMPTY DATABASE
- 2.4 DB_USERNAME= YOUR DATABASE ACCESS USERNAME
- 2.5 DB_PASSWORD= YOUR DATABASE ACCESS PASSWORD
3. Execute o comando <strong>composer install</strong> para instalar as dependências necessárias;
4. Execute o comando <strong>php artisan generateJwt:key</strong> para gerar a chave de autenticação JWT;
- 4.1 Após gerar a chave, verifique se o campo <strong>JWT_SECRET</strong> foi gerado corretamente no <strong>.env</strong>;
5. Execute o comando <strong>php artisan migrate</strong> para gerar as tabelas e os relacionamentos no banco de dados selecionado no <strong>.env</strong>;
6. Execute o comando <strong>php artisan db:seed</strong> para gerar alguns dados essenciais para as tabelas de <strong>status</strong> e <strong>event_status</strong>;
7. Execute o comando <strong>php artisan storage:link</strong> para criar um link simbólico e permitir o armazenamento de imagens como a imagem de perfil, por exemplo;
8. Por fim, execute o comando <strong>php artisan serve</strong> para executar a aplicação;
- 8.1 Caso o envio de emails seja necessário, basta preencher os campos do SMTP dentro do <strong>.env</strong>, a aplicação está pronta para efetuar os envios;

## Rotas
<h4>Autenticação e Cadastro</h4>
  - <strong>POST > </strong> /api/login
    - Valida as credenciais do usuário e retorna o token de acesso.
    - Campos.
        - email
        - password
     
  - <strong>POST > </strong> /api/register
    - Efetua o cadastro de um novo usuário.
    - Campos.
        - name
        - email
        - password
        - resume
        - profile_picture
        - city
        - state 
       
<h4>Eventos</h4>
   - <strong>GET > </strong> /api/events
    - Lista todos os eventos cadastrados.
    - Filtros:
        - status
            - Como usar: /api/events?dateStart=>=:2020-11-25&dateEnd=<=:2020-11-30&state==:MG
            - Padrão: filterName=operation:value
      
  - <strong>GET > </strong> /api/event/{eventId}
    - Retorna os detalhes de determinado evento.
        
  - <strong>(JWT) POST > </strong> /api/create-event
    - Cadastra um novo evento.
    - Campos.
        - user_id
        - event_name
        - date (Ex: 2020-11-25 19:00:00)
        - street
        - number
        - city
        - state
         
  - <strong>(JWT) GET > </strong> /api/my-events/{userId}
    - Lista os eventos de determinado usuário.
    
  - <strong>(JWT) PUT > </strong> /api/update-event/{userId}/{eventId}
    - Atualiza os dados de um evento.
    - Campos opcionais.
        - event_name
        - date (Ex: 2020-11-25 19:00:00)
        - street
        - number
        - city
        - state  
        
  - <strong>(JWT) POST > </strong> /api/cancel-event/{userId}/{eventId}
    - Cancela determinado evento.  
    
  - <strong>(JWT) POST > </strong> /api/invite-for-event
    - Convida amigos para participar do evento.
    - Campos
        - event_id
        - friends (Opcional)
            - O campo friends é opcional, caso ele não seja preenchido será enviado uma solicitação para todos os amigos, mas também é possivel enviar um determinado grupo de amigos (friends: [friend_id, friend_id, friend_id...]) e também é possivel enviar para apenas um amigo (friends: friend_id)           
  
  - <strong>(JWT) GET > </strong> /api/my-event-invites/{userId}
    - Lista todos os convites de eventos de um usuário
    - Filtros:
        - status
            - Como usar: /my-event-invites/{userId}?status=1
            - Padrão: filterName=value (1 = pending, 2 = accepted, 3 = rejected)
       
  - <strong>(JWT) POST > </strong> /api/event-action
    - Aceita ou rejeita participar de um evento caso o mesmo ainda esteja disponível 
    - Campos:
        - user_id
        - invite_id
        - action (2 = accepted, 3 = rejected)    
        
  - <strong>(JWT) GET > </strong> /api/event-member-list/{eventId}
    - Retorna os membros de um determinado evento
    - Filtros:
        - status
            - Como usar: /event-member-list/{eventId}?status=1
            - Padrão: filterName=value (1 = pending, 2 = accepted, 3 = rejected)    
            
<h4>Amigos</h4>

  - <strong>(JWT) POST > </strong> /api/new-friend-request/{userId}
    - Envia um pedido de amizade
    - Campos:
        - email
            - Caso o email pertença a algum usuario ele receberá o convite, caso seja um novo usuario ele receberá um email com instuções para se cadastrar. 

  - <strong>(JWT) GET > </strong> /api/get-friend-request/{userId}
    - Lista os pedidos de amizade pendentes
    
  - <strong>(JWT) POST > </strong> /api/reject-friend-request/{userId}
    - Rejeita um pedido de amizade
    - Campos:
        - friend_request_id
        
  - <strong>(JWT) POST > </strong> /api/accept-friend-request/{userId}
    - Aceita um pedido de amizade
    - Campos:
        - friend_request_id    
        
  - <strong>(JWT) GET > </strong> /api/get-friend-list/{userId}
    - Lista os amigos de um determinado usuário  
    
  - <strong>(JWT) POST > </strong> /api/remove-friend/{userId}
    - Remove um amigo
    - Campos:
        - friend_id        
        
<h4>Perfil</h4>     

  - <strong>(JWT) GET > </strong> /api/my-profile/{userId}
    - Retorna os dados de cadastro de um usuário             
            
## Informações complementares
- Na url base do projeto ('/') está a documentação escrita utilizando HTML, CSS e BootStrap 4 para facilitar o uso e testes da API.
- A API foi hospedada na HEROKU para auxiliar nos testes <a href="https://coderockr-test.herokuapp.com/">Link da API na HEROKU</a>
    - A hospedagem gratuita da HEROKU possui algumas limitações, caso ela seja utilizada para algum teste, considere os seguintes aspectos: 
        - Não é possivel armazenar imagens gratuitamente na Heroku, logo as imagens de perfil não serão exibidas;
        - O SMTP bloqueia automaticamente o envio de emails após algum tempo, por isso os emails não seram enviados;
