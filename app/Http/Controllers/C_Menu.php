<?php

namespace App\Http\Controllers;

use App\Models\MPengguna;
use App\Models\MMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class C_Menu extends Controller
{
    function __construct(){
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index','store','getMenu']]);
        $this->middleware('permission:menu-create', ['only' => ['create','store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }

    public function index(){

        $data = array(
            "main-title" => "Menu",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Menu List"),
        );

        return view('menu.index',compact('data','Breadcrumb'));
    }

    public function create(){ }

    public function store(Request $request){
        $request->validate([
            'menu'                => 'required|string|max:32',
        ]);
        $input['title']    = $request->menu;
        $input['url']     = $request->url;
        $input['user_id'] = Auth::user()->id;
        $menu          = MMenu::create($input);
        
        return redirect(route('menu.index'))->with('success','Data Menu Berhasil di Simpan.');
    }
    
    public function show($id){ }

    public function edit($id){ }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $request->validate([
            'menu'                => 'required|string|max:32',
        ]);
        $input['title'] = $request->menu;
        $input['url']   = $request->url;
        $menu           = MMenu::find($id);
        $menu->update($input);
      
        return redirect(route('menu.index'))->with('success','Data Menu Berhasil di Ubah.');
    }

    public function destroy(Request $request){
        MMenu::find(Crypt::decryptString($request->id))->delete();
        return redirect()->route('menu.index')->with('success','Menu deleted successfully');
    }

    public function getMenu(Request $request){
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
        $totalRecords = MMenu::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MMenu::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MMenu::orderBy($columnName, $columnSortOrder)
            ->where('title', 'like', '%' . $searchValue . '%')
            ->select('menu.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
           
            $button = "";
            if(Gate::check('menu-edit')){
                $button = $button."<a href='#' data-href='".route('menu.edit',$record->id)."' data-update='".route('menu.update',$idEncrypt)."'  data-url='".$record->url."' data-title='".$record->title."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                <i class='ri-edit-2-line'></i></a>";
            }

            if(Gate::check('menu-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                <i class='ri-delete-bin-2-line'></i></a>";
            }

            if($record->url =="#"){
                $button = $button." <a href='#'  class='btn btn-primary btn-outline btn-circle btn-md m-r-5 btnDetailClass' data-menu='".$record->title."' data-kode='".$record->kode."' data-val='".$idEncrypt."'>
                <i class='ri-file-list-line'></i></a>";
            }

            $data_arr[] = array(
                "id"     => $number,
                "url"    => $record->url,
                "title"  => $record->title,
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
