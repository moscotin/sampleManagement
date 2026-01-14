<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\SampleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SampleImageController extends Controller
{
    public function store(Request $request, Sample $sample)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:10240',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('sample_images', $filename, 'public');

                SampleImage::create([
                    'sample_id' => $sample->id,
                    'filename' => $filename,
                    'original_filename' => $image->getClientOriginalName(),
                    'path' => $path,
                    'size' => $image->getSize(),
                    'mime_type' => $image->getMimeType(),
                ]);
            }
        }

        return redirect()->route('samples.show', $sample)->with('success', 'Images uploaded successfully.');
    }

    public function destroy(SampleImage $sampleImage)
    {
        Storage::disk('public')->delete($sampleImage->path);
        $sampleImage->delete();

        return redirect()->route('samples.show', $sampleImage->sample_id)->with('success', 'Image deleted successfully.');
    }
}
