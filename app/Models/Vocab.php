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

    public function getVocabs()
    {
    	return $this->paginate(10);
    }

    public function getVocab($id)
    {
        return $this->find($id);
    }

    public function createVocab($input)
    {
        return $this->create($input->all());
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