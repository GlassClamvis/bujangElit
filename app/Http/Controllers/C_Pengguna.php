<?php

namespace App\Http\Controllers;

use App\Models\MPengguna;
use App\Models\User;
use App\Models\MUnit;
use App\Models\MUnitHasPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class C_Pengguna extends Controller
{
    function __construct(){
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store','getPengguna']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function dashboard(){
        $MenuSession        = array(
            'title'         => "DASHBOARD PEGAWAI",
            'menu'          => "",
            'subMenu'       => "Dashboard",
            'lv0'           => "JTI Form",
            'link_lv0'      => route('dashboard'),
            'lv1'           => "",
            'link_lv1'      => "",
            'lv2'           => ""
        );
        return view('pegawai.dashboard',compact('data','MenuSession'));
    }


    public function index(){
        $data=array(
            "main-title" => "Pengguna",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Pengguna List"),
        );
        return view('pengguna.index',compact('data','Breadcrumb'));
    }

    public function create(){
        $data=array(
            "main-title" => "Pengguna",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('pengguna.index'), "label" => "Pengguna List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Tambah Pengguna"),
        );

        $roles = Role::pluck('name', 'name')->all();
        $unit  = MUnit::all();

        return view('pengguna.add', compact('data', 'Breadcrumb', 'roles','unit'));
    }

    public function store(Request $request){

        //dd($request->input('roles'));
        $date = Carbon::now();
        /* $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'required|string|email|max:255'|'unique:'.User::class,
            'no_hp'               => 'nullable|string|max:64',
            'password'            => 'string|confirmed|min:6',
        ]); */
        
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'foto' => ['image', 'max:2048', 'mimes:png,jpg,jpeg,svg'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $input['nama']          = $request->nama;
        $input['kode']          = $request->kode;
        $input['email']         = strtolower($request->email);
        $input['no_hp']         = $request->no_hp;
        $input['is_aktif']      = $request->is_aktif;
        $image                  = $request->foto;
        if ($image != null){
            $ext            = strtolower($image->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $image->move('img/users', $fileName);
            $input['foto']  = $fileName;
        }
        $pengguna = MPengguna::create($input);

        $inputUser['name']       = $request->nama;
        $inputUser['email']      = strtolower($request->email);
        $inputUser['is_aktif']   = 1;
        $inputUser['pengguna_id']   = $pengguna->id;
        $inputUser['password']   = Hash::make($request->password);;
        $user = User::create($inputUser);
        if (Gate::check('user-set-role')) {
            if($request->roles != null){
                $user->assignRole($request->roles);
            }else{
                $user->assignRole('User');
            }
        }

        $inputUnit['unit_id'] = $request->unit;
        $inputUnit['pengguna_id'] = $pengguna->id;
        $UHP = MUnitHasPegawai::create($inputUnit);

        return redirect(route('pengguna.index'))->with('success','Pengguna Berhasil di Simpan.');
    }


    public function show($id){
        //
    }


    public function edit($id){
        $id = Crypt::decryptString($id);
        $data=array(
            "main-title" => "Pengguna",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('pengguna.index'), "label" => "Pengguna List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Ubah Pengguna"),
        );
            $unit  = "";
            $units = MUnitHasPegawai::where('pengguna_id',$id)->first();  //*UnitSelected
        if (Gate::check('user-change-unit')) {
            $unit  = MUnit::all();
        }

        if (Gate::check('user-list-all')) {
            $pengguna           = MPengguna::find($id);
            
        } else {
            $pengguna           = MPengguna::find(Auth::user()->pengguna_id);
            
        }


        //dd($id);
        $user       = User::where('pengguna_id', '=', $id)->where('is_aktif', '=', '1')->get();
        $user_id           = $user[0]['id'];
        $roles = "";
        $userRole = "";
        $arrRole = array();
        if (Gate::check('user-set-role')) {
            $user = User::find($user[0]['id']);
            $roles      = Role::pluck('name', 'name')->all();
            $userRole   = $user->roles->pluck('name', 'name')->all();
            foreach($userRole as $r){
                $arrRole[]=$r;
            }
        }

        $cekPassword = route('cekPassword');
        $imagePath  =  "img/users/".$pengguna->foto;
        if (!file_exists($imagePath) || $pengguna->foto == "") {
            $imagePath = "img/system/anonymous.jpg";
        }
        $idEncrypt = Crypt::encryptString($id);
        return view('pengguna.edit',compact('pengguna','imagePath','data','user_id','cekPassword', 'Breadcrumb', 'roles', 'userRole','idEncrypt','arrRole','unit','units'));
    }

    public function editStaff(){
        $id = Auth::user()->pegawai_id;
        $pegawai = MPengguna::find($id);
        $data = [
            'title'    => "Sistem Informasi Laboratorium",
            'subtitle' => "Ubah Data Pegawai",
            'npage'    => 13,
            'pegawai'  => $pegawai,
        ];

        $Breadcrumb = array(
            1 => array("link" => url("staff"), "label" => "Data Pegawai"),
            2 => array("link" => url("pegawai"), "label" => "List Pegawai"),
            3 => array("link" => "active", "label" => "Ubah Pegawai"),
        );

        $user       = User::where('pegawai_id', '=', $id)->where('is_aktif', '=', '1')->get();
        $user_id           = $user[0]['id'];
        $roles = "";
        $userRole = "";
        $arrRole = array();
        if (Gate::check('set-staff-role')) {
            $user = User::find($user[0]['id']);
            $roles      = Role::pluck('name', 'name')->all();
            $userRole   = $user->roles->pluck('name', 'name')->all();
            foreach($userRole as $r){
                $arrRole[]=$r;
            }
        }

        $cekPassword = route('cekPassword');
        $imagePath  =  "img/users/".$pegawai->foto;
        if (!file_exists($imagePath) || $pegawai->foto == "") {
            $imagePath = "img/system/anonymous.jpg";
        }
        $idEncrypt = Crypt::encryptString($id);
        return view('pegawai.editStaff',compact('imagePath','data','user_id','cekPassword', 'Breadcrumb', 'roles', 'userRole','idEncrypt','arrRole'));
    }

    public function update(Request $request, $id){
        $id = Crypt::decryptString($id);
        $date = Carbon::now();
        $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'required|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]);
        $input['nama']          = $request->nama;
        $input['kode']          = $request->kode;
        $input['email']         = strtolower($request->email);
        $input['no_hp']         = $request->no_hp;
        if (Gate::check('user-set-role')) {
            $input['is_aktif']      = $request->is_aktif;
        }
        $image                  = $request->foto;
        if ($image != null){
            $ext            = strtolower($image->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $image->move('img/users', $fileName);
            $input['foto']  = $fileName;
        }
        $pengguna = MPengguna::find($id);
        $pengguna->update($input);

        $getUser        = User::where('pengguna_id','=',$id)->where('is_aktif','=','1')->get();
        $user_id        = $getUser[0]['id'];
        $user           = User::find($user_id);
        if ($request->password != null) {
            $updateUser['password']        = Hash::make($request->password);
        }
        $updateUser['name']            = $request->nama;
        $updateUser['email']           = strtolower($request->email);
        $user->update($updateUser);
        if (Gate::check('user-set-role')) {
            DB::table('model_has_roles')->where('model_id', $user_id)->delete();
            $user->assignRole($request->input('roles'));
        }

        if (Gate::check('user-change-unit')) {
            $affectedRows = MUserHasPengguna::where('pengguna_id', $id)
            ->update([
                'unit_id' => $request->unit,
            ]);
        }

        return redirect(route('pengguna.index'))->with('success','Data Pegawai Berhasil di Ubah.');
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
        $id = Crypt::decryptString($request->id);
        $pengguna = MPengguna::find($id);
        $input['is_aktif'] = 0;
        $pengguna->update($input);
        User::where('pengguna_id', '=', $id)->update(['is_aktif' => '0']);
        if($pengguna){
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

    public function getPengguna(Request $request){
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

        if (Gate::check('user-list-all')) {
            // Total records
            $totalRecords = MPengguna::select('count(*) as allcount')->where('is_aktif', '=', '1')->count();
            $totalRecordswithFilter = MPengguna::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('nama', 'like', '%' . $searchValue . '%')->count();

            // Get records, also we have included search filter as well
            $records = MPengguna::orderBy($columnName, $columnSortOrder)
                ->where('nama', 'like', '%' . $searchValue . '%')
                ->where('is_aktif', '=', '1')
                ->select('pengguna.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();
        } else {
            $totalRecords = MPengguna::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('id', $user_id)->count();
            $totalRecordswithFilter = MPengguna::select('count(*) as allcount')->where('is_aktif', '=', '1')->where('nama', 'like', '%' . $searchValue . '%')->where('id', $user_id)->count();

            $records = MPengguna::orderBy($columnName, $columnSortOrder)
                ->where('nama', 'like', '%' . $searchValue . '%')
                ->where('is_aktif', '=', '1')
                ->where('id', $user_id)
                ->select('pengguna.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
            $data_arr = array();
        }

        $number = $start;
        foreach ($records as $record) { $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button = "";
            $imgPath  =  "img/users/".$record->foto;
            if (!file_exists($imgPath) || $record->foto == "") {
                $imgPath = "img/users/avatar-men.png";
            }
            if(Gate::check('user-edit')){
                $button = $button."<a href='#' data-href='".route('pengguna.edit',$idEncrypt)."' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
            </a>";
            }
            if(Gate::check('user-delete')){
                $button = $button." <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='".$idEncrypt."' >
                Hapus
              </a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"     => $number,
                "nama"   => $record->nama,
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

    public function checkPassword(){
        $password       = $_REQUEST['password'];
        $id             = $_REQUEST['id'];
        $user           = User::find($id);
        $data           = Hash::check($password, $user->password);
        return response()->json($data);
    }
}
