<?php

namespace App\Http\Controllers;

use App\Models\MPengguna;
use App\Models\MJenisMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_JenisMedia extends Controller
{
    function __construct(){
        $this->middleware('permission:jenisMedia-list|jenisMedia-create|jenisMedia-edit|jenisMedia-delete', ['only' => ['index','store','getJenisMedia']]);
        $this->middleware('permission:jenisMedia-create', ['only' => ['create','store']]);
        $this->middleware('permission:jenisMedia-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:jenisMedia-delete', ['only' => ['destroy']]);
    }

    public function index(){

        $data = array(
            "main-title" => "Jenis Media",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Jenis Media List"),
        );

        return view('jenisMedia.index',compact('data','Breadcrumb'));
    }

    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'jenismedia'                => 'required|string|max:64',
        ]);
        $input['label']    = $request->jenismedia;
        $input['is_aktif'] = 1;
        $jenisMedia          = MJenisMedia::create($input);
        
        return redirect(route('jenisMedia.index'))->with('success','Data Jenis Media Berhasil di Simpan.');
    }
    
    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $request->validate([
            'jenismedia'                => 'required|string|max:32',
        ]);
        $input['label'] = $request->jenismedia;
        $jenismedia     = MJenisMedia::find($id);
        $jenismedia->update($input);
      
        return redirect(route('jenisMedia.index'))->with('success','Data Jenis Media Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MJenisMedia::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('jenisMedia.index')->with('success','Menu deleted successfully');
    }

    public function getJenisMedia(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = MJenisMedia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MJenisMedia::select('count(*) as allcount')->where('label', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MJenisMedia::orderBy($columnName, $columnSortOrder)
            ->where('label', 'like', '%' . $searchValue . '%')
            ->select('jenis_media.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
           
            $button = "";
            if(Gate::check('jenisMedia-edit')){
                $button = $button."<a href='#' data-href='".route('jenisMedia.edit',$record->id)."' data-update='".route('jenisMedia.update',$idEncrypt)."' data-label='".$record->label."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }

            if(Gate::check('jenisMedia-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }

            
            $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-menu='".$record->label."' data-kode='".$record->kode."' data-val='".$idEncrypt."'>
            <i class='ri-file-list-line'></i></a>";

            $data_arr[] = array(
                "id"     => $number,
                "media"  => $record->label,
                "action" => $button
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }
}
