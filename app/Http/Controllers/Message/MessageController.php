<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Make sure this line is present
use Symfony\Component\HttpFoundation\Response;
use App\Models\Message;

class MessageController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ms_pic_web' => 'nullable|string',
            'ms_content' => 'required|string',
            'ms_attachment' => 'nullable|string',
            "created_by" => 'nullable|integer',
            'ms_company_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $message = Message::create($data);
        
        return response()->json(['message' => $message], Response::HTTP_OK);
    }
}
