<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuditController extends Controller
{
    public function index() {

        $authUser = Auth::user();
        $user = User::all();

        if($authUser->profile === 'A') {
            return Inertia::render('dashboard')->with('errorMessage','Você não tem permissão para acesso!');
        }

        $audits = Audit::with('user')->get();
        return Inertia::render('Audits/Index', compact('audits'));
    }
}
