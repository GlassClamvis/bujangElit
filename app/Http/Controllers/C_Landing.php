<?php

namespace App\Http\Controllers;

use App\Models\MBerita;
use App\Models\MBookmark;
use App\Models\MContentMenu;
use App\Models\MKategori;
use App\Models\MMedia;
use App\Models\MMediaData;
use App\Models\MMenu;
use App\Models\MSubMenu;
use App\Models\MEvaluasiPertanyaan;
use App\Models\MEvaluasiResponden;
use App\Models\MEvaluasiDetailResponden;
use App\Models\MEvaluasiPertanyaanHasJawaban;
use App\Models\MUnitHasPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; 
use Illuminate\Support\Facades\Auth;

class C_Landing extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $highlightNew  = MBerita::where('is_aktif', 3)->orderBy('created_at', 'desc')->take(1)->get();
        $highlightNews = MBerita::where('is_aktif', 3)->orderBy('created_at', 'desc')->skip(1)->take(3)->get();

        if (!count($highlightNew)) {
            $highlightNew  = MBerita::where('is_aktif', 2)->orderBy('created_at', 'desc')->take(1)->get();
            $highlightNews = MBerita::where('is_aktif', 2)->orderBy('created_at', 'desc')->skip(1)->take(3)->get();
        } elseif (count($highlightNews) < 3) {
            $kurang = 3 - count($highlightNews);
            $hln = MBerita::where('is_aktif', 2)->orderBy('created_at', 'desc')->take($kurang)->get();
            $highlightNews = $highlightNews->merge($hln);
        }

        $kategori = MKategori::withCount('berita')
            ->having('berita_count', '>', 0)
            ->orderByDesc('berita_count')
            ->take(5)
            ->get();

        $books = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '1')
            ->where('is_aktif', '=', '1')
            ->take(4)
            ->get();

        $jurnal = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '2')
            ->where('is_aktif', '=', '1')
            ->take(6)
            ->get();

        $data          = array(
            'kategori' => $kategori,
            'menu'     => 'l1',
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );


        return view('landing.index', compact('data', 'highlightNew', 'highlightNews', 'books', 'jurnal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* $path = storage_path('app/pdf/' . $id);

        if (!Storage::exists('pdf/' . $id)) {
            abort(404);
        } */
        $path   = "assets/data/book/" . $id;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $id . '"',
        ];

        return response()->file($path, $headers);
    }

    public function semuaBerita()
    {
        //dd($url);
        $news = MBerita::paginate(5);
        $kategori = MKategori::withCount('berita')
            ->having('berita_count', '>', 0)
            ->orderByDesc('berita_count')
            ->take(5)
            ->get();
        $imagePath = "img/users/avatar-men.png";
        $data = array(
            'menu'     => 'l2',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.beritaAll', compact('data', 'news'));
    }

    public function cariBerita(Request $request)
    {
        $q = $request->question;
        $news = MBerita::where('judul', 'LIKE', '%' . $q . '%')->paginate(5);
        $kategori = MKategori::withCount('berita')
            ->having('berita_count', '>', 0)
            ->orderByDesc('berita_count')
            ->take(5)
            ->get();
        $imagePath = "img/users/avatar-men.png";
        $data = array(
            'menu'     => 'l2',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.beritaAll', compact('data', 'news'));
    }

    public function berita($url)
    {
        //dd($url);
        $berita = MBerita::where('url', $url)->first();
        $news = MBerita::findOrFail($berita->id);
        $news->incrementViewer();
        /* $imagePath  =  "img/users/" . $berita->user->penggunaData->foto;
        if (!file_exists($imagePath) || $berita->user->penggunaData->foto == "") {
            $imagePath = "img/system/anonymous.jpg";
        } */
        $imagePath = "img/users/avatar-men.png";
        $data = array(
            'related' => MBerita::where('kategori_id', $berita->kategori_id)->whereNot('id', $berita->id)->take(6)->get(),
            'topnews' => MBerita::orderby('viewer', 'asc')->take(6)->get(),
            'imgUser' => $imagePath,
            'menu'    => 'l2',
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.berita', compact('data', 'berita'));
    }
    
    public function subMenu($url)
    {
        //dd($url);
        $subMenu = MSubMenu::where('url', $url)->first();
        $content = MContentMenu::where('submenu_id',$subMenu->id)->first();
        if($content){
            $subMenu = MContentMenu::findOrFail($content->id);
            $subMenu->incrementViewer();
        }

        $imagePath = "img/users/avatar-men.png";
        $data = array(
            'getMenuDetail' => MSubMenu::where('url', $url)->first(),
            'topnews' => MBerita::orderby('viewer', 'asc')->take(6)->get(),
            'imgUser' => $imagePath,
            'menu'    => 'l2',
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.content', compact('data', 'content'));
    }

    public function tentangKami()
    {
       
        $data = array(
            'menu'    => 'l2',
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.tentangKami', compact('data'));
    }

    public function semuaJurnal()
    {
        //dd($url);
        $jurnal = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '2')
            ->where('is_aktif', '=', '1')
            ->take(12)
            ->paginate();
        $kategori = MKategori::withCount('jurnal')
            ->having('jurnal_count', '>', 0)
            ->orderByDesc('jurnal_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l3',
            'header' => "Jurnal Terbaru",
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.jurnalAll', compact('data', 'jurnal'));
    }

    public function jurnalKategori($q)
    {
        $jurnal = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '2')
            ->where('is_aktif', '=', '1')
            ->whereHas('kategori', function ($query) use ($q) {
                $query->where('label', $q);
            })
            ->take(12)
            ->paginate();

        $kategori = MKategori::withCount('jurnal')
            ->having('jurnal_count', '>', 0)
            ->orderByDesc('jurnal_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l4',
            'header' => 'Kategori Jurnal ' . $q,
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.jurnalAll', compact('data', 'jurnal'));
    }

    public function jurnalDetail($url)
    {   
        $uhp="";
        if(Auth::user()->pengguna_id){
            $pengguna_id = Auth::user()->pengguna_id;
            $uhp = MUnitHasPegawai::where('pengguna_id',$pengguna_id)->first();
        }
        $jurnal = MMedia::where('url', $url)->first();
        $media = MMedia::findOrFail($jurnal->id);
        $media->incrementViewer();

        $kategori = MKategori::withCount('jurnal')
            ->having('jurnal_count', '>', 0)
            ->orderByDesc('jurnal_count')
            ->take(5)
            ->get();

        $data = array(
            'menu'     => 'l3',
            'kategori' => $kategori,
            'related' => MMedia::where('kategori_id', $jurnal->kategori_id)->whereNot('id', $jurnal->id)->take(6)->get(),
            'topnews' => MMedia::orderby('viewer', 'desc')->take(6)->get(),
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        $evaluasi = MEvaluasiPertanyaan::all();
        return view('landing.jurnalDetail', compact('data', 'jurnal','evaluasi','uhp'));
    }

    public function cariJurnal(Request $request)
    {
        $q = $request->question;
        $jurnal = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '2')
            ->where('is_aktif', '=', '1')
            ->where('judul', 'LIKE', '%' . $q . '%')
            ->take(12)
            ->paginate();

        $kategori = MKategori::withCount('jurnal')
            ->having('jurnal_count', '>', 0)
            ->orderByDesc('jurnal_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l3',
            'header' => 'Pencarian Jurnal "' . $q . '"',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.jurnalAll', compact('data', 'jurnal'));
    }

    public function semuaBuku()
    {
        //dd($url);
        $buku = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '1')
            ->where('is_aktif', '=', '1')
            ->take(12)
            ->paginate();
        $kategori = MKategori::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderByDesc('buku_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l4',
            'header' => 'Buku Terbaru',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.bukuAll', compact('data', 'buku'));
    }

    public function cariBuku(Request $request)
    {
        $q = $request->question;
        $buku = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '1')
            ->where('is_aktif', '=', '1')
            ->where('judul', 'LIKE', '%' . $q . '%')
            ->take(12)
            ->paginate();

        $kategori = MKategori::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderByDesc('buku_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l4',
            'header' => 'Pencarian "' . $q . '"',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.bukuAll', compact('data', 'buku'));
    }

    public function bukuKategori($q)
    {
        $buku = MMedia::orderBy('created_at', 'desc')
            ->where('jenis_media_id', '=', '1')
            ->where('is_aktif', '=', '1')
            ->whereHas('kategori', function ($query) use ($q) {
                $query->where('label', $q);
            })
            ->take(12)
            ->paginate();

        $kategori = MKategori::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderByDesc('buku_count')
            ->take(5)
            ->get();
        $data = array(
            'menu'     => 'l4',
            'header' => 'Kategori ' . $q,
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.bukuAll', compact('data', 'buku'));
    }

    public function bukuDetail($url)
    {
        //dd($url);
        $buku = MMedia::where('url', $url)->first();
        $media = MMedia::findOrFail($buku->id);
        $media->incrementViewer();

        $kategori = MKategori::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderByDesc('buku_count')
            ->take(4)
            ->get();

        $data = array(
            'menu'     => 'l4',
            'kategori' => $kategori,
            'related' => MMedia::where('kategori_id', $buku->kategori_id)->whereNot('id', $buku->id)->take(6)->get(),
            'topnews' => MMedia::orderby('viewer', 'desc')->take(6)->get(),
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.bukuDetail', compact('data', 'buku'));
    }

    public function bookmark()
    {
        $media = MBookmark::where('user_id', Auth::id())
            ->take(12)
            ->paginate();
        $kategori = MKategori::withCount('media')
            ->having('media_count', '>', 0)
            ->orderByDesc('media_count')
            ->take(5)
            ->get();
        $imagePath = "img/users/avatar-men.png";
        $data = array(
            'menu'     => 'l5',
            'kategori' => $kategori,
            'rc' => MBerita::whereIn('is_aktif', [2,3])->orderBy('created_at', 'desc')->skip(1)->take(2)->get(),
            'getMenu' =>MMenu::all()
        );
        return view('landing.bookmark', compact('data', 'media'));
    }

    public function bookmarkUpdate(Request $request)
    {
        $mediaId = decrypt($request->mediaId);
        if ($request->val) {
            $media = MMedia::find($mediaId);
            $msg = auth()->user()->mediaBookmark()->detach($mediaId);
        } else {
            $msg = auth()->user()->mediaBookmark()->attach($mediaId);
        }
        /* $input['media_id'] = $mediaId;
        $input['user_id'] = Auth::id();
        $Bookmark = MBookmark::create($input); */
        return $msg;
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function evaluationDownload(Request $request){
        //dd($request);
        $inputResponden['responden']      = $request->respondenName;
        $inputResponden['dinas_instansi'] = $request->dinasInstansi;
        $inputResponden['bidang']         = $request->bidang;
        $responden                        = MEvaluasiResponden::create($inputResponden);

        $pertanyaan = MEvaluasiPertanyaan::all();
        foreach($pertanyaan as $v){
            if($v->is_text){
                $getJawaban = MEvaluasiPertanyaanHasJawaban::where('pertanyaan_id',$v->id)->first();
                $inputDetailResponden['evaluasi_responden_id']              = $responden->id;
                $inputDetailResponden['evaluasi_pertanyaan_has_jawaban_id'] = $getJawaban->id;
                $inputDetailResponden['keterangan'] = $_REQUEST['pertanyaan'.$v->id];
                MEvaluasiDetailResponden::create($inputDetailResponden);
            }else{
                $inputDetailResponden['evaluasi_responden_id']              = $responden->id;
                $inputDetailResponden['evaluasi_pertanyaan_has_jawaban_id'] = $_REQUEST['pertanyaan'.$v->id];
                MEvaluasiDetailResponden::create($inputDetailResponden);
            }
        }

        $mediaData = MMediaData::find($request->fileid);
        $filePath   = public_path('assets/data/book/'.$mediaData->file);
        $filename = $mediaData->JenisMediaProperti->title;
        // Check if the file exists
        if (file_exists($filePath)) {
            // Provide headers for a downloadable file
            return Response::download($filePath, $filename, [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment',
            ]);
        } else {
            // File not found response
            abort(404, 'File not found');
        }
    }
}
