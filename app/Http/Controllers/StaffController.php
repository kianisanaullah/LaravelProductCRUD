<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        return view('staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required','unique:staff',
            'password' => 'required',
            'role' => 'required'
        ]);
        $data=$request->except('_token');
        Staff::create($data);
        return redirect()->route('staff.index')->with('success', 'Staff Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required','unique:staff',
            'password' => 'required',
            'role' => 'required'
        ]);
        $data=$request->except('_token');
        $staff->update($data);
        return redirect()->route('staff.index')->with('success', 'Staff Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff Deleted Successfully');
    }
}
