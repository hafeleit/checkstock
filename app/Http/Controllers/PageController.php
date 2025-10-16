<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMaster;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:usermanagement view', ['only' => ['user_management']]);
    }

    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function user_management()
    {
        $user_master = UserMaster::all();
        return view("pages.user-management", compact('user_master'));
    }
}
