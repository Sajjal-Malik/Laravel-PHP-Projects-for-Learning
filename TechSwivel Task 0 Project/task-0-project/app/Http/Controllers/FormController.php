<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use App\Models\Text;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getText()
    {
        return view('first-form', ['data' => null]);
    }

    public function removeSpaces(Request $request)
    {

        $validated = $request->validate([
            'sentence' => 'required',
        ]);

        $data = new Text();
        $data->sentence = preg_replace('/\s+/', '', $validated['sentence']);
        $data->save();

        return view('first-form', ['data' => $data]);
    }

    public function countWords(Request $request)
    {

        $validated = $request->validate([
            'word' => 'required',
            'paragraph' => 'required'
        ]);

        $data = new Paragraph();
        $data->word = $validated['word'];
        $data->paragraph = $validated['paragraph'];
        $data->save();

        $word = strtolower($validated['word']);
        $paragraph = strtolower($validated['paragraph']);
        $count = substr_count($paragraph, $word);

        return view('word-count')->with([
            'count' => $count,
            'word' => $validated['word']
        ]);
    }

    public function getParagraph()
    {

        $count = session('count');
        $word = session('word');

        return view('second-form', compact('count', 'word'));
    }
}
