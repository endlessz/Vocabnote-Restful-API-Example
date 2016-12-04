<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Vocab;
use App\Helpers\Responses;
use Tymon\JWTAuth\JWTAuth;

class VocabController extends Controller
{
    protected $vocab;
    protected $jwt;

    public function __construct(Vocab $vocab, JWTAuth $jwt)
    {
        $this->vocab = $vocab;
        $this->jwt = $jwt;
    }

    public function getVocabs(Request $request)
    {
        $user = $this->jwt->parseToken()->authenticate();
        $vocabs = $user->vocabs();
        $size = $request->input('size');

        return Responses::json($vocabs->paginate(is_numeric($size) ? intval($size) : 10));
    }

    public function getVocab($id)
    {
        $user = $this->jwt->parseToken()->authenticate();

        $vocab = $user->vocabs()->find($id);

        if(!$vocab){
            return Responses::notFound('This vocab is not found.');
        }

        return Responses::json($vocab);
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

        $user = $this->jwt->parseToken()->authenticate();
        $vocab = $user->vocabs()->create([
                            'word' => $request->input('word'), 
                            'meaning' => $request->input('meaning'),
                            'example' => $request->input('example'),
                        ]);

        return Responses::created($vocab);
    }

    public function updateVocab(Request $request)
    {
        $user = $this->jwt->parseToken()->authenticate();

        $vocab = $user->vocabs()->find($request->input('id'));
        
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

    public function deleteVocab($id)
    {
        $user = $this->jwt->parseToken()->authenticate();

        $vocab = $user->vocabs()->find($id);

        if(!$vocab){
            return Responses::notFound('This vocab is not found.');
        }

        $vocab->delete();

        return Responses::noContent();
    }
}