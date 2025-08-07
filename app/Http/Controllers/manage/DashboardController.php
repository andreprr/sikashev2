<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CourseMember;
use App\Models\Course;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(!Auth::user()->role == 'admin'){
            
            $coursemember=[];
            $history = [];

            return view("content.dashboard.dashboard-member",compact('coursemember','history'));
        }

        $user = User::select(DB::raw("COUNT(CASE WHEN status = 'active' AND email_verified_at IS NOT NULL THEN id END) as user_total"),DB::raw("COUNT(CASE WHEN email_verified_at IS NULL THEN id END) as user_not_verified"))
        ->whereNull('deleted_at')->first();

        $course=[];
        $coursemember=[];

        return view("content.dashboard.dashboard-index",compact('user','course','coursemember'));
    }
}
