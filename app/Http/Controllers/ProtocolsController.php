<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProtocolsRequest;
use App\Http\Resources\ProtocolsResource;
use App\Models\Attendance;
use App\Models\Departaments;
use App\Models\Person;
use App\Models\Protocols;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class ProtocolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = Auth::user();
        $people = Person::get(['id', 'name']);
        $departament = Departaments::get(['id', 'name']);
        $protocols = ProtocolsResource::collection(Protocols::with('person', 'departaments', 'attendances')->get());
        return Inertia::render('Protocols/Index', compact('protocols', 'people', 'departament', 'authUser'));
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
    public function store(ProtocolsRequest $request)
    {
        $validatedData = $request->validated();
    
        $protocol = Protocols::create([
            'description' => $validatedData['description'],
            'created_data' => $validatedData['created_data'],
            'deadline' => $validatedData['deadline'],
            'person_id' => $validatedData['person_id'],
            'departament_id' => $validatedData['departament_id'],
            'files' => '',
        ]);


        Attendance::create([
            'protocol_id' => $protocol->id,
            'situation' => 'A'
        ]);
    
        if($protocol) {
            if ($request->hasFile('files')) {
                $fileNames = [];
                foreach ($request->file('files') as $file) {
                    $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/protocols', $fileName);
                    $fileNames[] = $fileName;
                }
                $protocol->update(['files' => implode(',', $fileNames)]);
            }
        }
        return Redirect::route('protocols.index');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Protocols $protocol)
    {
        $attendance = Attendance::all();
        $people = Person::all();
        $departament = Departaments::all();
        return Inertia::render('Protocols/Edit', compact('protocol', 'people', 'departament', 'attendance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProtocolsRequest $request, Protocols $protocol)
    {
        $validatedData = $request->validated();

        $protocol->update([
            'description' => $validatedData['description'],
            'created_data' => $validatedData['created_data'],
            'deadline' => $validatedData['deadline'],
            'person_id' => $validatedData['person_id'],
            'departament_id' => $validatedData['departament_id']
        ]);
    
        if ($request->hasFile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('protocols', $fileName);
                $fileNames[] = $fileName;
            }
            $protocol->update(['files' => implode(',', $fileNames)]);
        }
    
        return Redirect::route('protocols.index'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Protocols $protocol)
    {

        if (!empty($protocol->files)) {
            $files = explode(',', $protocol->files);
            foreach ($files as $file) {
                $filePath = 'protocols/' . trim($file);
                
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
        }

        $protocol->delete();
        return response()->json(['message' => 'Protocolo excluído com sucesso'], 200);
    }
}
