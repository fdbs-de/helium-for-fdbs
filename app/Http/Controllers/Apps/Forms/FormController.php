<?php

namespace App\Http\Controllers\Apps\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\SubmitFormRequest;
use App\Models\Form;

class FormController extends Controller
{
    public function submit(SubmitFormRequest $request, Form $form)
    {
        // Submit the form
        $messages = $form->submit($request);

        // Redirect back with messages
        return back()->with('message', $messages);
    }
}
