<?php

namespace App\Http\Controllers;

use App\Models\M_Nusantara;
use App\Models\MPenerbit;
use App\Models\MPengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class C_Penerbit extends Controller
{
    function __construct(){
         $this->middleware('permission:penerbit-list|penerbit-create|penerbit-edit|penerbit-delete', ['only' => ['index','store','getPenerbit']]);
         $this->middleware('permission:penerbit-create', ['only' => ['create','store']]);
         $this->middleware('permission:penerbit-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penerbit-delete', ['only' => ['destroy']]);
    }

     public function index(){
        $data=array(
            "main-title" => "Penerbit",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Penerbit List"),
        );
        return view('penerbit.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $data=array(
            "main-title" => "Penerbit",
            "nm" => 0, //number-menu
            /* "provinsi" => M_Nusantara::whereRaw('char_length(kode)=2')->orderBy('kode')->get(), */
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('penerbit.index'), "label" => "Penerbit List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Tambah Penerbit"),
        );

        $roles = Role::pluck('name', 'name')->all();

        return view('penerbit.add', compact('data', 'Breadcrumb', 'roles'));
    }

    public function store(Request $request){
        $date = Carbon::now();
    /*     $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'nullable|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]); */
        $input['label']         = $request->nama;
        $input['alamat']        = $request->alamat;
        $input['email']         = strtolower($request->email);
        $input['nomor_telepon'] = $request->no_hp;
        $input['is_aktif']      = $request->is_aktif;
        $image                  = $request->foto;
        if ($image != null){
            $ext            = strtolower($image->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $image->move('img/logo', $fileName);
            $input['logo']  = $fileName;
        }
        $penerbit = MPenerbit::create($input);

        return redirect(route('penerbit.index'))->with('success','Penerbit Berhasil di Simpan.');
    }


    public function show($id){
        //
    }


    public function edit($id){
        $id = Crypt::decryptString($id);
        $data=array(
            "main-title" => "Penerbit",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('penerbit.index'), "label" => "Penerbit List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Ubah Penerbit"),
        );

        $penerbit  = MPenerbit::find($id);
        $imagePath = "img/logo/".$penerbit->logo;
        if (!file_exists($imagePath) || $penerbit->logo == "") {
            $imagePath = "img/logo/logo-placeholder.png";
        }
        $idEncrypt = Crypt::encryptString($id);
        return view('penerbit.edit',compact('penerbit','imagePath','data','Breadcrumb','idEncrypt'));
    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $date = Carbon::now();
       /*  $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'required|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]); */
        $input['label']         = $request->nama;
        $input['alamat']        = $request->alamat;
        $input['email']         = strtolower($request->email);
        $input['nomor_telepon'] = $request->no_hp;
        $input['is_aktif']      = $request->is_aktif;
        $image                  = $request->foto;
        if ($image != null){
            $ext            = strtolower($image->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $image->move('img/logo', $fileName);
            $input['logo']  = $fileName;
        }
        $penerbit = MPenerbit::find($id);
        $penerbit->update($input);

        return redirect(route('penerbit.index'))->with('success','Data Penerbit Berhasil di Ubah.');
    }

    public function updateStaff(Request $request, $id){
        $id = Crypt::decryptString($id);
        $date = Carbon::now();
        $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'required|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]);
        $input['nama']                     = $request->nama;
        $input['nip']                     = $request->nip;
        $input['nik']                     = $request->nik;
        $input['email']                    = strtolower($request->email);
        $input['no_hp']                    = $request->no_hp;
        $input['tm_status_kepegawaian_id'] = $request->tm_status_kepegawaian_id;
        $input['tm_jabfung_id'] = $request->jabfung;
        $input['tm_bidang_ilmu_id'] = $request->bilmu;
        $input['angka_kredit'] = $request->angka_kredit;
        $input['is_new'] = 0;

        $image                  = $request->foto;
        if ($image != null){
            $ext            = strtolower($image->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $image->move('img/users', $fileName);
            $input['foto']  = $fileName;
        }
        $pegawai = MPengguna::find($id);
        $pegawai->update($input);

        $getUser        = User::where('pegawai_id','=',$id)->where('is_aktif','=','1')->get();
        $user_id        = $getUser[0]['id'];
        $user           = User::find($user_id);
        if ($request->password != null) {
            $updateUser['password']        = Hash::make($request->password);
        }
        $updateUser['name']            = $request->nama;
        $updateUser['email']           = strtolower($request->email);
        $user->update($updateUser);
        if (Gate::check('set-staff-role')) {
            $input['is_aktif']      = $request->is_aktif;
            DB::table('model_has_roles')->where('model_id', $user_id)->delete();
            $user->assignRole($request->input('roles'));
        }

        return redirect(route('welcome'));
    }

    public function destroy(Request $request){
        //dd($request);
        $penerbit = MPenerbit::find($id = Crypt::decryptString($request->id));
        $input['is_aktif'] = 0;
        $penerbit->update($input);
        return redirect()->route('penerbit.index')
                        ->with('success','Data Penerbit Deleted Successfully');
    }

    public function getPenerbit(Request $request){
        $user_id = Auth::user()->pengguna_id;
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
            $totalRecords = MPenerbit::select('count(*) as allcount')->where('is_aktif', '=', '1')->count();
            $totalRecordswithFilter = MPenerbit::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('label', 'like', '%' . $searchValue . '%')->count();

            // Get records, also we have included search filter as well
            $records = MPenerbit::orderBy($columnName, $columnSortOrder)
                ->where('label', 'like', '%' . $searchValue . '%')
                ->where('is_aktif', '=', '1')
                ->select('penerbit.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();

        //dd($records);
        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            $imgPath  =  "img/logo/".$record->logo;
            //dd($imgPath);
            if (!file_exists($imgPath) || $record->logo == "") {
                $imgPath = "img/logo/logo-placeholder.png";
            }
            if(Gate::check('penerbit-edit')){
                $button = $button."<a href='#' data-href='".route('penerbit.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
            </a>";
            }
            if(Gate::check('penerbit-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Hapus
              </a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"     => $number,
                "nama"   => $record->label,
                "email"  => $record->email,
                "foto"   => $foto,
                "action" => $button
            );
        }

        $response = array(
            "draw"                 => intval($draw),
            "iTotalRecords"        => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData"               => $data_arr,
        );
        echo json_encode($response);
    }

    public function getPenerbitAutoCompl(Request $request){
        $penerbit  = MPenerbit::where('label','like','%'.$request->term.'%')->get();
        $publisher = array();
        foreach($penerbit as $p){
            $id          = $p['id'];
            $val         = $p['label'];
            $publisher[] = array(
                'value' => $val,
                'data'   => $id,
            );
        }

        return json_encode(array('suggestions'=>$publisher));
    }
}
