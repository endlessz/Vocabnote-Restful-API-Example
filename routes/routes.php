<?php

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1'], function($app)
{  
	$app->post('register','AuthController@createUser');

	$app->post('login', 'AuthController@postLogin');

	$app->get('usernameAvailable/{username}', 'AuthController@getUsernameAvailable');

	$app->group(['middleware' => ['auth:api', 'throttle:50,1']], function($app)
	{
		$app->get('user', 'AuthController@getAuthenticatedUser');

		$app->get('vocabs/{id}','VocabController@getVocab');

		$app->get('vocabs','VocabController@getVocabs');

	    $app->get('vocabs/{id}','VocabController@getVocab');
	      
	    $app->post('vocabs','VocabController@createVocab');
	      
	    $app->put('vocabs','VocabController@updateVocab');
	      
	    $app->delete('vocabs/{id}','VocabController@deleteVocab');
	});
});