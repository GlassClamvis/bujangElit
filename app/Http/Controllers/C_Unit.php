<?php

namespace App\Http\Controllers;

use App\Models\M_Staff;
use App\Models\MKajur;
use App\Models\MKanit;
use App\Models\MStaff;
use App\Models\MUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Unit extends Controller
{
    function __construct(){
        $this->middleware('permission:unit-list|unit-create|unit-edit|unit-delete', ['only' => ['index','store','getUnit']]);
        $this->middleware('permission:unit-create', ['only' => ['create','store']]);
        $this->middleware('permission:unit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:unit-delete', ['only' => ['destroy']]);
    }

    public function index(){
        $data=array(
            "main-title" => "Unit",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Unit List"),
        );

        return view('unit.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $Breadcrumb = array(
            1 => array("link" => url("/"), "label" => "E-PAK"),
            2 => array("link" => url("jurusan"), "label" => "List Jurusan"),
            3 => array("link" => "active", "label" => "Tambah Jurusan"),
        );
    }

    public function store(Request $request){
        $request->validate([
          /*   'kodejurusan'                => 'required|string|max:32', */
            'unit'                    => 'required|string|max:64',
        ]);
        $input['kode']        = strtoupper($request->kodeunit);
        $input['title']       = ucwords($request->unit);
        $input['user_id']     = Auth::user()->id;
        $unit = MUnit::create($input);

        return redirect(route('unit.index'))->with('success','Data Unit Berhasil di Simpan.');
    }

    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        //dd($);
        $request->validate([
            'unit'                    => 'required|string|max:64',
        ]);
        $input['kode'] = strtoupper($request->kode_unit);
        $input['title'] = ucwords($request->unit);
        //$input['user_id']       = Auth::user()->id;
        $unit = MUnit::find($id);
        //dd($unit);
        $unit->update($input);

       if($unit){
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

    public function destroy(Request $request){
        MUnit::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('jurusan.index')->with('success','Jurusan deleted successfully');
    }

    public function getUnit(Request $request){
        $draw       = $request->get('draw');
        $start      = $request->get("start");
        $rowperpage = $request->get("length");  // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr  = $request->get('columns');
        $order_arr       = $request->get('order');
        $search_arr      = $request->get('search');

        $columnIndex     = $columnIndex_arr[0]['column'];          // Column index
        $columnName      = $columnName_arr[$columnIndex]['data'];  // Column name
        $columnSortOrder = $order_arr[0]['dir'];                   // asc or desc
        $searchValue     = $search_arr['value'];                   // Search value

        // Total records
        $totalRecords = MUnit::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MUnit::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MUnit::orderBy($columnName, $columnSortOrder)
            ->where('title', 'like', '%' . $searchValue . '%')
            ->select('unit.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
           
            $button = "";
            if(Gate::check('unit-edit')){
                $button = $button."<a href='#' data-href='".route('unit.edit',$record->id)."' data-update='".route('unit.update',$record->id)."' data-kode='".$record->kode."' data-unit='".$record->title."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                    Edit
                </a>";
            }
            if(Gate::check('unit-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                    Delete
                </a>";
            }
            $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-kode='".$record->kode."' data-unit='".$record->title."' data-val='".$record->id."'>
                Detail
            </a>";

            /* $span="";
            if($record->is_aktif){
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-info stts'>Aktif</span>";
            }else{
                $span = "<span data-val='$record->is_aktif' data-id='$idEncrypt' class='btn btn-rouded btn-danger stts'>Non Aktif</span>";
            } */

            $data_arr[] = array(
                "id"     => $number,
                "kode"             => $record->kode,
                "unit"   => $record->title,
                "action" => $button
                /* "kajur"            => $kajur, */
                /* "is_aktif"         => $span, */
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
