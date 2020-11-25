<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Auth'], function (){
    Route::post('/register', 'RegisterController@create'); //CADASTRA UM NOVO USUARIO
    Route::post('/login', 'LoginController@login'); //EFETUA LOGIN
});

Route::get('/events', 'EventController@index'); //RETORNA TODOS OS EVENTOS
Route::get('/event/{id}', 'EventController@show')->name('event.show'); //RETORNA UM EVENTO ESPECIFICO

Route::group(['middleware' => ['jwt.auth']], function (){
    Route::get('/my-profile/{id}', 'UserController@profile');

    Route::post('/new-friend-request/{id}', 'FriendRequestController@newFriendRequest'); //ENVIA UM PEDIDO DE AMIZADE
    Route::get('/get-friend-request/{id}', 'FriendRequestController@show'); //LISTA AS SOLICITAÇÕES PENDENTES
    Route::post('/reject-friend-request/{id}', 'FriendRequestController@reject'); //REJEITA UMA SOLICITAÇÃO PENDENTE
    Route::post('/accept-friend-request/{id}', 'FriendRequestController@accept'); //ACEITA UMA SOLICITAÇÃO PENDENTE

    Route::get('/get-friend-list/{id}', 'FriendListController@show'); //LISTA OS AMIGOS
    Route::post('/remove-friend/{id}', 'FriendListController@removeFriend'); //REMOVE DETERMINADO AMIGO

    Route::post('/create-event', 'EventController@create'); //CRIA UM NOVO EVENTO
    Route::get('/my-events/{id}', 'EventController@myEvents'); //LISTA OS EVENTOS DE UM USUARIO
    Route::put('/update-event/{userId}/{eventId}', 'EventController@update'); //ATUALIZA OS DADOS DE UM EVENTO
    Route::post('/cancel-event/{userId}/{eventId}', 'EventController@cancel'); //CANCELA OS DADOS DE UM EVENTO

    Route::post('/invite-for-event', 'EventInviteController@invite'); //ENVIA O CONVITE PARA PARTICIPAR DO EVENTO
    Route::get('/my-event-invites/{id}', 'EventInviteController@myInvites'); //LISTA OS MEUS EVENTOS
    Route::post('/event-action', 'EventInviteController@action'); //ACEITA OU REJEITA UM EVENTO (action=1/Accept | action=2/Reject)
    Route::get('/event-member-list/{id}', 'EventController@getEventMemberList')->name('event.memberList'); //LISTA OS MEMBROS DE UM DETERMINADO EVENTO
});


