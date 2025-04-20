<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberBenefitsController extends Controller
{
    public function showBenefits()
    {
        return view('benefits');  // This loads the benefits.blade.php file
    }
    public function types()
{
    return view('memberships.types');
}

}
