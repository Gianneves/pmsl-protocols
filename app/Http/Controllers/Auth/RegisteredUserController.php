<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
   
    public function index()
    {
        $authUser = Auth::user();
        $user = User::all();
        return Inertia::render('User/Index', compact('user', 'authUser'));
    }


    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserCreateRequest $request): RedirectResponse
    {

        $authProfile = Auth::user()->profile;

        if ($authProfile === 'T') {
            $validatedData = $request->validated();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'profile' => $validatedData['profile'],
                'cpf' => $validatedData['cpf'],
                'active' => 'S'
            ]);

            event(new Registered($user));


            return redirect()->route('user.index');
        } elseif ($authProfile === 'S') {
            $validatedData = $request->validated();

            if ($validatedData['profile'] === 'A') {
                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'profile' => $validatedData['profile'],
                    'cpf' => $validatedData['cpf'],
                    'active' => 'S'
                ]);

                event(new Registered($user));

                return redirect()->route('user.index');
            } else {
                abort(403, 'Unauthorized action.');
            }
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
