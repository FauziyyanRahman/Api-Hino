<?php

/**
 * API Controller for user authentication tasks.
 * Project: Hino
 * Version: 1
 * Author: Fauziyyan Thafhan Rahman
 * Date: 2023-07-25
 * Description: This controller handles user authentication and provides API endpoints
 *              for login, registration, changePasword, resetPassword, survey, logout, token refresh, 
 *              and user information retrieval.
 */

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        $user = Users::where('active', 1)
            ->where('ms_user_name', '=', $username)
            ->with('karoseri')
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Your username is not registered or not active'], Response::HTTP_UNAUTHORIZED);
        }

        $decodedPassword = base64_decode($user->getAttributeValue('ms_user_password'));
        if ($password !== $decodedPassword) {
            return response()->json(['error' => 'Incorrect password'], Response::HTTP_UNAUTHORIZED);
        }
        
        $additionalData = [
            'hino' => $user->getAttributeValue('ms_user_name'),
            'hino_id' => $user->getAttributeValue('ms_user_id'),
            'hino_role' => $user->getAttributeValue('ms_role_name'),
            'hino_email' => $user->getAttributeValue('ms_user_email'),
            'hino_pt' => $user->karoseri->getAttributeValue('ms_karoseri_name'),
            'hino_survey' => "true", 
            'hino_should_survey' => "true",
            'hino_language' => 'ID',
        ];

        $token = Auth::guard('api')->claims($additionalData)->fromUser($user);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $date_now = now()->format('Y-m-d H:i:s');
        $user->logins()->create([
            'date_login' => $date_now,
            'mac_add' => '',
            'ip_add' => '',
        ]);

        $getLastSurvey = Survey::where('survey_username', $user->getKey())
            ->orderBy('survey_date', 'desc')
            ->first();

        $shouldSurveyed = "false";
        if ($getLastSurvey) {
            // $tanggal = $getLastSurvey->survey_date;
            // $dateDiff = Survey::getDiffMonthSurveyNew($tanggal);
            // if ($dateDiff >= 3) {
            //     $shouldSurveyed = "true";
            // }
            $shouldSurveyed = "true";
        } else {
            $shouldSurveyed;
        }

        return response()->json($this->respondWithToken($token), Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'ms_user_name' => 'required|string',
            'ms_user_password' => 'required|string|min:6',
            'ms_user_description' => 'nullable|string',
            'ms_user_email' => 'required|email|unique:msuser',
        ]);

        $data['ms_user_password'] = base64_encode($data['ms_user_password']);

        $user = Users::create($data);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'change_username' => 'required',
            'change_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $user = Users::where('ms_user_name', $request->input('change_username'))->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $newPassword = $request->input('change_password');

        if (base64_encode($newPassword) === $user->getAttributeValue('ms_user_password')) {
            return response()->json(['error' => 'Oops! Please do not use your previous password as your new password'], Response::HTTP_BAD_REQUEST);
        }

        $user->update([
            'ms_user_password' => base64_encode($newPassword)
        ]);

        return response()->json(['message' => 'Password changed successfully'], Response::HTTP_OK);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:msuser,ms_user_name,active,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid username or user not active'], 400);
        }

        $username = $request->input('username');
        $user = Users::where('ms_user_name', $username)->first();

        if (env('USE_EMAIL') === true) {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $newPassword = '';
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $newPassword .= $alphabet[$n];
            }

            $user->ms_user_password = base64_encode($newPassword);
            $user->save();

            // Send the new password via email
            // $data = ['user' => $user, 'password' => $newPassword];
            // Mail::send([], $data, function ($message) use ($user, $data) {
            //     $message->to('digitalic.dimension@gmail.com')
            //             ->subject('Hino Forgot Password')
            //             ->setBody(view('emails.email_forgotpassword', $data)->render(), 'text/html');
            // });
            
            // Mail::send('emails.email_forgotpassword', $data, function ($m) use ($user) {
            //     $m->to($user->ms_user_email)->subject('Hino Forgot Password'); // Update the field name to lowercase as per the Users model definition
            // });

            return response()->json(['message' => 'Password reset successful. Check your email.'], 200);
        } else {
            return response()->json(['error' => 'Mail server is currently unavailable. Please try again later.'], 500);
        }
    }

    public function survey(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $username_id = $user->hino_id;

            $saran = $request->input('note');
            $date_now = now();

            $surveyData = [
                'survey_username' => $username_id,
                'survey_question_1' => $request->input('question1'),
                'survey_answer_1' => $request->input('answer1'),
                'survey_comment_1' => $request->input('remark1'),
                'survey_question_2' => $request->input('question2'),
                'survey_answer_2' => $request->input('answer2'),
                'survey_comment_2' => $request->input('remark2'),
                'survey_question_3' => $request->input('question3'),
                'survey_answer_3' => $request->input('answer3'),
                'survey_comment_3' => $request->input('remark3'),
                'survey_question_4' => $request->input('question4'),
                'survey_answer_4' => $request->input('answer4'),
                'survey_comment_4' => $request->input('remark4'),
                'survey_note' => $saran,
                'survey_date' => $date_now,
            ];

            $survey = new Survey($surveyData);

            $survey->save();

            return response()->json(['message' => 'Survey submitted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to submit survey'], 500);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out successfully'], Response::HTTP_OK);
    }

    public function refresh()
    {
        $token = Auth::guard('api')->refresh();

        return response()->json($this->respondWithToken($token), Response::HTTP_OK);
    }

    public function me()
    {
        $user = Auth::user();

        $additionalData = [
            'hino' => $user->ms_user_name,
            'hino_id' => $user->ms_user_id,
            'hino_role' => $user->ms_role_name,
            'hino_email' => $user->ms_user_email,
            'hino_pt' => $user->karoseri->ms_karoseri_name,
            'hino_survey' => $user->month_survey,
            'hino_should_survey' => 'true',
            'hino_language' => 'ID',
        ];

        return response()->json(['user_details' => $additionalData], Response::HTTP_OK);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
}