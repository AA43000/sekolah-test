<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sekolah - {{$title}}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <style>
            /* Styling overlay */
            .loader-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Background gelap transparan */
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 9999; /* Pastikan overlay berada di atas elemen lainnya */
            }
            .loader {
                height: 15px;
                aspect-ratio: 5;
                display: grid;
            }
            .loader:before,
            .loader:after {
                content: "";
                grid-area: 1/1;
                height: inherit;
                --_g: no-repeat radial-gradient(farthest-side,#00BFFF 94%,#00BFFF);
                background:
                    var(--_g) left,
                    var(--_g) right;
                background-size: 15px 100%;
                background-repeat: no-repeat;
                animation: l35 1s infinite linear; 
            }
            .loader:after {
                margin-left: auto;
                --s:-1;
            }
            @keyframes l35 {
                0%   {transform:translateY(calc(var(--s,1)*0px));aspect-ratio: 2.3 }
                33%  {transform:translateY(calc(var(--s,1)*8px));aspect-ratio: 2.3 }
                66%  {transform:translateY(calc(var(--s,1)*8px));aspect-ratio: 3.7 }
                100% {transform:translateY(calc(var(--s,1)*0px));aspect-ratio: 3.7 }
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('dashboard')}}">
                <img src="{{asset('img/logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
                Sekolah
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route('dashboard')}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('siswa')}}">Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('kelas')}}">kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('guru')}}">Guru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logout')}}">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="loader-overlay">
            <div class="loader"></div>
        </div>
        <div class="container">
            @yield('content')
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                
            })
    
            function showLoader() {
                $(".loader-overlay").css('display', 'flex');
            }
            function hideLoader() {
                $(".loader-overlay").css('display', 'none');
            }
        </script>
    </body>
</html>
