<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'berita_judul' => 'required|string',
            'berita_content' => 'required|string',
            'berita_judul_en' => 'required|string',
            'berita_content_en' => 'required|string',
            'berita_foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $berita = new News();
        $berita->ms_berita_judul = $request->input('berita_judul');
        $berita->ms_berita_content = $request->input('berita_content');
        $berita->ms_berita_judul_en = $request->input('berita_judul_en');
        $berita->ms_berita_content_en = $request->input('berita_content_en');

        if ($request->hasFile('berita_foto')) {
            $file = $request->file('berita_foto');
            $destinationPath = 'dokumen/berita/';
            $fileName = $berita->ms_berita_judul . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $berita->ms_berita_image = $destinationPath . $fileName;
        }

        $berita->active = 1;
        $berita->create_id = Auth::user()->id;
        $berita->create_date = now();
        $berita->update_id = Auth::user()->id;
        $berita->update_date = now();

        $berita->save();

        return response()->json(['message' => 'Berita added successfully'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $role_id = $request->session()->get('HINO_ROLE');

        if ($role_id === "admin" || $role_id === "hmsi") {
            $getMsBerita = News::where('ACTIVE', 1)
                ->with(['createUser', 'updateUser'])
                ->select(
                    'ms_berita_id as MS_BERITA_ID',
                    'ms_berita_judul as MS_BERITA_JUDUL',
                    'ms_berita_content as MS_BERITA_CONTENT',
                    'ms_berita_image as MS_BERITA_IMAGE',
                    'ACTIVE',
                    'created_by as CREATE_ID',
                    'created_at as CREATE_DATE',
                    'updated_by as UPDATE_ID',
                    'updated_at as UPDATE_DATE'
                )
                ->get();

            return response()->json($getMsBerita, 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ubah_berita_id' => 'required|integer',
            'ubah_berita_judul' => 'required|string',
            'ubah_berita_content' => 'required|string',
            'ubah_berita_judul_en' => 'required|string',
            'ubah_berita_content_en' => 'required|string',
            'ubah_berita_foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $berita_id = $request->input('ubah_berita_id');
        $berita = News::find($berita_id);

        if (!$berita) {
            return response()->json(['message' => 'Berita not found'], 404);
        }

        $berita->ms_berita_judul = $request->input('ubah_berita_judul');
        $berita->ms_berita_content = $request->input('ubah_berita_content');
        $berita->ms_berita_judul_en = $request->input('ubah_berita_judul_en');
        $berita->ms_berita_content_en = $request->input('ubah_berita_content_en');

        if ($request->hasFile('ubah_berita_foto')) {
            $file = $request->file('ubah_berita_foto');
            $destinationPath = 'dokumen/berita/';
            $fileName = $berita->ms_berita_judul . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            Storage::delete($berita->ms_berita_image); // Delete the old image file
            $berita->ms_berita_image = $destinationPath . $fileName;
        }

        $berita->update_id = Auth::user()->id;
        $berita->update_date = now();

        $berita->save();

        return response()->json(['message' => 'Berita updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'hapus_berita_id' => 'required|integer',
        ]);

        $hapus_berita_id = $request->input('hapus_berita_id');
        $berita = News::find($hapus_berita_id);

        if (!$berita) {
            return response()->json(['message' => 'Berita not found'], 404);
        }

        // Delete the associated image file if it exists
        if ($berita->ms_berita_image && Storage::exists($berita->ms_berita_image)) {
            Storage::delete($berita->ms_berita_image);
        }

        $berita->active = 0;
        $berita->update_id = Auth::user()->id;
        $berita->update_date = now();

        $berita->save();

        return response()->json(['message' => 'Berita deleted successfully'], 200);
    }

    public function getBeritaByID(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $request->input('id');
        $berita = News::find($id);

        if (!$berita) {
            return response()->json(['message' => 'Berita not found'], 404);
        }

        return response()->json($berita, 200);
    }
}
