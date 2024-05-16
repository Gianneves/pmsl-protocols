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
        
        $validatedData = $request->validated();

        Person::create([
            'name' => $validatedData['name'],
            'birthdate' => $validatedData['birthdate'],
            'cpf' => $validatedData['cpf'],
            'gender' => $validatedData['gender'],
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
    public function update(UserStoreRequest $request, Person $person)
    {
        
        $validatedData = $request->validated();

     
        $person->update([
            'name' => $validatedData['name'],
            'birthdate' => $validatedData['birthdate'],
            'cpf' => $validatedData['cpf'],
            'gender' => $validatedData['gender'],
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
