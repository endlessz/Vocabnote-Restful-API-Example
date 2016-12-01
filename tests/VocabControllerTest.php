<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Vocab;

class VocabControllerTest extends TestCase
{
    public function testGetVocabs()
    {
        $response = $this->call('GET', '/api/v1/vocabs');

        $this->assertEquals(200, $response->status());
    }

    public function testPostVocab()
    {
        $this->json('POST', '/api/v1/vocabs', ['word' => 'Sorry', 'meaning' => 'ขอโทษ'])
             ->seeJson([
                'word' => 'Sorry',
                'meaning' => 'ขอโทษ',
             ]);
    }

    public function testUpdateVocab()
    {
        $vocab = Vocab::orderBy('id', 'desc')->first();
        $vocab->word = 'Sad';
        $vocab->meaning = 'Meaning of Sad';

        $this->json('PUT', '/api/v1/vocabs', $vocab->toArray())
             ->seeJson([
                'word' => 'Sad',
                'meaning' => 'Meaning of Sad',
             ]);
    }

    public function testDeleteVocab()
    {
        $vocab = Vocab::orderBy('id', 'desc')->first();
        $response = $this->call('DELETE', '/api/v1/vocabs/'.$vocab->id);

        $this->assertEquals(204, $response->status());
    }
}
