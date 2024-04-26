<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProtocolsResource;
use App\Models\Attendance;
use App\Models\Departaments;
use App\Models\Person;
use App\Models\Protocols;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Protocol;

class PdfController extends Controller
{
    public function protocolPdf()
    {
        $protocols = ProtocolsResource::collection(Protocols::with('person')->get());

        $pdf = Pdf::loadView('protocolpdf', compact('protocols'));

        return $pdf->download('lista-protocolo.pdf');
        exit();
    }

    public function attendancePdf($id) {
        
        $protocols = Protocols::with('person', 'departaments')->where('id', $id)->get()->first();
        $attendances = Attendance::where([['protocol_id', $protocols->id]])->get();
      
        $pdf = Pdf::loadView('attendance-pdf', compact('protocols', 'attendances'));
        return $pdf->download('lista-atendimento.pdf');
    }
}
