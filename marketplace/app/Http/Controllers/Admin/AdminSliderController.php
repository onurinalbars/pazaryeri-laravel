<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->paginate(20);

        $stats = [
            'total' => Slider::count(),
            'active' => Slider::where('is_active', true)->count(),
        ];

        return view('admin.sliders.index', compact('sliders', 'stats'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['image_path'] = $request->file('image')->store('sliders', 'public');

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image_path);
            $data['image_path'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image_path);
        $slider->delete();

        return back()->with('success', 'Slider deleted.');
    }

    protected function validateData(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:2048'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ];
    }
}