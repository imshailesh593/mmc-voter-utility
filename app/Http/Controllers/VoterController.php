<?php

namespace App\Http\Controllers;

class VoterController extends Controller
{
    public function index()
    {
        return view('voter.index');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function adminVoters()
    {
        return view('admin.voters');
    }

    public function adminBranches()
    {
        return view('admin.branches');
    }

    public function adminImport()
    {
        return view('admin.import');
    }

    public function adminUsers()
    {
        return view('admin.users');
    }

    public function adminMarking()
    {
        return view('admin.marking');
    }
}
