<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormController
{
    public function get(Request $request, $name){
        $form = Form::where('name', $name)->with(['answer' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->firstOrFail();
        //$answer = FormAnswer::where('form_id', $form->id)->where('user_id', Auth::id())->first();

        $acl = json_decode($form['acl']);
        if ($acl->protected && !in_array(Auth::id(), $acl->allowed)) {
            abort(404);
        }

        return response()->json($form);
    }

    public function answer(Request $request, $name)
    {
        $form = Form::where('name', $name)->firstOrFail();

        $answer = FormAnswer::firstOrNew([
            'form_id'=> $form->id,
            'user_id'=> Auth::id(),
        ], [
            'created_at' => Carbon::now(),
        ]);

        $questions = json_decode($form->questions, true);
        $input = $request->json()->all();

        $this->filter($questions, $input);
        $this->validate($questions, $input);

        $answer->answers = json_encode($input);
        $answer->updated_at = Carbon::now();

        $answer->save();
    }

    protected function filter(array $questions, array &$input)
    {
        $garbage = array_diff(array_keys($input), array_keys($questions));

        foreach ($garbage as $key) {
            unset($input[$key]);
        };
    }

    protected function validate(array $questions, array $input)
    {
        $rules = [];

        foreach ($questions as $name => &$question) {
            if ($question['type'] === 'description') {
                continue;
            }

            $rule = '';

            if ($question['required']) {
                $rule .= '|required';
            }

            $type = $question['type'];

            if ($type === 'email') {
                $rule .= '|email';
            } elseif ($type === 'select' || $type === 'map') {
                $rule .= '|array';
            }

            $rules[$name] = substr($rule, 1);
        }

        Validator::make($input, $rules)->validate();
    }
};
