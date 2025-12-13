<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // mulai query
        $query = Photo::query();

        // Logika Pencarian: Jika ada input 'search' dari user
        if ($request->has('search') && $request->search != '') {
            $query = $query->where('title','LIKE','%'. $request->search .'%');
        }

        // Ambil data + Pagination (5 data per halaman) + Urutkan terbaru
        $photos = $query->latest()->paginate(5);
        return view("photos.index", compact("photos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title'=> 'required',
            'image'=> 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar, max 2MB
        ]);

        // 2. Proses Upload Gambar
        // Gambar akan disimpan di folder "storage/app/public/photos"
        $imagePath = $request->file('image')->store('photos', 'public');

        // 3. Simpan ke Database
        \App\Models\Photo::create([
            'title'=> $request->title,
            'description'=> $request->description,
            'image_path'=> $imagePath,
        ]);

        // 4. Balik ke halaman utama
        return redirect()->route('photos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $photo = \App\Models\Photo::findOrFail($id);
        return view('photos.edit', compact('photo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi (image jadi 'nullable' artinya boleh kosong jika tidak ingin ganti foto)
        $request->validate([
            'title' => 'required',
            'image'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil data lama
        $photo = \App\Models\Photo::findOrFail($id);

        // 3. Cek apakah user upload file baru?
        if ($request->hasFile('image')) {

            if (Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
                }

            // Upload gambar baru 
            $imagePath = $request->file('image')->store('photos', 'public');

            // Update path di database object
            $photo->image_path = $imagePath;
        }

        // 4. Update Judul $ Deskripsi
        $photo->title = $request->title;
        $photo->description = $request->description;

        // 5. Simpan perubahan
        $photo->save();

        return redirect()->route('photos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. Cari data foto berdasarkan ID
        $photo = Photo::findOrFail($id);

        // 2. Hapus file fisik gambar
        // cek apakah file ada distorage
        if (Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        // 3. Hapus Data di Database
        $photo->delete();

        // 4. Kembali ke index
        return redirect()->route('photos.index');
    }
}