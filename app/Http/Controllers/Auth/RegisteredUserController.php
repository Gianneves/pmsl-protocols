<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

use function Termwind\render;

class RegisteredUserController extends Controller
{
   
    public function index()
    {
        $authUser = Auth::user();
        $user = User::all();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard');
        }

        
        if($authUser->profile === 'S') {
            $user = User::where('profile', 'A')->get();
        }

        return Inertia::render('User/Index', compact('user', 'authUser'));
    }


    public function create(): Response
    {
        $authProfile = Auth::user()->profile;

        if($authProfile === 'A') {
            return Inertia::render('dashboard');
        }

        return Inertia::render('Auth/Register', compact('authProfile'));
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
                    'active' => $request['active']
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

    public function edit(User $user)
    {
        $authProfile = Auth::user()->profile;

        if($authProfile === 'A') {
            return Inertia::render('dashboard');
        }
        return Inertia::render('User/Edit', compact('user', 'authProfile'));
    }


    public function update(UserCreateRequest $request, User $user)
    {
        $authProfile = Auth::user()->profile;

        if($authProfile === 'A') {
            return Inertia::render('dashboard');
        } 

        $validatedData = $request->validated();
        $user->update([
            'name' => $validatedData['name'],
            'profile' => $validatedData['profile'],
            'active' => $request['active']
        ]);

        return redirect()->route('user.index');
    }

}
