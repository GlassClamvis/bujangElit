<?php

namespace App\Http\Controllers;

use App\Models\MJenisMediaProperties;
use App\Models\MContentMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class C_JenisMediaProperties extends Controller
{

    function __construct(){
        $this->middleware('permission:jenisMedia-list|jenisMedia-create|jenisMedia-edit|jenisMedia-delete', ['only' => ['index','store','getjenisMediaProperties']]);
        $this->middleware('permission:jenisMedia-create', ['only' => ['create','store']]);
        $this->middleware('permission:jenisMedia-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jenisMedia-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $jmi = Crypt::decryptString($request->globalMenuId);
        if (MJenisMediaProperties::where('jenis_media_id',$jmi)->count() > 0) {
            $lastRecord = MJenisMediaProperties::where('jenis_media_id',$jmi)->orderBy('urut', 'desc')->first();
            $nextSequence = $lastRecord->urut + 1;
        } else {
            $nextSequence = 1;
        }
        $input['title']          = $request->properti;
        $input['urut']           = $nextSequence;
        $input['jenis_media_id'] = $jmi;
        $MediaProperty           = MJenisMediaProperties::create($input);
        if($MediaProperty){
            echo "Data Properti Media Berhasil di Input";
        }else{
            echo "Data Properti Media Gagal di Inpunt";
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);
        $input['title']   = $request->properti;
        $properti          = MJenisMediaProperties::find($id);
        $properti->update($input);
        if($properti){
            echo "Data Property Media Berhasil di Ubah";
        }else{
            echo "Data Property Media Gagal di Ubah";
        }


    }


    public function destroy(Request $request)
    {
        MJenisMediaProperties::find($request->id)->delete();
        //return redirect()->route('menu.index')->with('success','Menu deleted successfully');
    }

    public function getjenisMediaProperties($id=null){
        if($id === null){
            $qr= MJenisMediaProperties::all();
        }else{
            $id = Crypt::decryptString($id);
            $qr= MJenisMediaProperties::where("jenis_media_id",$id)->get();
        }
        $Delete=route('jenisMediaPropertiesDelete');

        $data = array();
		if(count($qr)){ $no =0;
            $firstQr = $qr->first();
            $lastQr  = $qr->last();
            foreach($qr as $key => $v){ $no++;
                $idEncrypt = Crypt::encryptString($v->id);
                $number     = $v['urut'];
                $title  = $v['title'];
                $btn    = "<button type='button' data-update='".route('jenisMediaProperties.update',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClassProperties'><i class='ri-edit-2-line'></i></button> 
                <button type='button'  data-val='$v[id]' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClassProperties'><i class='ri-delete-bin-2-line'></i></button>";
                    
                if($v->is_aktif){
                    $span = "<span data-val='$v->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
                }else{
                    $span = "<span data-val='$v->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
                } 

                if($v->is_cek){
                    $spanCek = "<span data-val='$v->is_cek' data-id='$idEncrypt' class='btn btn-rouded btn-info isCek'>Cek</span>";
                }else{
                    $spanCek = "<span data-val='$v->is_cek' data-id='$idEncrypt' class='btn btn-rouded btn-danger isCek'>Not Cek</span>";
                } 

                //Urutan || Squence Belum

              /*   if($key !== 0 ){$btnUp = 'btnUp-'.$no; $btnRow ='row-'.$no;
                    $btn = $btn. "<a href='#'  >
                    <button type='button' id='$btnUp' data-val='$btnRow' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 classUp'>
                        <i class='fe-arrow-up'></i>
                    </button></a>";
                }
                if($key !== ($qr->count()-1)){$btnDown = 'btnUp-'.$no; $btnRow ='row-'.$no;
                    $btn = $btn. "<a href='#'  >
                    <button type='button' id='$btnDown' data-val='$btnRow' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 classUp'>
                        <i class='fe-arrow-down'></i>
                    </button></a>";
                } */


            
                $data[] = array($number,$title,$span, $spanCek,$btn);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
        }
        
        $output = array("data" => $data);
        return json_encode($output);
        
    }

    public function statusJenisMediaProperties(Request $request){
        $id = Crypt::decryptString($request->id);
        $input['is_aktif'] = $request->status;
        $properti          = MJenisMediaProperties::find($id);
        $properti->update($input);
        if($properti){
            $response = array(
                'status' => 200,
                'activation'=> $request->status
            );
        }else{
            $response = array(
                'status' => 503,
                'activation'=> $request->status
            );
        }
        return json_encode($response);
    }
    
    public function isCekJenisMedia(Request $request){
        $id = Crypt::decryptString($request->id);
        $input['is_cek'] = $request->status;
        $properti          = MJenisMediaProperties::find($id);
        MJenisMediaProperties::where('jenis_media_id', $properti->jenis_media_id)->update([
            'is_cek' => 0,
        ]);
        $properti->update($input);
        //dd($properti);
       

        if($properti){
            $response = array(
                'status' => 200,
            );
        }else{
            $response = array(
                'status' => 503,
            );
        }
        return json_encode($response);
    }
    
}
