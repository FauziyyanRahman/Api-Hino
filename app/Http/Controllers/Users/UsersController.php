<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karoseri;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = Users::all();

        return response()->json($users, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_username' => 'required|unique:msuser,MS_USER_NAME',
            'user_password' => 'required',
            'user_email' => 'required|email',
            'user_role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // Check if the user is authenticated and has the required role
        $user = Auth::user();
        if (!$user || !in_array($user->HINO_ROLE, ["admin", "hmsi"])) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        $user_name = $request->input('user_username');
        $user_password = $request->input('user_password');
        $user_email = $request->input('user_email');
        $user_role = $request->input('user_role');
        $user_karoseri = $request->input('user_karoseri');

        if ($user_role !== "karoseri") {
            $user_karoseri = null;
        }

        // Create the new user using Eloquent
        $newUser = new Users();
        $newUser->MS_USER_NAME = $user_name;
        $newUser->MS_USER_PASSWORD = Hash::make($user_password);
        $newUser->MS_USER_EMAIL = $user_email;
        $newUser->MS_ROLE_NAME = $user_role;
        $newUser->MS_BODY_MAKER_ID = $user_karoseri;
        $newUser->ACTIVE = 1;
        $newUser->CREATE_ID = Session::get('HINO_ID');
        $newUser->CREATE_DATE = now();
        $newUser->UPDATE_ID = Session::get('HINO_ID');
        $newUser->UPDATE_DATE = now();
        $newUser->save();

        return response()->json(['message' => 'Berhasil Tambah User'], 200);
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
        // Check if the user is authenticated and has the required role
        $user = Auth::user();
        if (!$user || !in_array($user->HINO_ROLE, ["admin", "hmsi"])) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        // Retrieve users data using Eloquent
        $getMsUser = Users::with(['createdByUser:id,username', 'updatedByUser:id,username'])
            ->leftJoin('MSKAROSERI AS B', 'MSUSER.MS_BODY_MAKER_ID', '=', 'B.MS_KAROSERI_ID')
            ->where('MSUSER.ACTIVE', '!=', 0)
            ->get();

        // Retrieve body makers data using Eloquent
        $getMsBodyMaker = Karoseri::where('ACTIVE', 1)->get();

        $dataMsUser = ['getMsUser' => $getMsUser, 'getMsBodyMaker' => $getMsBodyMaker];
        return response()->json($dataMsUser, 200);
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
        $user_id = $request->input('ubah_user_id');
        $user_name = $request->input('ubah_user_username');
        $user_email = $request->input('ubah_user_email');
        $user_role = $request->input('ubah_user_role');

        if ($user_role !== "karoseri") {
            $user_karoseri = null;
        } else {
            $user_karoseri = $request->input('ubah_user_karoseri');	
        }
		
        // Validation
        $validator = Validator::make($request->all(), [
            'ubah_user_username' => 'required',
            'ubah_user_email' => 'required|email',
            'ubah_user_role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }

        // Check if the user is authenticated and has the required role
        $user = Auth::user();
        if (!$user || !in_array($user->HINO_ROLE, ["admin", "hmsi"])) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        // Find the user record by ID using Eloquent
        $userRecord = Users::find($user_id);

        if (!$userRecord) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update the user data using Eloquent
        $userRecord->MS_USER_NAME = $user_name;
        $userRecord->MS_USER_EMAIL = $user_email;
        $userRecord->MS_ROLE_NAME = $user_role;
        $userRecord->MS_BODY_MAKER_ID = $user_karoseri;
        $userRecord->UPDATE_ID = Session::get('HINO_ID');
        $userRecord->UPDATE_DATE = now();
        $userRecord->save();

        return response()->json(['message' => 'Berhasil Ubah User'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $hapus_user_id = $request['hapus_user_id'];
        // Check if the user is authenticated and has the required role
        $user = Auth::user();
        if (!$user || !in_array($user->HINO_ROLE, ["admin", "hmsi"])) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        // Find the user record by ID using Eloquent
        $user = Users::find($hapus_user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Soft delete the user using Eloquent
        $user->ACTIVE = 0;
        $user->UPDATE_ID = Session::get('HINO_ID');
        $user->UPDATE_DATE = now();
        $user->save();

        return response()->json(['message' => 'Berhasil Hapus User'], 200);
    }

    public function updateStatusMsUser(Request $request)
    {
        $user_id = $request['user_id'];

        // Check if the user is authenticated and has the required role
        $user = Auth::user();
        if (!$user || !in_array($user->HINO_ROLE, ["admin", "hmsi"])) {
            return response()->json(['message' => 'Permission denied.'], 403);
        }

        $user_status = $request->input('user_status');

        // Find the user record by ID using Eloquent
        $user = Users::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update the user status using Eloquent
        $user->ACTIVE = $user_status;
        $user->UPDATE_ID = Session::get('HINO_ID');
        $user->UPDATE_DATE = now();
        $user->save();

        return response()->json(['message' => 'Berhasil'], 200);
    }

    public function getUserByID($id)
    {
        // Find the user record by ID using Eloquent
        $user = Users::where('ACTIVE', 1)->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json($user);
    }
}
