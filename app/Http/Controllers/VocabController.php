<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Vocab;

class VocabController extends Controller
{
    protected $vocab;

    public function __construct(Vocab $vocab)
    {
        $this->vocab = $vocab;
    }

    public function getVocab($id)
    {
        $vocab = $this->vocab->getVocab($id);

        if(!$vocab){
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($vocab, 200);
    }
}