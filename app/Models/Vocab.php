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

    public function getVocab($id)
    {
        return $this->find($id);
    }
}