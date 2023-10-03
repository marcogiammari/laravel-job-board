<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function __construct()
    {
        // controlla la policy per ogni action
        $this->authorizeResource(Employer::class);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        auth()->user()->employer()->create(
            $request->validate([
                // controlla che l'employer sia unique
                'company_name' => 'required|min:3|unique:employers,company_name'
            ])
        );

        return redirect()->route('jobs.index')->with('success', 'Your employer account was created!');
    }
}
