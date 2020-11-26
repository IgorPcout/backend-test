<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documentação</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body{
            background-color: #f8f9fa;
        }
        .bdg{
            font-size: 18px;
        }
        .ac-bg-success{
            background-color: #00FF7F;
        }
        .ac-bg-warning{
            background-color: #F0E68C;
        }
        .ac-bg-info{
            background-color: #7FFFD4;
        }
        .ac-bg-danger{
            background-color: #FF6347;
        }
        .ac-title{
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            color: black;
        }
        .ac-description{
            color: black;
            font-size: 14px;
            font-weight: bold;
        }
        .buttom-hover:hover{
            text-decoration: none;
        }
    </style>

</head>
<body>
<div class="container">
    <div class="jumbotron mt-2">
        <h1 class="display-4">BackEnd Test, Coderockr!</h1>
        <p class="lead">Esse projeto foi desenvolvido para o teste de desenvolvedor BackEnd da Coderockr.</p>
        <hr class="my-4">
        <p>Abaixo estará descrito as rotas, seus parametros e retornos.</p>
        <a class="btn btn-outline-dark float-left" href="#" role="button">Código no GitHub <i class="fab fa-github"></i> </a>
        <button class="btn btn-outline-info float-right" data-toggle="modal" data-target="#exampleModal" role="button">Informações Importantes <i class="fas fa-info-circle"></i> </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações Importantes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Informações importantes</h3>
                    <p>Essa API utiliza autenticação JWT, seu token tem duração de 30 minutos.</p>
                    <p>A API será hospedada na HEROKU, para facilitar os testes.</p>
                    <p>A hospedagem gratuita da HEROKU não aceita hospedagem de imagens, por esse motivo, não será possivel testar o upload de imagens na aplicação hospedada.</p>
                    <p>Para executar em localhost, será necessario configurar o acesso ao banco de dados no .env.</p>
                    <p>Para o envio de emails, basta configurar um email valido nas configurações de smtp do .env.</p>
                    <hr>
                    <h4>Instuções para instalação em localhost</h4>
                    <p>Renomeie o <strong>.env.example</strong> para <strong>.env</strong>.</p>
                    <p>Após isso, execute os comandos listados abaixo.</p>
                    <ul class="list-group">
                        <li class="list-group-item"><storng>1 - </storng>composer install</li>
                        <li class="list-group-item"><storng>2 - </storng>php artisan generateJwt:key</li>
                        <li class="list-group-item"><storng>3 - </storng>php artisan migrate</li>
                        <li class="list-group-item"><storng>4 - </storng>php artisan db:seed</li>
                        <li class="list-group-item"><storng>5 - </storng>php artisan storage:link</li>
                        <li class="list-group-item"><storng>6 - </storng>php artisan serve</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <h3>Autenticação e Cadastro</h3>
    <div class="mt-4" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/login</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Valida as credenciais do usuario e retorna o token de acesso</span>
                    </button>
                    <!--<span class="float-right mt-2"> <i class="fas fa-key"></i></span>-->
                </h5>
            </div>
            <div id="collapse1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/login</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">email</li>
                        <li class="list-group-item">password</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/register</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Efetua o cadastro de um novo usuario</span>
                    </button>
                    <!--<span class="float-right mt-2"> <i class="fas fa-key"></i></span>-->
                </h5>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/register</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">name</li>
                        <li class="list-group-item">email</li>
                        <li class="list-group-item">password</li>
                        <li class="list-group-item">resume</li>
                        <li class="list-group-item">profile_picture</li>
                        <li class="list-group-item">city</li>
                        <li class="list-group-item">state</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <hr>
    <h3>Eventos</h3>
    <div class="mt-4" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/events</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Lista todos os eventos cadastrados</span>
                    </button>
                    <!--<span class="float-right mt-2"> <i class="fas fa-key"></i></span>-->
                </h5>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/events</p>
                    <h4>Filtros: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">dateStart</li>
                        <li class="list-group-item">dateEnd</li>
                        <li class="list-group-item">state</li>
                    </ul>
                    <hr>
                    <p class="text-center"><strong>Como usar: </strong> {{env('APP_URL')}}/api/events?dateStart=>=:2020-11-25&dateEnd=<=:2020-11-30&state==:MG</p>
                    <p class="text-center"><strong>Padrão: </strong> filterName=operation:value</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/event/{eventId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Retorna os detalhes de determinado evento</span>
                    </button>
                    <!--<span class="float-right mt-2"> <i class="fas fa-key"></i></span>-->
                </h5>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/event/{eventId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/create-event</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Faz o cadastro de um novo evento</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse5" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/create-event</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">user_id</li>
                        <li class="list-group-item">event_name</li>
                        <li class="list-group-item">date (Ex: 2020-11-25 19:00:00)</li>
                        <li class="list-group-item">street</li>
                        <li class="list-group-item">number</li>
                        <li class="list-group-item">city</li>
                        <li class="list-group-item">state</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/my-events/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Lista os eventos de um determinado usuario</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse6" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/my-events/{userId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-info" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
                        <span class="badge badge-pill badge-info bdg">PUT</span>
                        <span class="ml-4 ac-title">/update-event/{userId}/{eventId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Atualiza os dados de um evento</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse7" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/update-event/{userId}/{eventId}</p>
                    <h4>Campos opcionais: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">event_name</li>
                        <li class="list-group-item">date (Ex: 2020-11-25 19:00:00)</li>
                        <li class="list-group-item">street</li>
                        <li class="list-group-item">number</li>
                        <li class="list-group-item">city</li>
                        <li class="list-group-item">state</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/cancel-event/{userId}/{eventId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Cancela determinado evento</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse8" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/cancel-event/{userId}/{eventId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/invite-for-event</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Convida um amigo para participar de um evento</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse9" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/invite-for-event</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">event_id</li>
                        <li class="list-group-item">friends (Opcional)</li>
                        <hr>
                        <p class="text-center">
                            O campo <strong>friends</strong> é opcional, caso ele não seja preenchido será enviado uma solicitação
                            para todos os amigos, mas também é possivel enviar um determinado grupo de amigos (friends: [friend_id, friend_id, friend_id...]) e
                            também é possivel enviar para apenas um amigo (friends: friend_id)
                        </p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/my-event-invites/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Lista todos os convites de eventos de um usuario</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse10" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/my-event-invites/{userId}</p>
                    <h4>Filtros: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">status</li>
                        <hr>
                        <p class="text-center"><strong>Como usar: </strong> {{env('APP_URL')}}/api/my-event-invites/{userId}?status=1</p>
                        <p class="text-center"><strong>Padrão: </strong> filterName=value (1 = pending, 2 = accepted, 3 = rejected)</p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/event-action</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Aceita ou rejeita participar de um evento caso o mesmo ainda esteja disponivel</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse11" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/event-action</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">user_id</li>
                        <li class="list-group-item">invite_id</li>
                        <li class="list-group-item">action (2 = accepted, 3 = rejected)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse12" aria-expanded="true" aria-controls="collapse12">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/event-member-list/{eventId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Retorna a lista de membros de determinado evento</span>
                    </button>
                    <span class="float-right mt-2"> <strong>JWT</strong> <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse12" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/event-member-list/{eventId}</p>
                    <h4>Filtros: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">status</li>
                        <hr>
                        <p class="text-center"><strong>Como usar: </strong> {{env('APP_URL')}}/api/event-member-list/{eventId}?status=1</p>
                        <p class="text-center"><strong>Padrão: </strong> filterName=value (1 = open, 2 = closed, 3 = canceled)</p>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <hr>
    <h3>Amigos</h3>
    <div class="mt-4" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse13" aria-expanded="true" aria-controls="collapse13">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/new-friend-request/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Envia um pedido de amizade</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse13" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/new-friend-request/{userId}</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">email</li>
                    </ul>
                    <hr>
                    <p class="text-center">Caso o email pertença a algum usuario ele receberá o convite, caso seja um novo usuario ele receberá um email com instuções para se cadastrar</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse14" aria-expanded="true" aria-controls="collapse14">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/get-friend-request/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Lista os pedidos de amizade pendentes</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse14" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/get-friend-request/{userId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse15" aria-expanded="true" aria-controls="collapse15">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/reject-friend-request/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Rejeita um pedido de amizade</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse15" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/reject-friend-request/{userId}</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">friend_request_id</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/accept-friend-request/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Aceita um pedido de amizade</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse16" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/accept-friend-request/{userId}</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">friend_request_id</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse17" aria-expanded="true" aria-controls="collapse17">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/get-friend-list/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Retorna a lista de amigos de um usuario</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse17" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/get-friend-list/{userId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <div class="mt-1" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-warning" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse18" aria-expanded="true" aria-controls="collapse18">
                        <span class="badge badge-pill badge-warning bdg">POST</span>
                        <span class="ml-4 ac-title">/remove-friend/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Remove um determinado amigo</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse18" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/remove-friend/{userId}</p>
                    <h4>Campos: </h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">friend_id</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
    <hr>
    <h3>Perfil</h3>
    <div class="mt-4" id="accordion">
        <div class="card">
            <div class="card-header ac-bg-success" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link buttom-hover" data-toggle="collapse" data-target="#collapse19" aria-expanded="true" aria-controls="collapse19">
                        <span class="badge badge-pill badge-success bdg">GET</span>
                        <span class="ml-4 ac-title">/my-profile/{userId}</span>
                        <span class="ml-5 ac-description"><i class="fas fa-arrow-right"></i> Retorna os dados de perfil do usuario</span>
                    </button>
                    <span class="float-right mt-2"> JWT <i class="fas fa-key"></i></span>
                </h5>
            </div>
            <div id="collapse19" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <p CLASS="text-center"> <i class="fas fa-link"></i> {{env('APP_URL')}}/api/my-profile/{userId}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END -->
</div>

<hr>
<p class="font-weight-bolder text-center">Todos os direitos reservados &copy Igor Coutinho</p>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/35505cabf9.js" crossorigin="anonymous"></script>
</body>
</html>
