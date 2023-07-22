<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
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
            'kategori_level' => 'required|numeric',
            'kategori_name' => 'required|string',
            'kategori_name_en' => 'required|string',
            'kategori_icon' => 'nullable|image',
            'kategori_parent' => 'nullable|exists:mskategori,ms_kategori_id',
            'kategori_punya_turunan' => 'required|boolean',
            'kategori_req_file' => 'nullable|boolean',
            'kategori_file' => 'nullable|file',
        ]);

        $kategori_level = $request->input('kategori_level');
        $kategori_name = $request->input('kategori_name');
        $kategori_name_en = $request->input('kategori_name_en');
        $kategori_icon = $request->file('kategori_icon');
        $kategori_parent = $request->input('kategori_parent');
        $kategori_punya_turunan = $request->input('kategori_punya_turunan');
        $kategori_req_file = $request->input('kategori_req_file');
        $file_icon = '';
        $file_file = '';

        // Check if the request has an uploaded icon
        if ($kategori_icon) {
            $extension = $kategori_icon->getClientOriginalExtension();
            $destination_p = 'dokumen/kategori/icon/';
            $dokumen_p = $destination_p . '_' . $kategori_name . '_' . rand() . '.' . $extension;
            $kategori_icon->move($destination_p, $dokumen_p);
            $file_icon = $dokumen_p;
        }

        // Check if the category level is 1
        if ($kategori_level == 1) {
            $category = Category::create([
                'ms_kategori_level' => $kategori_level,
                'ms_kategori_name' => $kategori_name,
                'ms_kategori_name_en' => $kategori_name_en,
                'ms_kategori_image' => $file_icon,
                'ms_kategori_flag_turunan' => 1,
                'active' => 1,
                'create_id' => auth()->id(),
                'create_date' => now(),
                'update_id' => auth()->id(),
                'update_date' => now(),
            ]);
        } else {
            // Check if the category has children (kategori_punya_turunan is true)
            if ($kategori_punya_turunan) {
                $category = Category::create([
                    'ms_kategori_level' => $kategori_level,
                    'ms_kategori_name' => $kategori_name,
                    'ms_kategori_name_en' => $kategori_name_en,
                    'ms_kategori_image' => $file_icon,
                    'ms_kategori_parent' => $kategori_parent,
                    'ms_kategori_flag_turunan' => 1,
                    'active' => 1,
                    'create_id' => auth()->id(),
                    'create_date' => now(),
                    'update_id' => auth()->id(),
                    'update_date' => now(),
                ]);
            } else {
                // Check if the request has an uploaded file
                $kategori_file = $request->file('kategori_file');
                if ($kategori_file) {
                    $extension_file = $kategori_file->getClientOriginalExtension();
                    $destination_file = 'dokumen/kategori/file/';
                    $dokumen_file = $destination_file . '_' . $kategori_name . '_' . rand() . '.' . $extension_file;
                    $kategori_file->move($destination_file, $dokumen_file);
                    $file_file = $dokumen_file;
                }

                $category = Category::create([
                    'ms_kategori_level' => $kategori_level,
                    'ms_kategori_name' => $kategori_name,
                    'ms_kategori_name_en' => $kategori_name_en,
                    'ms_kategori_image' => $file_icon,
                    'ms_kategori_parent' => $kategori_parent,
                    'ms_kategori_file' => $file_file,
                    'ms_kategori_flag_turunan' => 0,
                    'ms_kategori_flag_form' => $kategori_req_file,
                    'active' => 1,
                    'create_id' => auth()->id(),
                    'create_date' => now(),
                    'update_id' => auth()->id(),
                    'update_date' => now(),
                ]);
            }
        }

        if ($category) {
            $kode_pesan = 1;
            $pesan = "Berhasil Tambah Kategori";
        } else {
            $kode_pesan = 0;
            $pesan = "Gagal Tambah Kategori";
        }

        return response()->json(['kode_pesan' => $kode_pesan, 'pesan' => $pesan]);     
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
        $role_id = Session::get('HINO_ROLE');

        if ($role_id == "admin" || $role_id == "hmsi") {
            $query = Category::query()
                ->where('active', 1);

            if ($request->has('level')) {
                $query->where('ms_kategori_level', $request->input('level'));
            }

            $query->with(['level1Parent', 'level2Parent', 'level3Parent', 'level4Parent'])
                ->orderBy('ms_kategori_id', 'asc');

            $getMsKategori = $query->get();

            $getMsKategori = $getMsKategori->map(function ($item) {
                $levelNames = [
                    'level1' => $item->ms_kategori_name,
                    'level2' => '',
                    'level3' => '',
                    'level4' => '',
                    'level5' => '',
                ];

                if ($item->level1Parent) {
                    $levelNames['level1'] = $item->level1Parent->ms_kategori_name;
                    $levelNames['level2'] = $item->ms_kategori_name;
                }

                if ($item->level2Parent) {
                    $levelNames['level2'] = $item->level2Parent->ms_kategori_name;
                    $levelNames['level3'] = $item->ms_kategori_name;
                }

                if ($item->level3Parent) {
                    $levelNames['level3'] = $item->level3Parent->ms_kategori_name;
                    $levelNames['level4'] = $item->ms_kategori_name;
                }

                if ($item->level4Parent) {
                    $levelNames['level4'] = $item->level4Parent->ms_kategori_name;
                    $levelNames['level5'] = $item->ms_kategori_name;
                }

                return [
                    'ms_kategori_id' => $item->ms_kategori_id,
                    'ms_kategori_level' => $item->ms_kategori_level,
                    'ms_kategori_parent' => $item->ms_kategori_parent,
                    'level1' => $levelNames['level1'],
                    'level2' => $levelNames['level2'],
                    'level3' => $levelNames['level3'],
                    'level4' => $levelNames['level4'],
                    'level5' => $levelNames['level5'],
                ];
            });

            return response()->json(['getMsKategori' => $getMsKategori]);
        } else {
            return response()->json(['error' => 'Not authorized.'], 404);
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
            'ubah_kategori_id' => 'required|exists:mskategori,ms_kategori_id',
            'ubah_kategori_level' => 'required|numeric',
            'ubah_kategori_name' => 'required|string',
            'ubah_kategori_name_en' => 'required|string',
            'ubah_kategori_icon' => 'nullable|image',
            'ubah_kategori_parent' => 'nullable|exists:mskategori,ms_kategori_id',
            'ubah_kategori_punya_turunan' => 'required|boolean',
            'ubah_kategori_req_file' => 'nullable|boolean',
            'ubah_kategori_file' => 'nullable|file',
        ]);

        $kategori_id = $request->input('ubah_kategori_id');
        $kategori_level = $request->input('ubah_kategori_level');
        $kategori_name = $request->input('ubah_kategori_name');
        $kategori_name_en = $request->input('ubah_kategori_name_en');
        $kategori_icon = $request->file('ubah_kategori_icon');
        $kategori_parent = $request->input('ubah_kategori_parent');
        $kategori_punya_turunan = $request->input('ubah_kategori_punya_turunan');
        $kategori_req_file = $request->input('ubah_kategori_req_file');
        $kategori_file = $request->file('ubah_kategori_file');
        $file_icon = "";
        $file_file = "";
        $username_id = Session::get('HINO_ID');
        $date_now = now();

        // Check if the request has an uploaded icon
        if ($kategori_icon) {
            $extension = $kategori_icon->getClientOriginalExtension();
            $destination_p = 'dokumen/kategori/icon/';
            $dokumen_p =  $destination_p . '_' . $kategori_name . '_' . rand()  .'.' . $extension;
            $kategori_icon->move($destination_p, $dokumen_p);
            $file_icon = $dokumen_p;
        }

        // Update the main category data
        $category = Category::where('ms_kategori_id', $kategori_id)->update([
            'ms_kategori_level' => $kategori_level,
            'ms_kategori_name' => $kategori_name,
            'ms_kategori_name_en' => $kategori_name_en,
            'ms_kategori_flag_turunan' => $kategori_punya_turunan,
            'ms_kategori_flag_form' => $kategori_req_file,
            'update_id' => $username_id,
            'update_date' => $date_now,
        ]);

        // Update the parent category
        if ($kategori_parent !== "") {
            Category::where('ms_kategori_id', $kategori_id)->update(['ms_kategori_parent' => $kategori_parent]);
        } else {
            Category::where('ms_kategori_id', $kategori_id)->update(['ms_kategori_parent' => null]);
        }

        // Update the category file
        if ($kategori_file) {
            $extension_file = $kategori_file->getClientOriginalExtension();
            $destination_file = 'dokumen/kategori/file/';
            $dokumen_file =  $destination_file . '_' . $kategori_name . '_' . rand()  .'.' . $extension_file;
            $kategori_file->move($destination_file, $dokumen_file);
            $file_file = $dokumen_file;

            Category::where('ms_kategori_id', $kategori_id)->update(['ms_kategori_file' => $file_file]);
        }

        // Update the category icon
        if ($kategori_icon) {
            Category::where('ms_kategori_id', $kategori_id)->update(['ms_kategori_image' => $file_icon]);
        }

        if ($category) {
            $kode_pesan = 1;
            $pesan = "Berhasil Ubah Kategori";
        } else {
            $kode_pesan = 0;
            $pesan = "Gagal Ubah Kategori";
        }

        return response()->json(['kode_pesan' => $kode_pesan, 'pesan' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'hapus_kategori_id' => 'required|exists:mskategori,ms_kategori_id',
        ]);

        $hapus_kategori_id = $request->input('hapus_kategori_id');
        $username_id = Session::get('HINO_ID');
        $date_now = now();

        $category = Category::where('ms_kategori_id', $hapus_kategori_id)->update([
            'active' => 0,
            'update_id' => $username_id,
            'update_date' => $date_now,
        ]);

        if ($category) {
            $kode_pesan = 1;
            $pesan = "Berhasil Hapus Kategori";
        } else {
            $kode_pesan = 0;
            $pesan = "Gagal Hapus Kategori";
        }

        return response()->json(['kode_pesan' => $kode_pesan, 'pesan' => $pesan]);
    }
    
    public function getKategoriByLevel(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        $id = $request->input('id');
        $getMsKategori = Category::where('active', 1)
            ->where('ms_kategori_level', $id)
            ->orderBy('ms_kategori_id')
            ->get();

        return response()->json($getMsKategori);
    }

    public function getKategoriByID(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mskategori,ms_kategori_id',
        ]);

        $id = $request->input('id');
        $getMsKategori = Category::where('ms_kategori_id', $id)
            ->orderBy('ms_kategori_id')
            ->get();

        return response()->json($getMsKategori);
    }

    public function getKategoriByParent(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mskategori,ms_kategori_id',
        ]);

        $id = $request->input('id');
        $getMsKategori = Category::with('parentCategory')
            ->select('*', 'GETISCHILDLEVEL5(MS_KATEGORI_ID) as CHILDLEVEL5')
            ->where('active', 1)
            ->where('ms_kategori_parent', $id)
            ->orderBy('ms_kategori_name')
            ->get();

        return response()->json($getMsKategori);
    }
}
