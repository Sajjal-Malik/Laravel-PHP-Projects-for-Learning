<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getText(){

        return view('first-form', ['data' => null]);
    }

    public function removeSpaces(Request $request){

        $validated = $request->validate([
            'sentence' => 'required',
        ]);

        $data = new Text();

        $data->sentence = preg_replace('/\s+/', '', $validated['sentence']);

        $data->save();

        return view('first-form', ['data' => $data]);
        
    }
}
