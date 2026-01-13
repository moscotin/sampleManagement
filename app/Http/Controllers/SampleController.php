<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\Wafer;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function index()
    {
        $samples = Sample::with('wafer')->latest()->get();
        return view('samples.index', compact('samples'));
    }

    public function create()
    {
        $wafers = Wafer::all();
        return view('samples.create', compact('wafers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wafer_id' => 'required|exists:wafers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Sample::create($validated);

        return redirect()->route('samples.index')->with('success', 'Sample created successfully.');
    }

    public function show(Sample $sample)
    {
        $sample->load(['wafer', 'fabricationSteps.user']);
        return view('samples.show', compact('sample'));
    }

    public function edit(Sample $sample)
    {
        $wafers = Wafer::all();
        return view('samples.edit', compact('sample', 'wafers'));
    }

    public function update(Request $request, Sample $sample)
    {
        $validated = $request->validate([
            'wafer_id' => 'required|exists:wafers,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sample->update($validated);

        return redirect()->route('samples.index')->with('success', 'Sample updated successfully.');
    }

    public function destroy(Sample $sample)
    {
        $sample->delete();
        return redirect()->route('samples.index')->with('success', 'Sample deleted successfully.');
    }
}
