<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonResource;
use App\Http\Resources\ProtocolsResource;
use App\Models\Person;
use App\Models\Protocols;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Psy\Readline\Hoa\Protocol;

class ProtocolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $protocols = ProtocolsResource::collection(Protocols::with('people')->get());
        return Inertia::render('Protocols/Index', compact('protocols'));
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
    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required', 'min:3'],
            'person_id' => ['required'],
            'created_data' => ['required', 'min:3'],
            'deadline' => ['required']
        ]);

        Protocols::create([
            'description' => $request->description,
            'person_id' => $request->person_id,
            'created_data' => $request->created_data,
            'deadline' => $request->deadline
        ]);

        return Redirect::route('protocols.index');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
