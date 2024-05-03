<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentRequest;
use App\Http\Requests\GrantAccessRequest;
use App\Http\Resources\DepartamentsResource;
use App\Models\Departaments;
use App\Models\GrantAccess;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DepartamentsController extends Controller
{
    public function index() {
        $authUser = Auth::user();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard')->with('errorMessage','Você não tem permissão para acesso!');
        }

        $departament = DepartamentsResource::collection(Departaments::all());
        return Inertia::render('Departaments/Index', compact('departament', 'authUser'));
    }


    public function store(DepartamentRequest $request, Departaments $departament) {
        $authUser = Auth::user();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard')->with('errorMessage','Você não tem permissão para acesso!');
        }


        $validatedData = $request->validated();

        $departament->create([
            'name' => $validatedData['name']
        ]);
        return Redirect::route('departaments.index');

    }

    public function edit(Departaments $departament) {
        $authUser = Auth::user();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard')->with('errorMessage','Você não tem permissão para acesso!');
        }


        $users = User::all(); 
        $grantAccess = GrantAccess::with('user')->where('departament_id', $departament->id)->get();
        return Inertia::render('Departaments/Edit', compact('departament','users', 'grantAccess', 'authUser'));
    }

    public function grantPermission(Departaments $departament, GrantAccessRequest $request) {
        $userId = $request->input('user_id');

        $access = GrantAccess::where('user_id', $userId)
                                ->where('departament_id', $departament->id)
                                ->exists();

        if($access) {
            return response()->json(['message' => 'Usuário já possui acesso']);
        }


        GrantAccess::create([
            'user_id' => $userId,
            'departament_id' => $departament->id,
        ]);

    }

    public function deletePermission(Departaments $departament, GrantAccess $access) {
        if ($access->departament_id !== $departament->id) {
            return response()->json(['message' => 'Acesso inválido para o departamento.']);
        }
    
        
        $access->delete();
    
        return response()->json(['message' => 'Acesso excluído com sucesso.']);
    }

    public function update(DepartamentRequest $request, Departaments $departament) {
        $authUser = Auth::user();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard')->with('errorMessage','Você não tem permissão para acesso!');
        }
        $validatedData = $request->validated();

        $departament->update([
            'name' => $validatedData['name']
        ]);

        return Redirect::route('departaments.index');
    }
}
