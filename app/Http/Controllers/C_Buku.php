<?php

namespace App\Http\Controllers;

use App\Models\MKategori;
use App\Models\MTag;
use App\Models\MMedia;
use App\Models\MPenerbit;
use App\Models\MPengguna;
use App\Models\MTagMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class C_Buku extends Controller
{
    function __construct()
    {
        $this->middleware('permission:buku-list|buku-create|buku-edit|buku-delete', ['only' => ['index', 'store', 'getBuku']]);
        $this->middleware('permission:buku-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:buku-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:buku-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = array(
            "main-title" => "Buku",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Buku List"),
        );
        return view('buku.index', compact('data', 'Breadcrumb'));
    }

    public function create()
    {
        $data = array(
            "main-title" => "Buku",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('buku.index'), "label" => "Buku List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Tambah Buku"),
        );

        $tag      = MTag::all();
        $kategori = MKategori::all();

        return view('buku.add', compact('data', 'Breadcrumb', 'tag', 'kategori'));
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $request->validate([
            'judul'               => 'required|string|max:255',
            'deskripsi'           => 'required|string|max:500',
        ]);
        $input['jenis_media_id'] = 1;
        $input['judul']          = $request->judul;
        $input['url']            = Str::slug(strtolower($request->judul), '-');
        $input['deskripsi']      = $request->deskripsi;
        $input['isbn']           = $request->isbn;
        $input['issn_daring']    = $request->issn_daring;
        $input['issn_cetak']     = $request->issn_cetak;
        $input['kategori_id']    = $request->kategori;
        $input['user_id']        = Auth::id();
        $file_book               = $request->file_buku;
        $file_cover              = $request->file_cover;

        if ($request->has('tahun') && $request->tahun != "") {
            $input['tahun_terbit']   = "01-01-".$request->tahun;
        }

        if ($request->has('penerbit') && $request->penerbit != "") {
            $penerbit                = MPenerbit::where('label', $request->penerbit)->first();
            if (!$penerbit) {
                $penerbit = MPenerbit::create(['label' => $request->penerbit]);
            }
            $input['penerbit_id']    = $penerbit->id;
        }
        if ($file_book != null) {
            $ext            = strtolower($file_book->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $file_book->move('assets/data/book', $fileName);
            $input['file_media']  = $fileName;
        }

        if ($file_cover != null) {
            $ext            = strtolower($file_cover->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $file_cover->move('assets/data/cover', $fileName);
            $input['cover']  = $fileName;
        }
        //dd($input);
        $media = MMedia::create($input);

        if (!empty($request->tag)) {
            foreach (@$request->tag as $k) {
                $insertData    = array(
                    'media_id'    => $media->id,
                    'tag_id' => $k,
                    'user_id'     => Auth::id(),
                );
                MTagMedia::create($insertData);
            }
        }

        return redirect(route('buku.index'))->with('success', 'Buku Berhasil di Simpan.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $data = array(
            "main-title" => "Buku",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('buku.index'), "label" => "Buku List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Ubah Buku"),
        );

        $buku  = MMedia::find($id);
        $fileCover   = "assets/data/cover/" . $buku->cover;
        if (!file_exists($fileCover) || $buku->cover == "") {
            $fileCover = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Cover&font=bebas";
        }

        $fileBuku   = "assets/data/book/" . $buku->file_media;
        if (!file_exists($fileBuku) || $buku->file_media == "") {
            $fileBuku = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Buku&font=bebas";
        }
        $tag         = MTag::all();
        $kategori    = MKategori::all();
        $arrTag      = array();
        $getTagMedia = MTagMedia::where('media_id', $id)->get();
        //dd($getTagMedia);
        foreach ($getTagMedia as $k) {
            $arrTag[] = $k->tag_id;
        }
        //dd($arrTag);
        $idEncrypt = Crypt::encryptString($id);
        return view('buku.edit', compact('buku', 'fileBuku', 'fileCover', 'data', 'Breadcrumb', 'idEncrypt', 'tag', 'arrTag', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $id   = Crypt::decryptString($id);
        $date = Carbon::now();

        /*  $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'required|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]);*/
        $input['judul']          = $request->judul;
        $input['url']            = Str::slug(strtolower($request->judul), '-');
        $input['deskripsi']      = $request->deskripsi;
        $input['isbn']           = $request->isbn;
        $input['issn_daring']    = $request->issn_daring;
        $input['issn_cetak']     = $request->issn_cetak;
        $input['tahun_terbit']   = "01-01-$request->tahun";
        $input['kategori_id']    = $request->kategori;
        $file_book               = $request->file_buku;
        $file_cover              = $request->file_cover;

        if ($request->has('tahun') && $request->tahun != "") {
            $input['tahun_terbit']   = "01-01-$request->tahun";
        }

        if ($request->has('penerbit') && $request->penerbit != "") {
            $penerbit                = MPenerbit::where('label', $request->penerbit)->first();
            if (!$penerbit) {
                $penerbit = MPenerbit::create(['label' => $request->penerbit]);
            }
            $input['penerbit_id']    = $penerbit->id;
        }
        if ($file_book != null) {
            $ext             = strtolower($file_book->getClientOriginalExtension());
            $fileName        = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload          = $file_book->move('assets/data/book', $fileName);
            $input['file_media'] = $fileName;
        }

        if ($file_cover != null) {
            $ext            = strtolower($file_cover->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $file_cover->move('assets/data/cover', $fileName);
            $input['cover'] = $fileName;
        }
        //dd($input);
        $buku = MMedia::find($id);
        $buku->update($input);

        if ($request->has('tag')) {
            //dd($request->tag);

            $_tag = MTagMedia::where('media_id', $id)->get();
            if (count($_tag)) {
                $Old_tag = array();
                foreach ($_tag as $km) {
                    $Old_tag[] = $km['tag_id'];
                }
                //dd($Old_tag);
                foreach ($Old_tag as $k) {
                    if (!in_array($k, $request->tag)) {
                        MTagMedia::where('media_id', $id)->where('tag_id', $k)->delete();
                    }
                }

                foreach (@$request->tag as $k) {
                    if (!in_array(@$k, $Old_tag)) {
                        $insertData    = array(
                            'media_id'    => $id,
                            'tag_id' => $k,
                            'user_id'     => Auth::id(),
                        );
                        MTagMedia::create($insertData);
                    }
                }
            } else {
                foreach (@$request->tag as $k) {
                    $insertData    = array(
                        'media_id'    => $id,
                        'tag_id' => $k,
                        'user_id'     => Auth::id(),
                    );
                    MTagMedia::create($insertData);
                }
            }
        }
        return redirect(route('buku.index'))->with('success', 'Data Buku Berhasil di Ubah.');
    }

    public function destroy(Request $request)
    {
        //dd($request);
        $buku = MMedia::find($id = Crypt::decryptString($request->id));
        $input['is_aktif'] = 0;
        $buku->update($input);
        return redirect()->route('buku.index')
            ->with('success', 'Data Penerbit Deleted Successfully');
    }

    public function getBuku(Request $request)
    {
        $user_id = Auth::user()->pengguna_id;
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        //$columnName = $columnName_arr[$columnIndex]['data']; // Column name
        //$columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $columnName = 'id';
        $columnSortOrder = 'desc'; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = MMedia::select('count(*) as allcount')->where('jenis_media_id', '=', '1')->where('is_aktif', '=', '1')->count();
        $totalRecordswithFilter = MMedia::select('count(*) as allcount')->where('jenis_media_id', '=', '1')->where('is_aktif', '=', '1')->where('judul', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MMedia::orderBy($columnName, $columnSortOrder)
            ->where('judul', 'like', '%' . $searchValue . '%')
            ->where('jenis_media_id', '=', '1')
            ->where('is_aktif', '=', '1')
            ->select('media.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        //dd($records);
        $number = $start;
        foreach ($records as $record) {
            $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button    = "";
            $imgPath   = "assets/data/cover/" . $record->cover;
            //dd($imgPath);
            if (!file_exists($imgPath) || $record->cover == "") {
                $imgPath = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Cover&font=bebas";
            }
            if (Gate::check('buku-edit')) {
                $button = $button . "<a href='#' data-href='" . route('buku.edit', $idEncrypt) . "' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
            </a>";
            }
            if (Gate::check('buku-delete')) {
                $button = $button . " <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='" . $idEncrypt . "' data-label='$record->judul' >
                Hapus
              </a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"       => $number,
                "judul"    => $record->judul,
                "penerbit" => @$record->penerbitData->label . ", " . $record->TahunBuku,
                "cover"    => $foto,
                "action"   => $button
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
}
