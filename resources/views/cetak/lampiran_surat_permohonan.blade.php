<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 200px 40px 33px 40px;
            }

          

            header {
                position: fixed;
                width: 100%;
                top: -180px;
                left: 0px;
                right: 0px;
                height: 200px;

                /** Extra personal styles **/
                /* background-color: rgb(165, 12, 12); */
                color: black;
               /*  text-align: center; */
                line-height: 35px;
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
                width: 6%;
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
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <div style="margin-top:35px;margin-bottom: 10px">
                <div style="width: 100%;">
                    <div class="columna">
                        Nomor
                    </div>
                    <div class="columnb">
                        :<strong>{{" ".$data['nomor_surat']}}</strong>
                    </div>
                    <div class="columnc">
                        {{-- <span>Jember, {{\Carbon\Carbon::now()->translatedFormat('d F Y') }}</span> --}}
                    </div>
                </div>
                </br>
                <div style="width: 100%; margin-top: -15px;">
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
                <div style="width: 100%; margin-top: -30px;">
                    <div class="columna">
                        Tanggal
                    </div>
                    <div class="columnb">
                        : {{\Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </div>
                    <div class="columnc">
                        &nbsp;
                    </div>
                </div>
                </br>
                <div style="width: 100%; margin-top: -45px;">
                    <div class="columna">
                        Hal
                    </div>
                    <div class="columnb">
                        : Permohonan Penilaian Kelayakan Pengusul Mutasi Jabatan/Pangkat Dosen
                    </div>
                    <div class="columnc">
                        &nbsp;
                    </div>
                </div>
                </br>
                <p style="text-align: center; margin-top: -55px; line-height: 18px;font-size:14px;"><strong> DAFTAR NAMA DOSEN</strong></p>
            </br>
                <p style="text-align: center; margin-top: -70px; line-height: 18px;font-size:14px;"><strong> YANG MENGUSULKAN KENAIKAN JABATAN/PANGKAT BULAN MARET</strong></p>
              
            </div>
        </header>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div style="margin-top:0px;">
                <table width="100%" >
                    <thead>
                        <tr>
                          <th rowspan="2" width="3%">No</th>
                          <th rowspan="2" width="30%">Nama / NIP</th>
                          <th rowspan="2" width="30%">Program Studi/ Jurusan</th>
                          <th colspan="2" >Kenaikan</th>
                          <th rowspan="2" width="10%">Keterangan</th>
                          <th colspan="2" >Perolehan</th>
                          <th rowspan="2" width="8%">Jumlah Angka<br>Kredit</th>
                        </tr>
                        <tr>
                          <th width="10%">Jabatan</th>
                          <th width="8%">Golongan</th>
                          <th width="6%">Lama</th>
                          <th width="6%">Baru</th>
                        </tr>
                      </thead>
                    <tbody>
                       @foreach ($dataLampiranPemohon as $v )
                        <tr>
                            <td align="center">{{$v['no']}}</td>
                            <td align="left">{{$v['nama']}}</br> {{$v['nip']}} </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                      

                    </tbody>
                </table>
            </div>
            <div style="width: 100%; margin-top:10px;">
                <div class="column">
                  &nbsp;
                </div>
                <div class="space">

                </div>
                <div class="ttd" style="padding-left:150px; background-color:rgb(255, 255, 255); height:130px; font-size:14px; line-height: 18px;">
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

        </main>
    </body>
</html>
