<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OdontologoController extends Controller
{
    public function index()
    {
        $citas = DB::table('citas')->where('fecha_cita', Carbon::now()->toDateString())->get();
        return view('odontologo.odontologo', compact('citas'));
    }
}
