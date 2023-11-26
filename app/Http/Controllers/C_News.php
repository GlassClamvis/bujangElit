<?php

namespace App\Http\Controllers;

use App\Models\MBerita;
use App\Models\MKategori;
use App\Models\MTagBerita;
use App\Models\MMedia;
use App\Models\MPenerbit;
use App\Models\MPengguna;
use App\Models\MTag;
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

class C_News extends Controller
{
    /*   function __construct(){
         $this->middleware('permission:buku-list|buku-create|buku-edit|buku-delete', ['only' => ['index','store','getBuku']]);
         $this->middleware('permission:buku-create', ['only' => ['create','store']]);
         $this->middleware('permission:buku-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:buku-delete', ['only' => ['destroy']]);
    } */

    public function index()
    {
        $data = array(
            "main-title" => "Berita",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Berita List"),
        );
        return view('berita.index', compact('data', 'Breadcrumb'));
    }

    public function create()
    {
        $data = array(
            "main-title" => "Berita",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('berita.index'), "label" => "Berita List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Tambah Berita"),
        );

        //$tag      = MTag::all();
        $tag      = "";
        $kategori = MKategori::all();

        return view('berita.add', compact('data', 'Breadcrumb', 'tag', 'kategori'));
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $this->validate($request, [
            'judul' => 'required',
            'berita' => 'required'
        ]);

        $content = $request->berita;
        $dom = new \DomDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('imageFile');

        foreach ($imageFile as $item => $image) {
            $data              = $image->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $imgeData          = base64_decode($data);
            $image_name        = "/" . time() . $item . '.png';
            $path              = public_path() . $image_name;

            file_put_contents($path, $imgeData);
            $upload         = $item->move('assets/data/uc', $imgeData);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
        }

        $file_cover              = $request->file_cover;
        if ($file_cover != null) {
            $ext            = strtolower($file_cover->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $file_cover->move('assets/data/cover', $fileName);
            $news['cover']  = $fileName;
        }

        $content             = $dom->saveHTML();
        $news['judul']       = $request->judul;
        $url                 = $this->replace_symbols($request->judul);
        $news['url']         = strtolower($url);
        $news['content']     = $content;
        $news['is_aktif']    = $request->is_aktif;
        $news['read_time']   = $request->read_time;
        $news['user_id']     = Auth::id();
        $news['kategori_id'] = $request->kategori;
        $berita              = MBerita::create($news);

       /*  if (!empty($request->tag)) {
            foreach (@$request->tag as $k) {
                $insertData    = array(
                    'berita_id' => $berita->id,
                    'tag_id'    => $k,
                    'user_id'   => Auth::id(),
                );
                MTagBerita::create($insertData);
            }
        }
 */
        return redirect(route('berita.index'))->with('success', 'Data Berita Berhasil di Ubah.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id   = Crypt::decryptString($id);
        $data = array(
            "main-title" => "Berita",
            "nm"         => 0,          //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('berita.index'), "label" => "Berita List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Ubah Berita"),
        );

        $berita    = MBerita::find($id);
        $fileCover = "assets/data/cover/" . $berita->cover;
        if (!file_exists($fileCover) || $berita->cover == "") {
            $fileCover = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=Cover+Berita&font=bebas";
        }

        $arrTag       = array();
       /*  $getTagBerita = MTagBerita::where('berita_id', $id)->get();
        //dd($getKategoriMedia);
        foreach ($getTagBerita as $k) {
            $arrTag[] = $k->tag_id;
        } */
        $idEncrypt = Crypt::encryptString($id);
        //$tag       = MTag::all();
        $tag       = "";
        $kategori  = MKategori::all();
        return view('berita.edit', compact('berita', 'fileCover', 'data', 'Breadcrumb', 'idEncrypt', 'arrTag', 'tag', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $id   = Crypt::decryptString($id);
        $date = Carbon::now();

        $date = Carbon::now();
        $this->validate($request, [
            'judul' => 'required',
            'berita' => 'required'
        ]);

        $content = $request->berita;
        $dom     = new \DomDocument();
        @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('imageFile');

        foreach ($imageFile as $item => $image) {
            $data              = $image->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $imgeData          = base64_decode($data);
            $image_name        = "/" . time() . $item . '.png';
            $path              = public_path() . $image_name;

            file_put_contents($path, $imgeData);
            $upload         = $item->move('assets/data/uc', $imgeData);

            $image->removeAttribute('src');
            $image->setAttribute('src', $image_name);
        }


        $content    = $dom->saveHTML();
        $file_cover = $request->file_cover;

        if ($file_cover != null) {
            $ext            = strtolower($file_cover->getClientOriginalExtension());
            $fileName       = Str::random(8) . $date->format('YmdHis') . "." . $ext;
            $upload         = $file_cover->move('assets/data/cover', $fileName);
            $news['cover']  = $fileName;
        }

        $content             = $dom->saveHTML();
        $news['judul']       = $request->judul;
        $url                 = $this->replace_symbols($request->judul);
        $news['url']         = strtolower($url);
        $news['content']     = $content;
        $news['is_aktif']    = $request->is_aktif;
        $news['read_time']   = $request->read_time;
        $news['kategori_id'] = $request->kategori;
        $news['user_id']     = Auth::id();
        $berita              = MBerita::find($id)->update($news);

        /* if ($request->has('tag')) {
            $_tag = MTagBerita::where('berita_id', $id)->get();
            if (count($_tag)) {
                $Old_tag = array();

                foreach ($_tag as $km) {
                    $Old_tag[] = $km['tag_id'];
                }

                foreach ($Old_tag as $k) {
                    if (!in_array($k, $request->tag)) {
                        MTagBerita::where('berita_id', $id)->where('tag_id', $k)->delete();
                    }
                }

                foreach (@$request->tag as $k) {
                    if (!in_array(@$k, $Old_tag)) {
                        $insertData    = array(
                            'berita_id' => $id,
                            'tag_id'    => $k,
                            'user_id'   => Auth::id(),
                        );
                        MTagBerita::create($insertData);
                    }
                }
            } else {
                foreach (@$request->tag as $k) {
                    $insertData    = array(
                        'berita_id'    => $id,
                        'tag_id' => $k,
                        'user_id'     => Auth::id(),
                    );
                    MTagBerita::create($insertData);
                }
            }
        } */

        return redirect(route('berita.index'))->with('success', 'Data Berita Berhasil di Ubah.');
    }


    public function destroy(Request $request)
    {
        //dd($request);
        $berita = MBerita::find($id = Crypt::decryptString($request->id));
        $input['is_aktif'] = 0;
        $berita->update($input);
        return redirect()->route('berita.index')
            ->with('success', 'Data Berita Deleted Successfully');
    }

    public function getBerita(Request $request)
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
        $totalRecords = MBerita::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MBerita::select('count(*) as allcount')->where('judul', 'like', '%' . $searchValue . '%')->where('is_aktif', '!=', '0')->count();

        // Get records, also we have included search filter as well
        $records = MBerita::orderBy($columnName, $columnSortOrder)
            ->select('berita.*')
            ->where('judul', 'like', '%' . $searchValue . '%')
            ->where('is_aktif', '!=', '0')
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
                $imgPath = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=Cover+Berita&font=bebas";
            }
            if (Gate::check('berita-edit')) {
                $button = $button . "<a href='#' data-href='" . route('berita.edit', $idEncrypt) . "' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
            </a>";
            }
            if (Gate::check('berita-delete')) {
                $button = $button . " <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='" . $idEncrypt . "' data-label='$record->judul' >
                Hapus
              </a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"       => $number,
                "judul"    => $record->judul,
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

    public function uploadImage(Request $request)
    {
        $date      = Carbon::now();
        $file_book = $request->imageData;
        $ext       = strtolower($file_book->getClientOriginalExtension());
        $fileName  = Str::random(8) . $date->format('YmdHis') . "." . $ext;
        $upload    = $file_book->move('assets/data/uc', $fileName);
        $imgPath   = "assets/data/uc/" . $fileName;

        // Validate and store the image on the server
        //$imagePath = $request->file('imageData')->store('uploads', 'public');

        // Generate the URL for the uploaded image
        //$imageUrl = asset('storage/' . $imagePath);

        // Return the image URL as a response
        return response()->json(['imageUrl' => $imgPath]);
    }

    function replace_symbols(string $text)
    {
        // The `str_replace()` function takes three arguments:
        //   - The characters or string you want to replace.
        //   - The characters or string to replace the existing characters.
        //   - The string to search for the characters.
        $symbols = [" ", ",", ".", ";", "'", "\"", "`", "~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=", "|", "{", "}", ":", ";", "<", ">", "?", "/"];

        $new_text = str_replace($symbols, "-", $text);

        return $new_text;
    }
}
