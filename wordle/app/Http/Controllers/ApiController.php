<?php

namespace App\Http\Controllers;

use App\Models\Validword;
use App\Models\Word;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function check(Request $request)
    {
        // Check if word is present in the call
        $word = strtolower($request->input('word'));

        // Is word present?
        if (!$word) {
            return response()->json([
                'status' => 'error',
                'code' => 1,
                'message' => 'Word is required'
            ], 422);
        }

        // is word a valid english 5-letter word?
        $valid = Validword::where('word', $word)->first();
        if (!$valid) {
            return response()->json([
                'status' => 'error',
                'code' => 2,
                'message' => 'Supplied word is not valid'
            ], 422);
        }

        // Is word the actual correct word of the day?
        $today = date('Y-m-d');
        $wordoftoday = Word::whereDate('scheduled_at', $today)->first();

        if (!$wordoftoday) {
            // There seems to be no word programmed for today. We will randomize a valid one and save it.
            $randomword = Validword::inRandomOrder()->first();

            $word = new Word([
                'word' => $randomword->word,
                'scheduled_at' => $today,
            ]);
            $word->save();

            $wordoftoday = $randomword;
        }

        $wordoftoday = $wordoftoday->word;

        if ($wordoftoday == $word) {
            return response()->json([
                'status' => 'success',
                'code' => 4,
                'message' => 'Guess is succesful.'
            ], 200);
        }



        $wordoftheday_chars = str_split($wordoftoday);

        $word_chars = str_split($word);

        $data = [];


        foreach ($word_chars as $key => $guesschar) {

            if ($guesschar == $wordoftheday_chars[$key]) {
                $data[$key] = [
                    'letter' => $guesschar,
                    'code' => 2, // 0: is not present in word of the day, 1: is present in word of the day but in the wrong spot, 2: is present in word of the day and in the right spot    
                ];
                $wordoftheday_chars[$key] = null;
                $word_chars[$key] = null;
            }
        }

        foreach ($word_chars as $key => $guesschar) {

            if ($guesschar != null) {
                if (in_array($guesschar, $wordoftheday_chars)) {
                    $data[$key] = [
                        'letter' => $guesschar,
                        'code' => 1, // 0: is not present in word of the day, 1: is present in word of the day but in the wrong spot, 2: is present in word of the day and in the right spot    
                    ];
                    $wordoftheday_chars[$key] = null;
                    $word_chars[$key] = null;
                }
            }
        }

        foreach ($word_chars as $key => $guesschar) {

            if ($guesschar != null) {
                if (!in_array($guesschar, $wordoftheday_chars)) {
                    $data[$key] = [
                        'letter' => $guesschar,
                        'code' => 0, // 0: is not present in word of the day, 1: is present in word of the day but in the wrong spot, 2: is present in word of the day and in the right spot    
                    ];
                    $wordoftheday_chars[$key] = null;
                    $word_chars[$key] = null;
                }
            }
        }

        ksort($data);

        return response()->json([
            'status' => 'almostthere',
            'code' => 3,
            'message' => 'Guess again...',
            'wordoftheday' => $wordoftheday_chars,
            'guess' => $word_chars,
            'data' => $data
        ], 200);
    }
}
