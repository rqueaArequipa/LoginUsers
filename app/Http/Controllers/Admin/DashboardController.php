<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    //Constructor
    public function __Construct()
    {
        $this->middleware('Auth');
        $this->middleware('isadmin');

    }

    public function Dashboard(){
        return 'Admin';
    }
}
