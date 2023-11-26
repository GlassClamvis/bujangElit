<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 150px 50px 120px 50px;
            }
        
        .header-text {
            text-align: center;
        }
        .content {
            text-align: center;
        }
        
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
           

        </header>

        <footer>
            
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="margin: 0px 10px 0px 10px;">

            <div class="certificate">
                <div class="header-text">
                    <h1>Certificate of BujangElit Plagiarism</h1>
                </div>
                <div class="content">
                    <p>Menyatakan Judul Jurnal</p>
                    <h2>{{$mediaPlagiarism->media->judul}}</h2>
                    <p>Has Score Plagiarism</p>
                    <h2>{{$score}} %</h2>
                </div>
            </div>

        </main>
    </body>
</html>
