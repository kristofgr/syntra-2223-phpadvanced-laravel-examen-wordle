<?php

namespace App\Http\Controllers;

use App\Models\Validword;
use App\Models\Word;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * Check Word
     *
     * Check that the guess matches the word of the day. If everything is okay, you'll get a 200 OK response.
     *
     * If you make a mistake, you'll get a 422 status code.
     *
     * If your guess doesn't match the word of the day, you'll get a 200 status code wih a summary of all supplied letters. For each letter you will receive a code 0, 1 of 2 where 0 means that the letter is not in the word of the day and 1 means that the letter is in the word of the day but in the wrong spot and 2 means that the letter is in the word of the day and in the right spot.
     *
     * @bodyParam word string required The guess you want to be validated to the word of the day.
     * @response 412 {
     *  "status": "error",
     *  "code": 1,
     *  "message": 'Word is required'
     * }
     * @response 412 {
     *  "status": "error",
     *  "code": 2,
     *  "message": Supplied word is not valid'
     * }
     * @response 200 {
     * "status": "almostthere",
     * "code": 3,
     * "message": "Guess again...",
     * "data": [
     *     {
     *         "letter": "s",
     *         "code": 2
     *     },
     *     {
     *         "letter": "p",
     *         "code": 2
     *     },
     *     {
     *         "letter": "o",
     *         "code": 2
     *     },
     *     {
     *         "letter": "o",
     *         "code": 0
     *     },
     *     {
     *         "letter": "n",
     *         "code": 0
     *     }
     * ]
     * }
     * @response 200 {
     * "status": "success",
     * "code": 4,
     * "message":  "Guess is succesful."
     * }
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
            'data' => $data
        ], 200);
    }
}
