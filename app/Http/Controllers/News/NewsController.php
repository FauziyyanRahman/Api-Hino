<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    public function getBeritaByID($id)
    {
        // Find the News record by its primary key 'ms_berita_id'
        $news = News::where('ms_berita_id', $id)->first();

        if ($news) {
            return response()->json([
                'success' => true,
                'message' => 'News retrieved successfully.',
                'data' => $news,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'News not found.',
            ], Response::HTTP_NOT_FOUND);
        }
    }
    public function dataBerita(Request $request)
    {
        $user = JWTAuth::user();

        // Check if the user exists and has the "admin" or "hmsi" role
        if ($user && ($user->ms_role_name === 'admin' || $user->ms_role_name === 'hmsi')) {
            // Proceed with the data retrieval
            $getMsBerita = News::where('active', 1)
                ->select([
                    'ms_berita_id',
                    'ms_berita_judul',
                    'ms_berita_content',
                    'ms_berita_image',
                    'active',
                    DB::raw('getusername(create_id::int) as create_id'), 
                    'create_date',
                    DB::raw('getusername(update_id::int) as update_id'),
                    'update_date'
                ])
                ->get();

            // Assuming the Eloquent query returns a collection of objects, you can convert it to JSON.
            return response()->json(['data' => $getMsBerita], Response::HTTP_OK);
        } else {
            // User doesn't have the required role, return a 403 Forbidden response.
            return response()->json(['error' => 'Access Denied. You need to be an authorized user.'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function AddMsBerita(Request $request)
    {
        // Validate user inputs
        $validator = Validator::make($request->all(), [
            'berita_judul' => 'required|string',
            'berita_content' => 'required|string',
            'berita_judul_en' => 'required|string',
            'berita_content_en' => 'required|string',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => 'Invalid input data. Please check the provided information.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Get the authenticated user
        $user = JWTAuth::user();
        $username_id = $user->ms_hino_id;
        $date_now = now();

        // Handle uploaded image
        if ($request->hasFile('berita_foto')) {
            $berita_foto = $request->file('berita_foto');
            $extension = $berita_foto->getClientOriginalExtension();
            $destinationPath = 'dokumen/berita/';
            $fileName = $request->input('berita_judul') . '_' . rand() . '.' . $extension;
            $berita_foto->move($destinationPath, $fileName);
            $berita_image_path = $destinationPath . $fileName;
        } else {
            $berita_image_path = '';
        }

        // Prepare the data to be stored in the database
        $data = [
            'ms_berita_judul' => $request->input('berita_judul'),
            'ms_berita_content' => $request->input('berita_content'),
            'ms_berita_judul_en' => $request->input('berita_judul_en'),
            'ms_berita_content_en' => $request->input('berita_content_en'),
            'ms_berita_image' => $berita_image_path,
            'active' => 1,
            'create_id' => $username_id,
            'create_date' => $date_now,
            'update_id' => $username_id,
            'update_date' => $date_now,
        ];

        // Save the data to the 'news' table using Eloquent's create method
        $news = News::create($data);

        // Check if the news was successfully saved
        if ($news) {
            return response()->json([
                'success' => true,
                'message' => 'News added successfully.',
                'data' => $news,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the news. Please try again later.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function ubahMsBerita(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ubah_berita_id' => 'required|integer',
            'ubah_berita_judul' => 'required|string|max:255',
            'ubah_berita_content' => 'required|string',
            'ubah_berita_judul_en' => 'required|string|max:255',
            'ubah_berita_content_en' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input data. Please check the provided information.',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $berita_id = $request->input('ubah_berita_id');
        $berita_judul = $request->input('ubah_berita_judul');
        $berita_content = $request->input('ubah_berita_content');
        $berita_judul_en = $request->input('ubah_berita_judul_en');
        $berita_content_en = $request->input('ubah_berita_content_en');
        $berita_foto = $request->file('ubah_berita_foto');

        $user = JWTAuth::user();
        $username_id = $user->ms_hino_id;
        $date_now = now();

        try {
            $file_dokumen = null;
            if ($request->hasFile('ubah_berita_foto')) {
                $extension = $berita_foto->getClientOriginalExtension();
                $destination_p = 'dokumen/berita/';
                $dokumen_p = $destination_p . '/' . $berita_judul . '_' . rand() . '.' . $extension;
                $berita_foto->move($destination_p, $dokumen_p);
                $file_dokumen = $dokumen_p;
            }

            $updateData = [
                'ms_berita_judul' => $berita_judul,
                'ms_berita_judul_en' => $berita_judul_en,
                'ms_berita_content' => $berita_content,
                'ms_berita_content_en' => $berita_content_en,
                'update_id' => $username_id,
                'update_date' => $date_now,
            ];

            if ($file_dokumen) {
                $updateData['ms_berita_image'] = $file_dokumen;
            }

            $news = News::find($berita_id);
            if (!$news) {
                return response()->json([
                    'success' => false,
                    'message' => 'News not found. Unable to update.',
                ], Response::HTTP_NOT_FOUND);
            }

            $news->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'News successfully updated.',
                'data' => $news,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the news article. Please try again later.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteMsBerita(News $news)
    {
        // Assuming you have an authentication mechanism to identify the logged-in user.
        $username_id = auth()->user()->id;
        $date_now = now();

        $validator = Validator::make(['hapus_berita_id' => $news->ms_berita_id], [
            'hapus_berita_id' => 'required|integer', // Validation rules for the article ID
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid article ID',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Soft delete the news article
        $news->active = 0;
        $news->update_id = $username_id;
        $news->update_date = $date_now;
        $news->save();

        return response()->json([
            'message' => 'Berita successfully deleted',
        ], 200);
    }
}
