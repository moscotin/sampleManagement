<?php

namespace App\Http\Controllers;

use App\Models\Wafer;
use Illuminate\Http\Request;

class WaferController extends Controller
{
    public function index()
    {
        $wafers = Wafer::latest()->get();
        return view('wafers.index', compact('wafers'));
    }

    public function create()
    {
        return view('wafers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Wafer::create($validated);

        return redirect()->route('wafers.index')->with('success', 'Wafer created successfully.');
    }

    public function show(Wafer $wafer)
    {
        $wafer->load('samples');
        return view('wafers.show', compact('wafer'));
    }

    public function edit(Wafer $wafer)
    {
        return view('wafers.edit', compact('wafer'));
    }

    public function update(Request $request, Wafer $wafer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $wafer->update($validated);

        return redirect()->route('wafers.index')->with('success', 'Wafer updated successfully.');
    }

    public function destroy(Wafer $wafer)
    {
        $wafer->delete();
        return redirect()->route('wafers.index')->with('success', 'Wafer deleted successfully.');
    }
}
