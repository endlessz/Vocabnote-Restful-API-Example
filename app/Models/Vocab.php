<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocab extends Model
{
	protected $table = 'vocabs';
    
    protected $fillable = [
        'word', 
        'meaning', 
        'example',
        'updated_at', 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    } 

    public function updateVocab($request)
    {
        $vocab = $this->find($request->input('id'));
        $vocab->word = $request->input('word');
        $vocab->meaning = $request->input('meaning');
        $vocab->example = $request->input('example');

        if($vocab->save()) {
            return $vocab;
        }

        return false;
    }
}