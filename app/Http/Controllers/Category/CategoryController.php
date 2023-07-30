<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function getMainCategory($main_id)
    {
        $getMsKategori = DB::select("SELECT *, GETKATEGORINAME(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME, GETKATEGORINAME_EN(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME_EN FROM MSKATEGORI WHERE ACTIVE=1 AND MS_KATEGORI_ID=".$main_id." ORDER BY MS_KATEGORI_ID ASC");
        $getMsKategori2 = DB::select("SELECT *, GETKATEGORINAME(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME, GETKATEGORINAME_EN(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME_EN FROM MSKATEGORI WHERE ACTIVE=1 AND MS_KATEGORI_PARENT=".$main_id." ORDER BY MS_KATEGORI_ID ASC");
        $getMsKategori3 = DB::select("SELECT *, GETKATEGORINAME(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME, GETKATEGORINAME_EN(MS_KATEGORI_PARENT::int) as MS_KATEGORI_PARENT_NAME_EN FROM MSKATEGORI WHERE MS_KATEGORI_PARENT IN (SELECT MS_KATEGORI_ID FROM MSKATEGORI WHERE ACTIVE=1 AND MS_KATEGORI_PARENT=".$main_id.") AND ACTIVE=1 ORDER BY MS_KATEGORI_ID ASC");

        $dataMsKategori = [
            'getMsKategori' => $getMsKategori,
            'getMsKategori2' => $getMsKategori2,
            'getMsKategori3' => $getMsKategori3
        ];

        return response()->json($dataMsKategori);
    }
}
