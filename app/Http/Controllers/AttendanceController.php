<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    public function store(AttendanceRequest $request) {
        $validatedData = $request->validated();

    $attendance = Attendance::create([
        'protocol_id' => $validatedData['protocol_id'], 
        'description' => $validatedData['description'],
        'situation' => $validatedData['situation']
    ]);

    return Redirect::back();
}
}