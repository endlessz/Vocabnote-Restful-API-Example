<?php

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->group(['prefix' => 'api/v1'], function($app)
{  
	$app->get('vocabs','VocabController@getVocabs');

    $app->get('vocabs/{id}','VocabController@getVocab');
      
    $app->post('vocabs','VocabController@createVocab');
      
    $app->put('vocabs','VocabController@updateVocab');
      
    $app->delete('vocabs/{id}','VocabController@deleteVocab');
});