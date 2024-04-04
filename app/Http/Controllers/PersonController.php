<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = PersonResource::collection(Person::all());
        return Inertia::render('Person/Index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
      


        Person::create([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'gender' => $request->gender,
            'city' => $request->city,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement
        ]);

        return Redirect::route('person.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'birthdate' => ['required', 'date'],
            'cpf' => ['required', 'unique:people,cpf', 'min:11', 'max:11'],
            'gender' => ['nullable', 'in:Masculino,Feminino,Outro'],
            'city' => ['nullable', 'string'],
            'district' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'number' => ['nullable', 'string'],
            'complement' => ['nullable', 'string'],
        ]);

        $person->update([
            'name' => $request->name,
            'birthdate' => $request->birthdate,
            'cpf' => $request->cpf,
            'gender' => $request->gender,
            'city' => $request->city,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement
        ]);

        return Redirect::route('person.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();
        Redirect::back();
    }
}
