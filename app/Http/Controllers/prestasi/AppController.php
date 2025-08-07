<?php

namespace App\Http\Controllers\prestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormInput;
use App\Models\User;
use Shetabit\Visitor\Models\Visit;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;


class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['totalVisits'] = Visit::count();
        $data['totalUnique'] = Visit::distinct('ip')->count('ip');
        $data['totalUser'] = User::count();
        $data['totalSubmit'] = FormInput::count();
        $data = (object) $data;
        return view("content.prestasi.landing",compact('data'));
    }
}
