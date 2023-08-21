<?php

namespace App\Http\Controllers\Apps\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\SubmitFormRequest;
use App\Http\Resources\Apps\Forms\FrontendFormResource;
use App\Models\Form;

class FormController extends Controller
{
    public function fetch(Form $form)
    {
        abort_if($form->status !== 'published', 404);

        return response()->json([
            'data' => FrontendFormResource::make($form),
        ]);
    }



    public function submit(SubmitFormRequest $request, Form $form)
    {
        // Submit the form
        $messages = $form->submit($request);

        // Redirect back with messages
        return back()->with('message', $messages);
    }
}
