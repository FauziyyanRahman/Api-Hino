<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\At;
use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Excel;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
<<<<<<< HEAD
    
=======
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
    public function create()
    {
        //
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
        // Check if the user is authenticated and has the necessary role
        $role_id = Session::get('HINO_ROLE');
        if ($role_id !== "admin" && $role_id !== "hmsi") {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Parse the date range from the request (if provided)
        $tgl_awal = $request->input('tgl_awal') ? date('Y-m-d', strtotime($request->input('tgl_awal'))) : date('Y-m-d');
        $tgl_akhir = $request->input('tgl_akhir') ? date('Y-m-d', strtotime($request->input('tgl_akhir'))) : date('Y-m-d');

        // Query the database using Eloquent ORM
        $getUserSurvey = Survey::select('survey.*', 'msuser.MS_USER_NAME', 'karoseri.KAROSERI_NAME')
            ->leftJoin('msuser', 'survey.SURVEY_USERNAME', '=', 'msuser.MS_USER_ID')
            ->leftJoin('karoseri', 'msuser.SURVEY_USERNAME', '=', 'karoseri.KAROSERI_NAME')
            ->whereBetween('survey.SURVEY_DATE', ["$tgl_awal 00:00:00", "$tgl_akhir 23:59:59"])
            ->get();

        // Return the survey data as JSON response
        return response()->json(['getUserSurvey' => $getUserSurvey], 200);
    }

    public function apiGetSurveyByID($id)
    {
        // Check if the user is authenticated (if needed)
        // Replace the 'auth:api' middleware with any other appropriate middleware if needed.

        // Query the database using Eloquent ORM to get the survey by ID
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['error' => 'Survey not found'], 404);
        }

        // Return the survey data as JSON response
        return response()->json($survey, 200);
    }

    public function apiDownloadReportSurvey($type, $tgl_awal, $tgl_akhir)
    {
        // Parse the date range from the request (if provided)
        $tgl_awal = $tgl_awal ? date('Y-m-d', strtotime($tgl_awal)) : date('Y-m-d');
        $tgl_akhir = $tgl_akhir ? date('Y-m-d', strtotime($tgl_akhir)) : date('Y-m-d');

        // Query the database using Eloquent ORM to get the survey data
        $getSurvey = Survey::select('*', 'msuser.MS_USER_NAME as Nama', 'karoseri.KAROSERI_NAME as KAROSERI_NAME')
            ->leftJoin('msuser', 'survey.SURVEY_USERNAME', '=', 'msuser.MS_USER_ID')
            ->leftJoin('karoseri', 'msuser.SURVEY_USERNAME', '=', 'karoseri.KAROSERI_NAME')
            ->whereBetween('survey.SURVEY_DATE', ["$tgl_awal 00:00:00", "$tgl_akhir 23:59:59"])
            ->get();

        // Generate the data to be included in the Excel report
        $getData = '';
        if ($getSurvey) {
            foreach ($getSurvey as $gj) {
                $getData .= "<tr>
                    <td>$gj->KAROSERI_NAME</td>
                    <td>$gj->Nama</td>
                    <td>$gj->SURVEY_DATE</td>
                    <td>$gj->SURVEY_QUESTION_1</td>
                    <td>$gj->SURVEY_ANSWER_1</td>
                    <td>$gj->SURVEY_COMMENT_1</td>
                    <td>$gj->SURVEY_QUESTION_2</td>
                    <td>$gj->SURVEY_ANSWER_2</td>
                    <td>$gj->SURVEY_COMMENT_2</td>
                    <td>$gj->SURVEY_QUESTION_3</td>
                    <td>$gj->SURVEY_ANSWER_3</td>
                    <td>$gj->SURVEY_COMMENT_3</td>
                    <td>$gj->SURVEY_QUESTION_4</td>
                    <td>$gj->SURVEY_ANSWER_4</td>
                    <td>$gj->SURVEY_COMMENT_4</td>
                    <td>$gj->SURVEY_NOTE</td>
                  </tr>";
            }
        }

        // Generate and return the Excel report as a downloadable attachment in the API response
        return Excel::download(function ($excel) use ($getData) {
            $excel->sheet('List Survey', function ($sheet) use ($getData) {
                $sheet->loadView('adminpanel.ReportSurveydownload', compact('getData'));
            });
        }, 'ListSurvey.' . $type);
    }

    public function dataAudit(Request $request)
    {
        $role_id = Session::get('HINO_ROLE');
    
        if ($role_id != "admin" && $role_id != "hmsi") {
            return response()->json(['error' => 'You are not authorized to access this resource.'], 403);
        }
    
        $tgl_awal = $request->input('tgl_awal', date("Y-m-d"));
        $tgl_akhir = $request->input('tgl_akhir', date("Y-m-d"));
    
        $getUserAudit = At::select('audit_trail_kategori.*')
            ->leftJoin('msuser as b', 'audit_trail_kategori.audit_user_id', '=', 'b.ms_user_id')
            ->where('audit_date', '>=', "$tgl_awal 00:00:00")
            ->where('audit_date', '<=', "$tgl_akhir 23:59:59")
            ->get();
    
        // Add related attributes using accessors (if needed)
        $getUserAudit->transform(function ($item) {
            $item->KAROSERI_NAME = $item->getKaroseriName();
            $item->KATEGORI_NAME = $item->getKategoriName();
            $item->MS_USER_NAME = $item->msuser->ms_user_name;
            return $item;
        });
    
        return new JsonResponse(['getUserAudit' => $getUserAudit]);
    }

    public function downloadReportAudit($type, $tgl_awal, $tgl_akhir)
    {
        if ($tgl_akhir !== "" || $tgl_awal !== "") {
            $tgl_awal = date('Y-m-d', strtotime($tgl_awal));
            $tgl_akhir = date('Y-m-d', strtotime($tgl_akhir));
        } else {
            $tgl_awal = date("Y-m-d");
            $tgl_akhir = date("Y-m-d");
        }

        $getAudit = At::select('audit_trail_kategori.*', 'b.ms_user_name')
            ->leftJoin('msuser as b', 'audit_trail_kategori.audit_user_id', '=', 'b.ms_user_id')
            ->where('audit_date', '>=', "$tgl_awal 00:00:00")
            ->where('audit_date', '<=', "$tgl_akhir 23:59:59")
            ->get();

        // Add related attributes using accessors (if needed)
        $getAudit->transform(function ($item) {
            //$item->KAROSERI_NAME = GETKAROSERI_BY_USER_ID($item->audit_user_id);
            $item->KATEGORI_NAME = $item->kategori_name;
            return $item;
        });

        $getData = '';
        if ($getAudit) {
            foreach ($getAudit as $gj) {
                $getData .= "<tr>
                    <td>$gj->KAROSERI_NAME</td>
                    <td>$gj->ms_user_name</td>
                    <td>$gj->KATEGORI_NAME</td>
                    <td>$gj->audit_date</td>
                    </tr>";
            }
        }
        
        $fileName = 'List_History_Download.xlsx';
        return Excel::download(function ($excel) use ($getData) {
            $excel->sheet('List History Download', function ($sheet) use ($getData) {
                $sheet->loadView('adminpanel.ReportAuditdownload', ['getData' => $getData]);
            });
        }, $fileName, $type);
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
    public function destroy(string $id)
    {
        //
    }
>>>>>>> 02b16a2d8ca2269701d814d1164d45662d6d55a9
}
