<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\AuditTrailCategory;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    public function getMainCategory(){
        $categories = Category::active()
            ->selectColumns()
            ->orderBy('ms_kategori_level')
            ->get();
    
        $categoryTree = $this->buildCategoryTree($categories);
    
        return response()->json($categoryTree);
    }
    
    protected function buildCategoryTree($categories, $parent = null) {
        $tree = [];
    
        foreach ($categories as $category) {
            if ($category->ms_kategori_parent == $parent) {
                $subcategories = $this->buildCategoryTree($categories, $category->ms_kategori_id);
    
                $categoryData = [
                    'ms_kategori_level' => $category->ms_kategori_level,
                    'ms_kategori_parent' => $category->ms_kategori_parent,
                    'ms_kategori_id' => $category->ms_kategori_id,
                    'name_id' => $category->ms_kategori_name,
                    'name_en' => $category->ms_kategori_name_en,
                    'active' => $category->active,
                ];
    
                if (!empty($subcategories)) {
                    $categoryData['Level' . ($category->ms_kategori_level + 1)] = $subcategories;
                }
    
                if ($parent === null || $parent === 0) {
                    $tree[] = ['Level1' => $categoryData];
                } else {
                    $tree[] = $categoryData;
                }
            }
        }
    
        return $tree;
    }
       
    // public function getMainCategory($main_id)
    // {        
    //     // Validate the input to prevent SQL injection and other security issues
    //     try {
    //         Validator::validate(['main_id' => $main_id], ['main_id' => 'required|numeric']);
    //     } catch (ValidationException $e) {
    //         return response()->json(['success' => false, 'message' => 'Invalid input. The id parameter is required.'], Response::HTTP_BAD_REQUEST);
    //     }
    //     // Fetch the main category by its ID
    //     $getMsKategori = Category::with('level1Parent')
    //         ->select('*')
    //         ->where('active', 1)
    //         ->where('ms_kategori_id', $main_id)
    //         ->orderBy('ms_kategori_id', 'asc')
    //         ->get();

    //     // Fetch the subcategories of the main category
    //     $getMsKategori2 = Category::with('level2Parent')
    //         ->select('*')
    //         ->where('active', 1)
    //         ->where('ms_kategori_parent', $main_id)
    //         ->orderBy('ms_kategori_id', 'asc')
    //         ->get();

    //     // Fetch the subcategories of subcategories (nested subcategories)
    //     $getMsKategori3 = Category::with('level3Parent')
    //         ->whereIn('ms_kategori_parent', function ($query) use ($main_id) {
    //             $query->select('ms_kategori_id')
    //                 ->from('mskategori')
    //                 ->where('active', 1)
    //                 ->where('ms_kategori_parent', $main_id);
    //         })
    //         ->where('active', 1)
    //         ->orderBy('ms_kategori_id', 'asc')
    //         ->get();

    //     $dataMsKategori = [
    //         'getMsKategori' => $getMsKategori,
    //         'getMsKategori2' => $getMsKategori2,
    //         'getMsKategori3' => $getMsKategori3
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Categories and their relationships retrieved successfully.',
    //         'data' => $dataMsKategori,
    //     ], Response::HTTP_OK);
    // }
    
    // public function getKategoriByLevel($id)
    // {
    //     try {
    //         Validator::validate(['main_id' => $id], ['main_id' => 'required|numeric']);
    //     } catch (ValidationException $e) {
    //         return response()->json(['success' => false, 'message' => 'Invalid input. The id parameter is required.'], Response::HTTP_BAD_REQUEST);
    //     }

    //     // Fetch categories by their level using the Category model
    //     $getMsKategori = Category::where('active', 1)
    //         ->where('ms_kategori_level', $id)
    //         ->get();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Categories level retrieved successfully.',
    //         'data' => $getMsKategori,
    //     ], Response::HTTP_OK);
    // }

    public function insertAuditTrail(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|integer', // Add more validation rules if needed
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input. The id parameter is required.'], Response::HTTP_BAD_REQUEST);
        }

        $user = JWTAuth::user();
        $username_id = $user->ms_user_id;
        $date_now = now();

        $auditTrail = AuditTrailCategory::create([
            'audit_user_id' => $username_id,
            'audit_date' => $date_now,
            'audit_kategori_id' => $request->input('kategori_id'),
        ]);

        if ($auditTrail) {
            return response()->json([
                'success' => true,
                'message' => 'Audit trail record created successfully.',
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create audit trail record.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function respondRequestForm(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        
        // Use null coalescing operator (??) to handle missing 'reject_note'
        $note = $request->input('reject_note') ?? '';

        if (env('USE_EMAIL') == true) {
            $user = JWTAuth::user();

            $username = $user->ms_user_name;
            $username_id = $user->ms_user_id;
            $date_now = now();

            // Update the 'REQUEST_FORM' table in the database
            $query_update_request = DB::table('request_form')
                ->where('request_id', $id)
                ->update([
                    'request_status' => $status,
                    'request_update_by' => $username_id,
                    'request_update_date' => $date_now,
                    'request_status_reason' => $note,
                ]);

            if ($query_update_request) {
                // Retrieve additional data from the database
                $file_kategori = DB::table('mskategori')
                    ->select('*', DB::raw('(select request_user_id FROM request_form where request_id=' . $id . ') as request_user_id'))
                    ->where('ms_kategori_id', DB::raw('(select request_kategori_id FROM request_form where request_id=' . $id . ')'))
                    ->where('active', 1)
                    ->first();
                
                $request_user_id = $file_kategori->request_user_id ?? '';    
                
                $user = DB::table('msuser')
                    ->where('ms_user_id', $request_user_id)
                    ->where('active', 1)
                    ->first();

                $email = $user->ms_user_email;

                $data = [
                    'file_kategori' => $file_kategori,
                    'user' => $user,
                    'note' => $note,
                ];

                if ($status == "Approve") {
                    // Mail::send('adminpanel.emails.email_sendFileKategori', $data, function ($m) use ($email) {
                    //     $m->to($email)->subject('Hino Request File');
                    // });
                } else {
                    // Mail::send('adminpanel.emails.email_rejectFileKategori', $data, function ($m) use ($email) {
                    //     $m->to($email)->subject('Hino Request File');
                    // });
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'approval' => $status,
                'message' => 'Sorry, the mail server is currently offline. Please try again later.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'approval' => $status,
            'message' => 'Email successfully send.',
        ], Response::HTTP_OK);
    }

    public function requestCategory(Request $request)
    {
        $id = $request->input('kategori_id');
        $req_karoseri_name = $request->input('req_karoseri_name');
        $req_karoseri_body = $request->file('req_karoseri_body');
        $req_karoseri_muatan = '';
        $body_doc = "";

        $user = JWTAuth::user();
        $username = $user->ms_user_name;
        $username_id = $user->ms_user_id;
        $date_now = now();

        if ($request->hasFile('req_karoseri_body')) {
            $extension = $req_karoseri_body->getClientOriginalExtension();
            $destination_p = 'dokumen/request/body';
            $dokumen_p =  $destination_p . '/' . rand() . '.' . $extension;
            $req_karoseri_body->move($destination_p, $dokumen_p);
            $body_doc = $dokumen_p;
        }

        $query_insert_AT = DB::table('audit_trail_kategori')->insert([
            'audit_date' => $date_now,
            'audit_user_id' => $username_id,
            'audit_kategori_id' => $id,
        ]);

        $query_request_category = DB::table('request_form')->insert([
            'request_user_id' => $username_id,
            'request_date' => $date_now,
            'request_status' => 'Request',
            'request_kategori_id' => $id,
            'request_karoseri_name' => $req_karoseri_name,
            'request_muatan' => $req_karoseri_muatan,
            'request_body' => $body_doc,
            'request_status_reason' => '', // Set a default value to an empty string
        ]);

        if ($query_request_category) {
            $kode_pesan = 1;
            $pesan = "Request Berhasil, Menunggu Konfirmasi";
        } else {
            $kode_pesan = 0;
            $pesan = "Request Gagal";
        }

        // if (env('USE_EMAIL') == "true") {
        //     $username = session('HINO');
        //     $getKategori = DB::select("SELECT
        //         concat(
        //             ' -> ', GETKATEGORINAME(GETPARENTID(GETPARENTID('$id'))),
        //             ' -> ', GETKATEGORINAME(GETPARENTID('$id')),
        //             ' -> ', GETKATEGORINAME('$id')
        //         ) as DataRequest
        //     ");
        //     $email = env('EMAIL_KAROSERI');

        //     $data = [
        //         'kategori' => $getKategori[0]->DataRequest,
        //         'karoseri' => $req_karoseri_name,
        //         'username' => $username,
        //     ];

        //     Mail::send('emails.email_reminder_request_kategori', $data, function ($m) use ($email) {
        //         $m->to($email)->subject('Hino Karoseri Notif Request File');
        //     });
        // }

        return response()->json(['kode_pesan' => $kode_pesan, 'pesan' => $pesan]);
    }
}
