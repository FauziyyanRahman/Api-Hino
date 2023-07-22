<?php

namespace App\Http\Controllers\Karoseri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Karoseri;


class KaroseriController extends Controller
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
        $karoseri = new Karoseri();

        $karoseri->ms_karoseri_region = $request->input('karoseri_region_add');
        $karoseri->ms_karoseri_wilayah = $request->input('karoseri_wilayah_add');
        $karoseri->ms_karoseri_tipe = $request->input('karoseri_tipe_add');
        $karoseri->ms_karoseri_name = $request->input('karoseri_name_add');
        $karoseri->ms_karoseri_merk = $request->input('karoseri_merk_add');
        $karoseri->ms_karoseri_domisili = $request->input('karoseri_domisili_add');
        $karoseri->ms_karoseri_alamat = $request->input('karoseri_alamat_add');
        $karoseri->ms_karoseri_telepon = $request->input('karoseri_telepon_add');
        $karoseri->ms_karoseri_fax = $request->input('karoseri_fax_add');
        $karoseri->ms_karoseri_website = $request->input('karoseri_website_add');
        $karoseri->ms_karoseri_unitproductioncap = $request->input('karoseri_unitpro_add');
        $karoseri->ms_karoseri_grade = $request->input('karoseri_grade_add');
        $karoseri->ms_karoseri_productlineup = $request->input('karoseri_proline_add');
        $karoseri->ms_karoseri_photoproduct = $request->input('karoseri_photoproduct_add');
        $karoseri->ms_karoseri_owner_name = $request->input('karoseri_ownname_add');
        $karoseri->ms_karoseri_owner_telepon = $request->input('karoseri_owntelepon_add');
        $karoseri->ms_karoseri_owner_email = $request->input('karoseri_ownemail_add');
        $karoseri->ms_karoseri_marketing_name = $request->input('karoseri_marname_add');
        $karoseri->ms_karoseri_marketing_telepon = $request->input('karoseri_martelepon_add');
        $karoseri->ms_karoseri_marketing_email = $request->input('karoseri_maremail_add');
        $karoseri->ms_karoseri_engineering_name = $request->input('karoseri_engname_add');
        $karoseri->ms_karoseri_engineering_telepon = $request->input('karoseri_engtelepon_add');
        $karoseri->ms_karoseri_engineering_email = $request->input('karoseri_engemail_add');
        $karoseri->ms_karoseri_production_name = $request->input('karoseri_proname_add');
        $karoseri->ms_karoseri_production_telepon = $request->input('karoseri_protelepon_add');
        $karoseri->ms_karoseri_production_email = $request->input('karoseri_proemail_add');
        $karoseri->active = 1;
        $karoseri->create_id = Session::get('HINO_ID');
        $karoseri->create_date = date("Y-m-d H:i:s");
        $karoseri->update_id = Session::get('HINO_ID');
        $karoseri->update_date = date("Y-m-d H:i:s");

        if ($karoseri->save()) {
            $kode_pesan = 1;
            $pesan = "Berhasil Tambah Body Maker";
        } else {
            $kode_pesan = 0;
            $pesan = "Gagal Tambah Body Maker";
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
        $role_id = $request->session()->get('HINO_ROLE');

        if ($role_id === "admin" || $role_id === "hmsi") {
            // Use the Karoseri model to retrieve the data from the database
            $getMsKaroseri = Karoseri::where('ACTIVE', 1)->get();

            // Return the data as a JSON response
            return response()->json(['getMsKaroseri' => $getMsKaroseri]);
        } else {
            return abort(404);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $hapus_karoseri_id = $request->input('hapus_karoseri_id');
        $username_id = Session::get('HINO_ID');
        $date_now = date("Y-m-d H:i:s");

        $karoseri = Karoseri::find($hapus_karoseri_id);

        if (!$karoseri) {
            return response()->json(['kode_pesan' => 0, 'pesan' => 'Body Maker not found'], 404);
        }

        $karoseri->active = 0;
        $karoseri->update_id = $username_id;
        $karoseri->update_date = $date_now;

        if ($karoseri->save()) {
            $kode_pesan = 1;
            $pesan = "Berhasil Hapus Body Maker";
        } else {
            $kode_pesan = 0;
            $pesan = "Gagal Hapus Body Maker";
        }

        return response()->json(['kode_pesan' => $kode_pesan, 'pesan' => $pesan]);
    }

    public function getKaroseriByID(Request $request)
    {
        $id = $request->input('id');

        $karoseri = Karoseri::find($id);

        if (!$karoseri) {
            return response()->json(['message' => 'Karoseri not found'], 404);
        }

        return response()->json($karoseri);
    }
}