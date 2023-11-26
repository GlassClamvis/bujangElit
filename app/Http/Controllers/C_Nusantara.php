<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_Nusantara;

class C_Nusantara extends Controller
{
    function __construct()
    {

    }

    public function NusantaraSelect(Request $request){
        $x = strlen($request->id);
        $y = ($x == 2 ? 5 : ($x == 5 ? 8 : 13));
        $q = M_Nusantara::where('kode', 'LIKE', $request->id . '%')->whereRaw('char_length(kode)=' . $y)->orderBy('kode')->get();
        //$q = M_Nusantara::whereRaw("left(kode,$x)=".$request->id)->whereRaw("char_length(kode)=".$y)->get();
        $data = array();
        foreach ($q as $v) {
            $id = $v->kode;
            $nm = $v->nama;
            $data[] = array("id" => $id, "nama" => $nm);
        }
        return json_encode($data);
    }
}
