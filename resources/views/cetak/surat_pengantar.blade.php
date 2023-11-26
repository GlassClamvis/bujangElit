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
                <p style="text-align: center; margin-bottom: px;line-height: 5px;font-size:16px;">
                    {{$data['unit']}}
                </p>
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
                    :
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
                    : <Strong>Permohonan Kenaikan Jabatan Fungsional</Strong>
                </div>
                <div class="columnc">
                    &nbsp;
                </div>
            </div>
            </br>

            <div style="width: 100%; margin-top: 30px; font-size: 14px; line-height: 18px;">
                Kepada Yth :
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                <strong>Direktur</strong> 
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                Politeknik Negeri Jember
            </div>
            <div style="width: 100%; margin-top: 0px; font-size: 14px; line-height: 18px;">
                Di Tempat
            </div>

            <div style="width: 104%; margin-top: 30px; font-size: 14px; line-height: 20px; word-spacing:2px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Dalam rangka pembinaan dan pengembangan karier pegawai di lingkungan Politeknik Negeri Jember, dengan ini kami sampaikan dengan hormat usulan kenaikan
                jabatan fungsional dari {{Str::title($data['unit'])}}.
            </div>

            <table width="100%" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th width="5px;">No</th>
                        <th width="35%" style="vertical-align : middle;text-align:center;">Nama</th>
                        <th width="25%" style="vertical-align : middle;text-align:center;">NIP/NIK</th>
                        <th width="20%" style="vertical-align : middle;text-align:center;">Pangkat/Gol</th>
                        <th width="15%" style="vertical-align : middle;text-align:center;">Kenaikan Jabatan</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($dataSuratPengantar as $v)
                    <tr>
                        <td style="vertical-align : middle;text-align:center;">{{$v['no']}}</td>
                        <td>{{$v['nama']}}</td>
                        <td>{{$v['nip']}}</td>
                        <td>{{$v['pangkat']}}</td>
                        <td>{{$v['kenaikan']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="width: 104%; margin-top: 30px; font-size: 14px; line-height: 20px; word-spacing:2px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Mohon dapatnya berkas - berkas yang kami kirim untuk kenaikan jabatan dosen tersebut dapat di proses sebagai mana mestinya.
                Demikian surat permohonan ini, atas perhatian dan kerjasamanya kami sampaikan terima kasih.
            </div>
            </br>
            <div style="width: 100%; ">
                <div class="column">
                  &nbsp;
                </div>
                <div class="space">

                </div>
                <div class="ttd" style="background-color:rgb(255, 255, 255); height:130px; font-size:14px; line-height: 18px;">
                    <span>Ketua Unit</span></br>
                    <span>{{Str::headline($data['unit'])}}</span>
                  {{--   <img src="{{ public_path('system/ttd.png') }}" style="width: 220px; height: 110px"></br> --}}
                </br>
            </br>
            </br>
            </br>
            </br>
                    <span>{{$data['kanit']}}</span></br>
                    <span>NIP. {{$data['ni']}}</span></br>


                </div>
            </div>
            <br/>
            <br/>
            <br/>
            <div style="width: 100%; height:30px; margin-top:10px;clear: both;">

        </main>
    </body>
</html>
