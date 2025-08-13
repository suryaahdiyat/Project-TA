<?php

namespace App\Http\Controllers;

use App\Models\ThemeView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ThemeViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return view('themeView.index', [
        //     'themeViews' => ThemeView::orderBy('name', 'asc')->paginate(10)
        // ]);

        $search = $request->get('search');

        return view('ThemeView.index', [
            'themeViews' => ThemeView::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
                ->orderBy('name', 'asc')
                ->paginate(10)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ThemeView.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => 'required|string|max:255',
        ]);

        if ($request->file('source_photo')) {
            $request->validate([
                "source_photo" => 'image|file|max:2048',
            ]);
            $validatedData['source_photo'] = $request->file('source_photo')->store('source_photo', 'public');
        }
        // dd($validatedData);

        ThemeView::create($validatedData);
        return redirect('/theme-view')->with('success', 'Berhasil menambah data tema');
    }

    /**
     * Display the specified resource.
     */
    public function show(ThemeView $themeView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThemeView $themeView)
    {
        return view('ThemeView.edit', [
            'themeView' => $themeView
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThemeView $themeView)
    {
        $validatedData = $request->validate([
            "name" => 'required|string|max:255',
        ]);

        if ($request->file('source_photo')) {
            // dd($request->file('source_photo'));
            $request->validate([
                'source_photo' => 'image|file|max:2048'
            ]);
            if ($request->old_source_photo && Storage::exists($request->old_source_photo)) {
                Storage::delete($request->old_source_photo);
            }
            $validatedData['source_photo'] = $request->file('source_photo')->store('source_photo', 'public');
        } else $validatedData['source_photo'] = $request->old_source_photo;

        // dd($validatedData);
        $themeView->update($validatedData);
        return redirect('/theme-view')->with('success', 'Berhasil merubah data tema');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThemeView $themeView)
    {
        if ($themeView->source_photo && Storage::exists($themeView->source_photo)) {
            Storage::delete($themeView->source_photo);
        }
        $themeView->delete();
        return redirect('/theme-view')->with('success', 'Berhasil menghapus data tema');
    }
}
