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
    public function test(Request $request)
    {
        return Inertia::render('Test', [
            'form' => new FormResource(Form::find(7)),
        ]);
    }

    public function submit(Request $request, Form $form)
    {
        $returnValue = [];

        $form->actions()->orderBy('order')->get()->each(function ($action) use ($request) {
            $returnValue[] = $action->run($request);
        });

        return back()->with('messages', $returnValue);
    }






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



    public function update(Request $request, Form $form)
    {
        $form->update([
            'name' => $request->title,
            'status' => $request->status,
        ]);



        foreach ($request->pages as $index => $page)
        {
            $formPage = $form->pages()->updateOrCreate([
                'id' => $page['id'],
            ], [
                'title' => $page['title'],
                'order' => $index,
            ]);



            foreach ($page['inputs'] as $input)
            {
                $formPage->inputs()->updateOrCreate([
                    'id' => $input['id'],
                ], [
                    'type' => $input['type'],
                    'key' => $input['key'],
                    'options' => $input['options'],
                    'validation' => $input['validation'],
                ]);
            }

            // Remove deleted inputs (aka. inputs that are not in the request anymore)
            $formPage->inputs()->whereNotIn('id', collect($page['inputs'])->pluck('id')->toArray())->delete();
        }

        // Remove deleted pages (aka. pages that are not in the request anymore)
        $form->pages()->whereNotIn('id', collect($request->pages)->pluck('id')->toArray())->delete();



        foreach ($request->actions as $index => $action)
        {
            $form->actions()->updateOrCreate([
                'id' => $action['id'],
            ], [
                'type' => $action['type'],
                'options' => $action['options'],
                'order' => $index,
            ]);
        }

        // Remove deleted actions (aka. actions that are not in the request anymore)
        $form->actions()->whereNotIn('id', collect($request->actions)->pluck('id')->toArray())->delete();

        return back();
    }



    public function delete(DestroyFormRequest $request)
    {
        Form::whereIn('id', $request->ids)->delete();

        return back();
    }
}
