<?php

namespace App\Http\Controllers\Sidebar;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
<<<<<<< HEAD
    
=======
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getMenu = Category::where('active', 1)
        ->where('ms_kategori_level', 1)
        ->get();

        return $getMenu;
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
    public function show(string $id)
    {
        //
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
