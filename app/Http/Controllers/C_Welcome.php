<?php

namespace App\Http\Controllers;

use App\Models\MMedia;
use App\Models\MBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class C_Welcome extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $data = array(
                "main-title" => "Dashboard",
                "nm" => 0, //number-menu,
                "book" => MMedia::where("jenis_media_id",1)->count(),
                "jurnal" => MMedia::where("jenis_media_id",2)->count(),
                "berita" => MBerita::count()
            );
            $Breadcrumb = array(
                1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
                2 => array("is-active" => 1, "link" => "", "label" => "Dashboard"),
            );
            return view('dashboard', compact('data', 'Breadcrumb'));
            //return view('page-starter',compact('data','Breadcrumb'));
        } else {
            return redirect()->route('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        phpinfo();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
