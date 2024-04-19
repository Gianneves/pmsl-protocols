<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentRequest;
use App\Http\Resources\DepartamentsResource;
use App\Models\Departaments;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DepartamentsController extends Controller
{
    public function index() {
        $departament = DepartamentsResource::collection(Departaments::all());
        return Inertia::render('Departaments/Index', compact('departament'));
    }


    public function store(DepartamentRequest $request, Departaments $departament) {
        $validatedData = $request->validated();

        $departament->create([
            'name' => $validatedData['name']
        ]);
        return Redirect::route('departamentos.index');

    }

    public function edit(Departaments $departament) {
        $users = User::all();
        return Inertia::render('Departaments/Edit', compact('departament','users'));
    }


    public function update(DepartamentRequest $request, Departaments $departament) {
        $validatedData = $request->validated();

        $departament->update([
            'name' => $validatedData['name']
        ]);

        return Redirect::route('departamentos.index');
    }
}
