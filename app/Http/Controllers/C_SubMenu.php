<?php

namespace App\Http\Controllers;

use App\Models\MSubMenu;
use App\Models\MContentMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class C_SubMenu extends Controller
{

    function __construct(){
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index','store','getJurusan']]);
        $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
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
        $input['title']   = $request->subMenu;
        $input['url']     = Str::slug(strtolower($request->subMenu), '-');
        $input['user_id'] = Auth::user()->id;
        $input['menu_id'] = Crypt::decryptString($request->globalMenuId);
        $subMenu          = MSubMenu::create($input);
        if($subMenu){
            echo "Data Sub Menu Berhasil di Input";
        }else{
            echo "Data Sub Menu Gagal di Inpunt";
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
        $input['title']   = $request->subMenu;
        $input['url']     = Str::slug(strtolower($request->subMenu), '-');
        $input['user_id'] = Auth::user()->id;
        //dd($input);
        $subMenu          = MSubMenu::find($id);
        $subMenu->update($input);
        if($subMenu){
            echo "Data Sub Menu Berhasil di Ubah";
        }else{
            echo "Data Sub Menu Gagal di Ubah";
        }


    }


    public function destroy(Request $request)
    {
        MSubMenu::find($request->id)->delete();
        //return redirect()->route('menu.index')->with('success','Menu deleted successfully');
    }

    public function getSubmenu($id=null){
        if($id === null){
            //echo $id;
            $qr= MSubMenu::all();
        }else{
            $id = Crypt::decryptString($id);
            $qr= MSubMenu::where("menu_id",$id)->get();
        }
        $subMenuhapus=route('subMenuDelete');

        $data = array();
		if(count($qr)){ $number =0;
            foreach($qr as $v){
                $idEncrypt = Crypt::encryptString($v->id);
       $number     = ++$number;
       $title  = $v['title'];
       $url    = $v['url'];
       $btn    = "<button type='button' data-update='".route('subMenu.update',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClassSubMenu'><i class='ri-edit-2-line'></i></button> 
       <button type='button'  data-val='$v[id]' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 btnDeleteClassSubMenu'><i class='ri-delete-bin-2-line'></i></button>";
       if($v->is_aktif){
        $span = "<span data-val='$v->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
    }else{
        $span = "<span data-val='$v->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
    } 
    $contentMenu = MContentMenu::where('url', $url)->first();
    if($contentMenu){
        $contentMenuId = Crypt::encryptString($contentMenu->id);
        $route = route('contentMenu.edit', $contentMenuId);
        $content    = "<a href='".$route."' class='btn btn-success btn-outline btn-circle btn-md m-r-5 '>Edit Content</a>";
    }else{
        $route = url('createCM/'.$idEncrypt);
    $content    = "<a href='".$route."' class='btn btn-warning btn-outline btn-circle btn-md m-r-5 '>Create Content</a>";
}
       $data[] = array($number,$title,$span,$btn,$content);
    		}
        }else{
            $data[]=array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
        }

        $output = array("data" => $data);
        return json_encode($output);

    }

    public function ProdiSelect(Request $request){
        $q = MProgramStudi::where('tm_jurusan_id',$request->id)->get();
        $data= array();
		foreach($q as $v){
			$id=$v->id;
			$nm=$v->program_studi." (".$v->kode.")";
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

    public function TahunAjaranSelect(Request $request){
        $q = MSemester::where('tm_tahun_ajaran_id',$request->id)->get();
        $data= array();
		foreach($q as $v){
			$id=$v->id;
			$nm=$v->semester." ( ".$v->taData->tahun_ajaran." )";
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

    public function MKSelect(Request $request){
        $q = MPengampu::where('tr_matakuliah_semester_prodi_id',$request->id)->get();
        $data= array();
		foreach($q as $v){
			$id=$v->id;
			$nm=$v->pegawaiData->nama;
			$data[] = array("id"=>$id,"nama"=>$nm);
		}
		return json_encode($data);
    }

}
