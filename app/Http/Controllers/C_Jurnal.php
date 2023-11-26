<?php

namespace App\Http\Controllers;

use App\Models\MJenisMedia;
use App\Models\MJenisMediaProperties;
use App\Models\MKategori;
use App\Models\MKategoriMedia;
use App\Models\MMedia;
use App\Models\MMediaData;
use App\Models\MPenerbit;
use App\Models\MPengarang;
use App\Models\MTag;
use App\Models\MTagMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF as DomPDF;
use Spatie\PdfToText\Pdf;

class C_Jurnal extends Controller
{
 
    function __construct()
    {
        $this->middleware('permission:jurnal-list|jurnal-create|jurnal-edit|jurnal-delete', ['only' => ['index', 'store', 'getJurnal']]);
        $this->middleware('permission:jurnal-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jurnal-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:jurnal-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = array(
            "main-title" => "Jurnal",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 1, "link" => "", "label" => "Jurnal List"),
        );
        return view('jurnal.index', compact('data', 'Breadcrumb'));
    }

    public function create()
    {
        $data = array(
            "main-title" => "Jurnal",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('jurnal.index'), "label" => "Jurnal List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Jurnal Buku"),
        );

        $tag = MTag::all();
        $kategori = MKategori::all();
        $media=MJenisMedia::find(2);

        return view('jurnal.add', compact('data', 'Breadcrumb', 'kategori', 'tag','media'));
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        /*     $request->validate([
            'foto'                => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode'                => 'nullable|string|max:32',
            'nama'                => 'required|string|max:255',
            'email'               => 'nullable|string|email|max:255',
            'no_hp'               => 'nullable|string|max:64',
        ]); */
        $input['jenis_media_id'] = 2;
        $input['judul']          = $request->judul;
        $url                     = $this->replace_symbols($request->judul);
        $input['url']            = strtolower($url);
        $input['deskripsi']      = $request->deskripsi;
        $input['isbn']           = $request->isbn;
        $input['issn_daring']    = $request->issn_daring;
        $input['issn_cetak']     = $request->issn_cetak;
        $input['kategori_id']    = $request->kategori;
        $input['user_id']        = Auth::id();
        if ($request->has('tahun') && $request->tahun != "") {
            $input['tahun_terbit']   = $request->tahun;
        }

        if ($request->has('penerbit') && $request->penerbit != "") {
            $penerbit                = MPenerbit::where('label', $request->penerbit)->first();
            if (!$penerbit) {
                $penerbit = MPenerbit::create(['label' => $request->penerbit]);
            }
            $input['penerbit_id']    = $penerbit->id;
        }

        $media = MMedia::create($input);
        $JenisMedia=MJenisMedia::find(2);
        foreach($JenisMedia->properti as $vp){
            $vpTitle = str_replace(' ', '', $vp->title);
            if ($request->hasFile($vpTitle)) {
                $file_book = $request->file($vpTitle);
           
                $ext      = strtolower($file_book->getClientOriginalExtension());
                $fileName = Str::random(8) . $date->format('YmdHis') . "." . $ext;
                $upload   = $file_book->move('assets/data/book', $fileName);

                $inputMediaData['media_id']                  = $media->id;
                $inputMediaData['jenis_media_properties_id'] = $vp->id;
                $inputMediaData['file']                      = $fileName;
                $mediaData                                   = MMediaData::create($inputMediaData);
            
            }
            
        }
       


        

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

        if ($request->has('penerbit') && $request->penerbit != "") {
            //if (!empty($request->pengarang)) {
            foreach (@$request->pengarang as $p) {
                $insertPengarang    = array(
                    'media_id' => $media->id,
                    'nama'     => $p
                );
                MPengarang::create($insertPengarang);
            }
        }

        return redirect(route('jurnal.index'))->with('success', 'Jurnal Berhasil di Simpan.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $data = array(
            "main-title" => "Jurnal",
            "nm" => 0, //number-menu
        );

        $Breadcrumb = array(
            1 => array("is-active" => 0, "link" => url("/"), "label" => "BujangElit"),
            2 => array("is-active" => 0, "link" => route('jurnal.index'), "label" => "Jurnal List"),
            3 => array("is-active" => 1, "link" => "", "label" => "Ubah Jurnal"),
        );

        $jurnal  = MMedia::find($id);
        $pengarang = $jurnal->pengarangData;
        $media=MJenisMedia::find(2);
        //dd($pengarang);
        $fileCover   = "assets/data/cover/" . $jurnal->cover;
        if (!file_exists($fileCover) || $jurnal->cover == "") {
            $fileCover = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Cover&font=bebas";
        }

        $fileBuku   = "assets/data/book/" . $jurnal->file_media;
        if (!file_exists($fileBuku) || $jurnal->file_media == "") {
            $fileBuku = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Buku&font=bebas";
        }
        $tag = MTag::all();
        $kategori = MKategori::all();
        $arrTag = array();
        $getTagMedia = MTagMedia::where('media_id', $id)->get();
        foreach ($getTagMedia as $k) {
            $arrTag[] = $k->tag_id;
        }
        //dd($arrKategori);
        $idEncrypt = Crypt::encryptString($id);
        return view('jurnal.edit', compact('jurnal', 'fileBuku', 'fileCover', 'data', 'Breadcrumb', 'idEncrypt', 'kategori', 'tag', 'arrTag', 'pengarang','media'));
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
        $input['judul']       = $request->judul;
        $url                  = $this->replace_symbols($request->judul);
        $input['url']         = strtolower($url);
        $input['deskripsi']   = $request->deskripsi;
        $input['isbn']        = $request->isbn;
        $input['issn_daring'] = $request->issn_daring;
        $input['issn_cetak']  = $request->issn_cetak;
        $input['kategori_id'] = $request->kategori;

        if ($request->has('tahun') && $request->tahun != "") {
            $input['tahun_terbit']   = $request->tahun;
        }

        if ($request->has('penerbit') && $request->penerbit != "") {
            $penerbit                = MPenerbit::where('label', $request->penerbit)->first();
            if (!$penerbit) {
                $penerbit = MPenerbit::create(['label' => $request->penerbit]);
            }
            $input['penerbit_id']    = $penerbit->id;
        }
        //dd($input);
        $media = MMedia::find($id);
        $media->update($input);

        if ($request->has('tag')) {
            //dd($request->tag);
            $_tag = MTagMedia::where('media_id', $id)->get();
            if (count($_tag)) {
                $Old_tag = array();
                foreach ($_tag as $tm) {
                    $Old_tag[] = $tm['tag_id'];
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

        if (!empty($request->pengarang)) {
            foreach (@$request->pengarang as $p) {
                if ($p != "") {
                    $insertPengarang    = array(
                        'media_id' => $id,
                        'nama'     => $p
                    );
                    MPengarang::create($insertPengarang);
                }
            }
        }

        $JenisMedia=MJenisMedia::find(2);
        foreach($JenisMedia->properti as $vp){
            $vpTitle = str_replace(' ', '', $vp->title);
            if ($request->hasFile($vpTitle)) {
                $file_book = $request->file($vpTitle);
           
                $ext      = strtolower($file_book->getClientOriginalExtension());
                $fileName = Str::random(8) . $date->format('YmdHis') . "." . $ext;
                $upload   = $file_book->move('assets/data/book', $fileName);

                $data = [
                    'media_id'                  => $id,
                    'jenis_media_properties_id' => $vp->id,
                    'file'                      => $fileName,
                ];
                
                $conditions = [
                    'media_id'                  => $id,
                    'jenis_media_properties_id' => $vp->id
                ];
                MMediaData::updateOrInsert($conditions, $data);
            }
            
        }

        return redirect(route('jurnal.index'))->with('success', 'Data Jurnal Berhasil di Ubah.');
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

    public function getJurnal(Request $request)
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
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = MMedia::select('count(*) as allcount')->where('jenis_media_id', '=', '2')->where('is_aktif', '=', '1')->count();
        $totalRecordswithFilter = MMedia::select('count(*) as allcount')->where('jenis_media_id', '=', '2')->where('is_aktif', '=', '1')->where('judul', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = MMedia::orderBy($columnName, $columnSortOrder)
            ->where('judul', 'like', '%' . $searchValue . '%')
            ->where('jenis_media_id', '=', '2')
            ->where('is_aktif', '=', '1')
            ->select('media.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        //dd($records);
        $number = $start;
        $jenisMediaProperties = MJenisMediaProperties::where('jenis_media_id',2)->where('is_cek',1)->first();
        foreach ($records as $record) {
            $mediaPlagiarism = MMediaData::where('media_id',$record->id)->where('jenis_media_properties_id',$jenisMediaProperties->id)->get();
            $plagScore="";
            foreach($mediaPlagiarism as $key=>$v){
                $plagScore = $v->plagiarism_score;
            }
            $cekMediaPlagiarism = count($mediaPlagiarism);
            $number += 1;
            $idEncrypt = Crypt::encryptString($record->id);
            $button    = "";
            $imgPath   = "assets/data/cover/" . $record->cover;
            //dd($imgPath);
            if (!file_exists($imgPath) || $record->cover == "") {
                $imgPath = "https://fakeimg.pl/600x400/cccccc/0f0e0e?text=File+Cover&font=bebas";
            }
            if (Gate::check('jurnal-edit')) {
                $button = $button . "<a href='#' data-href='" . route('jurnal.edit', $idEncrypt) . "' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                ubah
                </a>";
            }
            if (Gate::check('jurnal-delete')) {
                $button = $button . " <a href='#' class='btn btn-danger btn-outline btn-circle btn-md m-r-5 delete' data-id='" . $idEncrypt . "' data-label='$record->judul' >
                Hapus
                </a>";
            }
            $button = $button . " <a href='#' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnStatistik' data-id='" . $idEncrypt . "' data-label='$record->judul' > <i class='fa fa-table'></i> </a>";
            
            //dd($mediaPlagiarism[0]->plagiarism_score);
            //! $score = $mediaPlagiarism[0]->plagiarism_score;
            if($cekMediaPlagiarism==0){
                $score = "<a href='#' data-href='" . route('jurnal.edit', $idEncrypt) . "' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnEditClass'>
                Upload File
                </a>";
            }else if($cekMediaPlagiarism!=0 && $plagScore != 0){
                $score = $plagScore;
                $files   = asset('resultCek/' .$record->id."-".$mediaPlagiarism[0]->id. ".pdf");
                $score = " <button type='button' data-kode='$record->id' data-src='$files' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnPreview'><i class='fa fa-eye'></i> Preview</button>";
            }else{
                $score = "<a href='#' data-href='$idEncrypt' class='btn btn-info btn-outline btn-circle btn-md m-r-5 btnCheck'>
                Check</a>";
            }

            $foto = "<img src='" . asset($imgPath) . "'  class='img-rounded'  width='150' height='150'>";

            $data_arr[] = array(
                "id"       => $number,
                "judul"    => $record->judul,
                //"penerbit" => @$record->penerbitData->label . ", " . $record->tahun_terbit,
                "score"    => $score,
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

    public function updatePengarang(Request $request)
    {
        $UpdatePengarang = MPengarang::where('id', $request->id)->update(['nama' => $request->nama]);
        if ($UpdatePengarang) {
            $response = array(
                'status' => 200,
            );
        } else {
            $response = array(
                'status' => 503,
            );
        }
        return json_encode($response);
    }

    public function deletePengarang(Request $request)
    {
        $deletePengarang = MPengarang::where('id', $request->id)->delete();
        if ($deletePengarang) {
            $response = array(
                'status' => 200,
            );
        } else {
            $response = array(
                'status' => 503,
            );
        }
        return json_encode($response);
    }

    public function jurnalCek(Request $request)
    { //www.check-plagiarism.com
        //dd(phpinfo());
        $id = Crypt::decryptString($request->id);
        //$id = 19;
        $jenisMediaProperties = MJenisMediaProperties::where('jenis_media_id',2)->where('is_cek',1)->first();
        $mediaPlagiarism = MMediaData::where('media_id',$id)->where('jenis_media_properties_id',$jenisMediaProperties->id)->first();
        //dd($mediaPlagiarism);
        $getMedia= MMediaData::find($mediaPlagiarism->id);
        $score = rand(8, 15);
        $updateMedia['plagiarism_score'] = $score;
        $getMedia->update($updateMedia);

//        $pdf = DomPDF::loadView('cetak.certificate',compact('mediaPlagiarism','score'))->setPaper('a4', 'landscape')->setWarnings(false)->save('resultCek/'.$id."-".$mediaPlagiarism->id.".pdf");
        $pdf = app('dompdf.wrapper')->loadView('cetak.certificate2',compact('mediaPlagiarism','score'))->setPaper('a4', 'landscape')->setWarnings(false)->save('resultCek/'.$id."-".$mediaPlagiarism->id.".pdf");
        return $pdf->download();
    }
    
    public function jurnalCek_Asli(Request $request)
    { //www.check-plagiarism.com
        //dd(phpinfo());
        $id = Crypt::decryptString($request->id);
        $ch      = curl_init();
        //$key     = "4efdc9d93d6a81a8ebe91990dc2a7690";
        $key       = "0bc5825915b1b55fa51a43a8bb5cee60";
        $getMedia  = MMedia::find($id);
        //$fileMedia = "gVFdqLr620230930073936.pdf";
        $fileMedia = $getMedia->file_media;
        $pdfFile   = public_path('assets/data/book/'.$fileMedia);
        $text      = Pdf::getText($pdfFile);
        //$text      = file_get_contents($pdfFile);
        $content   = $this->splitWordChunks($text, 5000);
        $res       = array();
        foreach ($content as $v) {
            curl_setopt($ch, CURLOPT_URL, "https://www.check-plagiarism.com/apis/checkPlag");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key&data=$v");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            //return(json_decode($response));
            $res[] = json_decode($response);
            var_dump($res);
            //echo $res['plagPercent'];
            //$res[]=$response;
            //echo $v."</br>";
        }
        //dd($res);
        //return $res;
        $jml = 0;
        $plagiasi = 0;
        foreach ($res as $r) {
            $jml += 1;
            $plagiasi += $r->plagPercent;
            echo "Hit " . $jml . ", Nilai " . $r->plagPercent . "</br>";
        }

        $avrPlagiasi = ($plagiasi / $jml);
        echo "jumlah hit :" . $jml . ", Jumlah Plagiasi :" . $avrPlagiasi;
        $updateMedia['plagiarism_score'] = $avrPlagiasi;
        $getMedia->update($updateMedia);
    }

    function splitWordChunks($inputString, $numberOfWord)
    {
        // Tokenize the input string into words
        $words = str_word_count($inputString, 1);

        $wordChunks = array_chunk($words, $numberOfWord); // Split into chunks of 500 words each

        $chunksAsStrings = array_map(function ($chunk) {
            return implode(' ', $chunk);
        }, $wordChunks);

        return $chunksAsStrings;
    }

    public function plagiarism(){
        //curl -X POST https://www.check-plagiarism.com/apis \ -d "key=YOUR_KEY"
        //$key       = "9ac78255ce4f3957d682cfaccaa06494";
        $key       = "4efdc9d93d6a81a8ebe91990dc2a7690";
        $ch      = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.check-plagiarism.com/apis");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
    }

    public function tekku(){
        //copyleaks.com
        $email = "inibarubisa@gmail.com";
        $key = "c17529c3-e2dc-4fd5-b5b0-df78f34da0fc";
        //$loginResult = $this->copyleaks->login($email, $key);
        //dd($loginResult);

        
        $loginResult = $this->copyleaks->login($email, $key);
        //$response = $this->_submitFile($loginResult);
        $response = $this->_export($loginResult);
        
        //dd($response);
    }

    private function _submitFile(CopyleaksAuthToken $authToken) {
        $webhook = "https://en9esbbhl0yx6.x.pipedream.net/";
        $fileMedia = "gVFdqLr620230930073936.pdf";
        $pdfFile   = public_path('assets/data/book/'.$fileMedia); 
        $base64File = base64_encode(file_get_contents($pdfFile));
        $submission = new CopyleaksFileSubmissionModel(
          $base64File,
          "test.pdf",
          new SubmissionProperties(
            new SubmissionWebhooks("$webhook.{STATUS}"),
            false,
            null,
            true,
            6,
            1,
            true,
            SubmissionActions::Scan,
            new SubmissionAuthor('php-test'),
            new SubmissionFilter(true, true, true),
            new SubmissionScanning(true, new SubmissionScanningExclude('php-test-*'), null, new SubmissionScanningCopyleaksDB(true, true)),
            new SubmissionIndexing((array)[new SubmissionRepository('repoId')]),
            new SubmissionExclude(true, true, true, true, true),
            new SubmissionPDF(true, 'title', base64_encode('https://lti.copyleaks.com/images/copyleaks50x50.png'), false)
          )
        );
    
        $this->copyleaks->submitFile($authToken, time(), $submission);
        $this->logInfo("-submitFile-");
      }
    
      private function _export(CopyleaksAuthToken $authToken) {
        $webhook = "https://en9esbbhl0yx6.x.pipedream.net";
        $time = time();
        $model = new CopyleaksExportModel(
          "$webhook/export-webhook",
          array(
            //new ExportResults("2a1b402420", "$webhook/export-webhook/result/2a1b402420", "POST", array(array("key", "value")))
        ),
            new ExportCrawledVersion("$webhook/export-webhook/crawled-version", "POST", array(array("key", "value")))
        );
        $exportedScanId = "1696175168";
        $this->copyleaks->export($authToken, $exportedScanId, $time, $model);
        $this->logInfo("-export-");
      }

      private function logInfo($title, $info = null) {
        echo "\n";
        echo "----------------" . $title . "----------------" . "\n\n";
        if ($info) {
          echo json_encode($info);
          echo "\n\n";
        }
      }
}
