<?php

namespace App\Http\Controllers;

use App\Models\FabricationStep;
use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FabricationStepController extends Controller
{
    public function create(Sample $sample)
    {
        return view('fabrication-steps.create', compact('sample'));
    }

    public function store(Request $request, Sample $sample)
    {
        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $sample->fabricationSteps()->create([
            'user_id' => Auth::id(),
            'activity_name' => $validated['activity_name'],
            'description' => $validated['description'] ?? null,
            'performed_at' => now(),
        ]);

        return redirect()->route('samples.show', $sample)->with('success', 'Fabrication step added successfully.');
    }

    public function destroy(FabricationStep $fabricationStep)
    {
        $sampleId = $fabricationStep->sample_id;
        $fabricationStep->delete();
        return redirect()->route('samples.show', $sampleId)->with('success', 'Fabrication step deleted successfully.');
    }
}
