<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Vocab;

use App\Helpers\Responses;

class VocabController extends Controller
{
    protected $vocab;

    public function __construct(Vocab $vocab)
    {
        $this->vocab = $vocab;
    }

    public function getVocabs(Request $request)
    {
        $vocabs = $this->vocab->getVocabs($request->input('size'));

        if(!$vocabs){
            return Responses::notFound('This vocab is not found.');
        }

        return response()->json($vocabs, 200);
    }

    public function getVocab($id)
    {
        $vocab = $this->vocab->getVocab($id);

        if(!$vocab){
            return Responses::notFound('This vocab is not found.');
        }

        return response()->json($vocab, 200);
    }

    public function createVocab(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'word'     => 'required',
            'meaning'  => 'required',
        ]);

        if ($validator->errors()->count()) {
            return Responses::badRequest($validator->errors());
        }

        $vocab = $this->vocab->createVocab($request);

        return Responses::created($vocab);
    }

    public function updateVocab(Request $request)
    {
        $vocab = $this->vocab->getVocab($request->input('id'));
        if(!$vocab){
            return Responses::notFound('This vocab is not found.');
        }

        $validator = Validator::make($request->all(), [
            'id'     => 'required',
            'word'     => 'required',
            'meaning'  => 'required',
        ]);

        if ($validator->errors()->count()) {
            return Responses::badRequest($validator->errors());
        }

        $vocab = $this->vocab->updateVocab($request);

        return Responses::json($vocab);
    }
}