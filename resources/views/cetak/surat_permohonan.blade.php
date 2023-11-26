<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 150px 50px 120px 50px;
            }
            footer {
                position: fixed;
                bottom: -100px;
                left: 0px;
                right: 0px;
                height: 100px;

                /** Extra personal styles **/
                background-color: white;
                color: black;
                text-align: left;
                line-height: 16px;
            }

            header {
                position: fixed;
                width: 100%;
                top: -130px;
                left: 0px;
                right: 0px;
                height: 130px;

                /** Extra personal styles **/
                background-color: rgb(255, 255, 255);
                color: black;
                text-align: center;
                line-height: 35px;

                border-bottom-width: 2px;
                border-bottom-style: solid;
                border-bottom-color: rgb(0, 0, 0);
            }

            .column {
                float: left;
                width: 55%;
                font-size: 12px;
                line-height: 15px;
            }
            .space {
                float: left;
                width: 5%;
            }

            .ttd{
                float: left;
                width:40%;
                font-size: 12px;
                line-height: 15px;
            }
            .columna{
                float: left;
                width: 10%;
                font-size: 14px;
                line-height: 18px;
            }
            .columnb{
                float: left;
                width: 67%;
                font-size: 14px;
                line-height: 18px;
            }

            .columnc{
                float: left;
                width:33%;
                font-size: 14px;
                line-height: 18px;
            }

            /* Clear floats after the columns */
            .row:after {
                clear: both;
            }
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                font-size: 14px;
            }
            .tdCenter{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="float: left; margin-bottom:0px;">
                <img src="{{ public_path('system/polije.png') }}" style="width: 120px; height: 120px">
            </div>
            <div style="float: left; padding-left:20px; margin-top:-10px;">
                <p style="text-align: center; margin-bottom: 1px;line-height: 5px;font-size:18px;">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,
                </p>
                <p style="text-align: center; margin-bottom: 1px;line-height: 5px;font-size:18px;">
                    RISET, DAN TEKNOLOGI
                </p>
                <p style="text-align: center; margin-bottom: 1px;line-height: 5px;font-size:16px; font-weight: bold;">
                    POLITEKNIK NEGERI JEMBER
                </p>
               {{--  <p style="text-align: center; margin-bottom: px;line-height: 5px;font-size:16px;">
                    {{$data['unit']}}
                </p> --}}
                <p style="text-align: center; margin-bottom: 1px;line-height: 5px;font-size:16px;">
                    Jalan Mastrip Kotak Pos 164 Jember Telp. (0331) 33532-34; Fax. (0331) 333531
                </p>
                <p style="text-align: center; margin-bottom: 0px;line-height: 5px;font-size:16px;">
                    Email: politeknik@polije.ac.id; Laman: www.polije.ac.id
                </p>
            </div>
        </br>

        </header>

        <footer>
            <div style="margin-top:5px;margin-bottom: 2px">
                <div style="width: 104%; margin-top: 0px; font-size: 10px; line-height: 16px; word-spacing:2px;">
                    Tembusan :</br>
                    1. Wadir 1</br>
                    2. Kepegawaian</br>
                    3. Arsip
                </div>
            </div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="margin: 0px 10px 0px 10px;">

            <div style="width: 100%; margin-top: 10px;  ">
                <div class="columna">
                    Nomor
                </div>
                <div class="columnb">
                    :<strong>{{" ".$data['nomor_surat']}}</strong>
                </div>
                <div class="columnc">
                    <span>Jember, {{\Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>
            </br>
            <div style="width: 100%; margin-top: -3px; ">
                <div class="columna">
                    Lampiran
                </div>
                <div class="columnb">
                    : 1 Lembar
                </div>
                <div class="columnc">
                    &nbsp;
                </div>
            </div>
            </br>
            <div style="width: 100%; margin-top: -4px; ">
                <div class="columna">
                    Perihal
                </div>
                <div class="columnb">
                    : <Strong>Permohonan Penilaian Kelayakan Pengusul Mutasi Jabatan/Pangkat Dosen</Strong>
                </div>
                <div class="columnc">
                    &nbsp;
                </div>
            </div>
            </br>

            <div style="width: 100%; margin-top: 30px; font-size: 14px; line-height: 18px;">
                Yth. Ketua Senat
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                Politeknik Negeri Jember
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                Di -
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                Jember
            </div>

            <div style="width: 104%; margin-top: 30px; font-size: 14px; line-height: 20px; word-spacing:2px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Bersama ini kami sampaikan dengan hormat Permohonan Penilaian Kelayakan Pengusul Mutasi Jabatan/Pangkat Dosen Politeknik Negeri Jember 
                mulai tanggal .... sampai dengan tanggal ..... sebanyak .... orang dosen dengan rincian sebagaimana terlampir.
            </br>
            Demikian atas perhatian dan kerjasamanya, kami mengucapkan terima kasih.
            </div>

           
            </br>
            <div style="width: 100%; ">
                <div class="column">
                  &nbsp;
                </div>
                <div class="space">

                </div>
                <div class="ttd" style="background-color:rgb(255, 255, 255); height:130px; font-size:14px; line-height: 18px;">
                    @if($data['unit']=="208")
                    <span>Direktur</span></br>

                    @elseif($data['unit']=="209")
                    <span>A.n. Direktur</span></br>
                        
                    <span>{{Str::headline("wakil direktur bid. keuangan dan umum,")}}</span>
                    @endif
                  {{--   <img src="{{ public_path('system/ttd.png') }}" style="width: 220px; height: 110px"></br> --}}
                </br>
            </br>
            </br>
            </br>
                    <span>{{$data['nama']}}</span></br>
                    <span>NIP. {{$data['nip']}} </span></br>


                </div>
            </div>
            <br/>
            <br/>
            <br/>
            <div style="width: 100%; height:30px; margin-top:10px;clear: both;">

        </main>
    </body>
</html>
