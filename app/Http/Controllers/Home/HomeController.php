<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\RequestForm;
use Symfony\Component\HttpFoundation\Response;
use App\Models\At;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        // Apply the 'auth.api' middleware to the functions that require authentication.
        $this->middleware('auth.api');
    }

    public function visitors() {
        $now = Carbon::now();

        $request =  RequestForm::getRequest();

        $total = At::whereHas('user', function ($query) {
            $query->where('ms_role_name', '<>', 'hmsi');
        })->count();

        $monthly = Users::whereHas('at', function ($query) use ($now) {
            $query->whereYear('date_login', $now->year)
                ->whereMonth('date_login', $now->month);
        })
        ->where('ms_role_name', '<>', 'hmsi')
        ->count();

        $weekly = Users::whereHas('at', function ($query) use ($now) {
            $query->whereYear('date_login', $now->year)
            ->whereMonth('date_login', $now->month)
            ->whereRaw('extract(week from date_login) = ?', [$now->weekOfYear]);
        })
        ->where('ms_role_name', '<>', 'hmsi')
        ->count();

        $data = [
            'visitors' => [
                'total' => $total,
                'monthly' => $monthly,
                'weekly' => $weekly
            ],
            'request' => $request
        ];

        return response()->json([
            'success' => true,
            'message' => 'Visitors request status data retrieved successfully.',
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public function requestData() {
        $requestData = RequestForm::requestStatus()->select('request_id', 
            'MU.ms_user_name as username', 
            DB::raw("to_char(request_date, 'DD MON YYYY, HH24:MI') as request_date"),
            'request_status',
            'MK.ms_kategori_name as kategori_name',
            'request_karoseri_name', 'request_body','request_form.created_at'
            )
            ->join('mskategori as MK', 'MK.ms_kategori_id', '=', 'request_kategori_id')
            ->join('msuser as MU', 'MU.ms_user_id', '=', DB::raw('CAST(request_user_id AS integer)'))
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Request form data retrieved successfully.',
            'data' => $requestData,
        ], Response::HTTP_OK);
    }
}
