<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sidebar\SidebarController;
use App\Models\At;
use App\Models\News;
use App\Models\RequestForm;
use Illuminate\Http\Request;
use Mail;
use Session;

class HomeController extends Controller
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
        $role_id = session('HINO_ROLE');

        $sidebar = new SidebarController();
        $menuSideBar = $sidebar->sideBar();

        $getNews = News::where('active', 1)
            ->orderBy('ms_berita_id')
            ->limit(4)
            ->get();

        $home = [
            'menuSideBar' => $menuSideBar,
            'getNews' => $getNews,
        ];

        return response()->json($home);
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

    /**
     * Checking user credential for admin panel
     */
    public function adminPanel(Request $request)
    {
        $role_id = Session::get('HINO');

        $getRequestFormDashboard = RequestForm::selectRaw("
            (SELECT COUNT(*) FROM request_form) AS total,
            (SELECT COUNT(*) FROM request_form WHERE request_status = 'approve') AS approve,
            (SELECT COUNT(*) FROM request_form WHERE request_status = 'reject') AS reject,
            (SELECT COUNT(*) FROM request_form WHERE request_status = 'request') AS request
        ")->first();

        $getRequestForm = RequestForm::with(['category', 'user'])
            ->where('request_status', 'request')
            ->get();

        $getVisitor = At::whereHas('user', function ($query) {
            $query->where('ms_role_name', '<>', 'hmsi');
        })->count();

        $getVisitorMonth = At::whereHas('user', function ($query) {
            $query->where('ms_role_name', '<>', 'hmsi');
        })->whereMonth('date_login', date('m'))
        ->whereYear('date_login', date('Y'))
        ->count();

        $getVisitorWeek = At::whereHas('user', function ($query) {
            $query->where('ms_role_name', '<>', 'hmsi');
        })->whereMonth('date_login', date('m'))
        ->whereYear('date_login', date('Y'))
        ->whereWeek('date_login', date('W'))
        ->count();

        $dataReqForm = [
            'getRequestForm' => $getRequestForm,
            'getRequestFormDashboard' => $getRequestFormDashboard,
            'getVisitor' => $getVisitor,
            'getVisitorMonth' => $getVisitorMonth,
            'getVisitorWeek' => $getVisitorWeek
        ];

        return response()->json($dataReqForm);
    }

    public function submitSaran(Request $request)
    {
        $comment = $request->input('comment');
        $username = session('HINO');
        $username_id = session('HINO_ID');
        $karoseri = session('HINO_PT');
        $email = session('HINO_EMAIL');

        if (env('USE_EMAIL') === 'true') {
            $emailKaroseri = env('EMAIL_KAROSERI');

            $data = [
                'comment' => $comment,
                'username' => $username,
                'email' => $email,
                'karoseri' => $karoseri,
            ];

            Mail::send('emails.email_saran', $data, function ($message) use ($emailKaroseri) {
                $message->to($emailKaroseri)->subject('Hino New Saran & Pertanyaan');
            });

            $response = [
                'message' => 'Terima kasih untuk saran & pertanyaan yang telah dikirimkan.',
            ];
        } else {
            $response = [
                'message' => 'Sorry, the mail server is currently unavailable. Please try again later.',
            ];
        }

        return response()->json($response);
    }
}
