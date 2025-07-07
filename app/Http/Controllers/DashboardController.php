<?php

namespace App\Http\Controllers;

use App\Models\entrada;
use App\Models\salida;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        return Inertia::render('Dashboard');
    }
}
