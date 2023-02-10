<?php

namespace App\Http\Controllers\Admin\Apps\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\CreateFormRequest;
use App\Http\Requests\Forms\DestroyFormRequest;
use App\Http\Resources\Apps\Forms\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/Apps/Forms/Index', [
            'items' => FormResource::collection(Form::all()),
        ]);
    }



    public function editor(Request $request, Form $form)
    {
        return Inertia::render('Admin/Apps/Forms/Editor', [
            'item' => new FormResource($form),
        ]);
    }



    public function store(CreateFormRequest $request)
    {
        $form = Form::create($request->validated());

        $form->pages()->create([
            'title' => 'Page 1',
        ]);

        return back();
    }



    public function delete(DestroyFormRequest $request)
    {
        Form::whereIn('id', $request->ids)->delete();

        return back();
    }
}
