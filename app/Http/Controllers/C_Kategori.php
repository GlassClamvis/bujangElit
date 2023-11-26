<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MKategori;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class C_Kategori extends Controller
{

    function __construct()
    {
         $this->middleware('permission:kategori-list|kategori-create|kategori-edit|kategori-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kategori-create', ['only' => ['create','store']]);
         $this->middleware('permission:kategori-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kategori-delete', ['only' => ['destroy']]);
    }

    public function index(){

        $data=array(
            "main-title" => "Kategori",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Kategori List"),
        );
        return view('kategori.index',compact('data','Breadcrumb'));
        //return view('dashboard',compact('data','Breadcrumb'));
    }


    public function create(){

    }


    public function store(Request $request){
        $kategori = $request->kategori;
        foreach($kategori as $key=> $p){
            $input['label']    = $p;
            $kategori = MKategori::create($input);
        }
        return redirect(route('kategori.index'))->with('success','Data Kategori Berhasil di Simpan.');
    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $request->validate([
            'kategori'          => 'required|string|max:255',
        ]);
        $input['label'] = $request->kategori;
        //echo $input['name'];
        $kategori = MKategori::find($id);
        $kategori->update($input);
        return redirect(route('kategori.index'))->with('success','Data Kategori Berhasil di Ubah.');
    }

    public function destroy( Request $request){
        MKategori::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('kategori.index')->with('success','Kategori deleted successfully');
    }

    public function getKategori(Request $request){
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
        $totalRecords = MKategori::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MKategori::select('count(*) as allcount')->where('label', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MKategori::orderBy($columnName, $columnSortOrder)
            ->where('label', 'like', '%' . $searchValue . '%')
            ->select('kategori.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";

            if(Gate::check('kategori-edit')){
                $button = $button." <a href='".route('kategori.edit',$record->id)."' data-kategori='".$record->label."' data-href='".route('kategori.update',$idEncrypt)."' class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                 Edit
            </a>";
            }
            if(Gate::check('kategori-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Delete
              </a>";
            }

           /*  $foto = "<img src='".asset($record->path)."'  class='img-rounded'  width='150' height='150'>";
 */
            $data_arr[] = array(
                "id"               => $number,
                "nama"             => $record->label,
                "action"           => $button
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
