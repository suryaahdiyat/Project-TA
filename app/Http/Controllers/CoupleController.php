<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoupleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $couples = Couple::when($search, function ($query) use ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('groom_name', 'like', "%{$search}%")
                    ->orWhere('groom_father_name', 'like', "%{$search}%")
                    ->orWhere('groom_mother_name', 'like', "%{$search}%")
                    ->orWhere('bride_name', 'like', "%{$search}%")
                    ->orWhere('bride_father_name', 'like', "%{$search}%")
                    ->orWhere('bride_mother_name', 'like', "%{$search}%");
            });
        })->orderBy('groom_name', 'asc')->paginate(10)->withQueryString();

        return view('Couple.index', compact('couples', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('couple.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Groom
            "groom_name" => 'required|string|max:255',
            "groom_photo" => 'required|image|file|max:2048',
            "groom_father_name" => 'required|string|max:255',
            "groom_mother_name" => 'required|string|max:255',
            "groom_marital_status" => 'required|string|max:255',
            "groom_birth_date" => 'required|date',
            "groom_birth_place" => 'required|string|max:255',
            "groom_nationality" => 'required|string|max:255',
            "groom_religion" => 'required|string|max:255',
            "groom_occupation" => 'required|string|max:255',
            "groom_address" => 'required|string|max:255',
            "groom_email" => 'required|email:dns|max:255|unique:couples,groom_email',

            // Bride
            "bride_name" => 'required|string|max:255',
            "bride_photo" => 'required|image|file|max:2048',
            "bride_father_name" => 'required|string|max:255',
            "bride_mother_name" => 'required|string|max:255',
            "bride_marital_status" => 'required|string|max:255',
            "bride_birth_date" => 'required|date',
            "bride_birth_place" => 'required|string|max:255',
            "bride_nationality" => 'required|string|max:255',
            "bride_religion" => 'required|string|max:255',
            "bride_occupation" => 'required|string|max:255',
            "bride_address" => 'required|string|max:255',
            "bride_email" => 'required|email:dns|max:255|unique:couples,bride_email',
        ]);

        $validatedData['marriage_status'] = "terdaftar";

        if ($request->file('groom_photo')) {
            $validatedData['groom_photo'] = $request->file('groom_photo')->store('groom_photo', 'public');
        }

        if ($request->file('bride_photo')) {
            $validatedData['bride_photo'] = $request->file('bride_photo')->store('bride_photo', 'public');
        }


        Couple::create($validatedData);
        return redirect('/couple')->with('success', 'Berhasil menambah data calon pengantin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Couple $couple)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Couple $couple)
    {
        return view('couple.edit', [
            'couple' => $couple
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Couple $couple)
    {
        $validatedData = $request->validate([
            //groom
            "groom_name" => 'required|string|max:255',
            "groom_father_name" => 'required|string|max:255',
            "groom_mother_name" => 'required|string|max:255',
            "groom_marital_status" => 'required|string|max:255',
            "groom_birth_date" => 'required|string|max:255',
            "groom_birth_place" => 'required|string|max:255',
            "groom_nationality" => 'required|string|max:255',
            "groom_religion" => 'required|string|max:255',
            "groom_occupation" => 'required|string|max:255',
            "groom_address" => 'required|string|max:255',
            "groom_email" => 'required|email:dns|max:255|unique:couples,groom_email,' . $couple->id,

            //bride
            "bride_name" => 'required|string|max:255',
            "bride_father_name" => 'required|string|max:255',
            "bride_mother_name" => 'required|string|max:255',
            "bride_marital_status" => 'required|string|max:255',
            "bride_birth_date" => 'required|string|max:255',
            "bride_birth_place" => 'required|string|max:255',
            "bride_nationality" => 'required|string|max:255',
            "bride_religion" => 'required|string|max:255',
            "bride_occupation" => 'required|string|max:255',
            "bride_address" => 'required|string|max:255',
            "bride_email" => 'required|email:dns|max:255|unique:couples,bride_email,' . $couple->id,
        ]);


        $validatedData['groom_photo'] = null;
        $validatedData['bride_photo'] = null;

        if ($request->file('groom_photo')) {
            $request->validate([
                'groom_photo' => 'required|image|file|max:2048'
            ]);
            if ($request->old_groom_photo && Storage::exists($request->old_groom_photo)) {
                Storage::delete($request->old_groom_photo);
            }
            $validatedData['groom_photo'] = $request->file('groom_photo')->store('groom_photo', 'public');
        } else $validatedData['groom_photo'] = $request->old_groom_photo;

        if ($request->file('bride_photo')) {
            $request->validate([
                'bride_photo' => 'required|image|file|max:2048'
            ]);
            if ($request->old_bride_photo && Storage::exists($request->old_bride_photo)) {
                Storage::delete($request->old_bride_photo);
            }
            $validatedData['bride_photo'] = $request->file('bride_photo')->store('bride_photo', 'public');
        } else $validatedData['bride_photo'] = $request->old_bride_photo;

        $couple->update($validatedData);
        return redirect('/couple')->with('success', 'Berhasil mengubah data calon pengantin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Couple $couple)
    {
        /* `dd();` is a debugging function in Laravel that stands for "dump and die". It is used
        to dump the contents of the variable `` and then immediately stop the script
        execution. This helps in debugging by displaying the contents of the variable at that point
        in the code. */
        // dd($couple);
        if ($couple->groom_photo && Storage::exists($couple->groom_photo)) {
            Storage::delete($couple->groom_photo);
        }
        if ($couple->bride_photo && Storage::exists($couple->bride_photo)) {
            Storage::delete($couple->bride_photo);
        }
        $couple->delete();
        return redirect('/couple')->with('success', 'Berhasil menghapus data calon pengantin');
    }
}
