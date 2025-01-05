@extends('index')

@section('content')
<style>
    .nama-kelas {
        font-size: 2.5rem;
    }
    .highlight {
        background-color: green;
        color: white;
    }
    .note {
        margin-top: 10px;
        font-size: 14px;
    }
</style>
<h3 class="mt-3">List Kelas</h3>
<div class="row">
    @foreach($kelas as $key => $kel)
    <div class="col-sm-4">
        <div class="card my-2">
            <div class="card-body d-flex {{$bg[($key%4)]}} text-white bg-kelas">
                <span class="nama-kelas m-auto">{{$kel->name}}</span>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button class="btn btn-secondary" type="button" onclick="load_siswa({{$kel->id}}, '{{$kel->name}}')">Siswa</button>
                <button class="btn btn-secondary" type="button" onclick="load_guru({{$kel->id}}, '{{$kel->name}}')">Guru</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row my-3">
    <h3>List Siswa</h3>
    <div class="table-responsive">
        <table id="tableData1" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">nama Siswa</th>
                    <th scope="col">Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data1 as $key => $dt1)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$dt1->nama_siswa}}</td>
                        <td>{{$dt1->nama_kelas}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row my-3">
    <h3>List Guru</h3>
    <div class="table-responsive">
        <table id="tableData2" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">nama Guru</th>
                    <th scope="col">Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data2 as $key => $dt1)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$dt1->nama_guru}}</td>
                        <td>{{$dt1->nama_kelas}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row my-3">
    <h3>List Siswa dan Guru</h3>
    <div class="table-responsive">
        <table id="tableData3" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">nama Siswa</th>
                    <th scope="col">nama Guru</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data3 as $key => $dt1)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$dt1->nama_kelas}}</td>
                        <td>{{$dt1->list_siswa}}</td>
                        <td>{{$dt1->list_guru}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalGuru" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Guru <span class="nama_kelas"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableGuru" class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">nama Guru</th>
                                <th scope="col">Mata Pelajaran</th>
                            </tr>
                        </thead>
                        <tbody id="bodyGuru">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>  

<!-- Modal -->
<div class="modal fade" id="modalSiswa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Siswa <span class="nama_kelas"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tableSiswa" class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">nama Siswa</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">NIS</th>
                            </tr>
                        </thead>
                        <tbody id="bodySiswa">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>  

<script type="text/javascript">
    $(document).ready(function() {
        new DataTable('#tableData1');
        new DataTable('#tableData2');
        new DataTable('#tableData3');
    })
    function load_guru(id_kelas, nama_kelas) {
        $.ajax({
            url: "{{route('dashboard.load-guru')}}",
            dataType: "json",
            data: {id_kelas: id_kelas},
            type: "get",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                var html;
                var no = 1;
                $(".nama_kelas").html('Kelas '+nama_kelas);
                $("#bodyGuru").empty();
                for(var x = 0;x<response.length;x++) {
                    html += `<tr>
                                <th scope="row">${no++}</th>
                                <td>${response[x].name}</td>
                                <td>${response[x].mata_pelajaran}</td>
                            </tr>`;
                }

                $("#bodyGuru").html(html);

                new DataTable('#tableGuru');

                $("#modalGuru").modal('show');
            },
            complete: function() {
                hideLoader();
            }
        })
    }

    function load_siswa(id_kelas, nama_kelas) {
        $.ajax({
            url: "{{route('dashboard.load-siswa')}}",
            dataType: "json",
            data: {id_kelas: id_kelas},
            type: "get",
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                var html;
                var no = 1;
                $(".nama_kelasa").html('Kelas '+nama_kelas);
                $("#bodySiswa").empty();
                for(var x = 0;x<response.length;x++) {
                    html += `<tr>
                                <th scope="row">${no++}</th>
                                <td>${response[x].name}</td>
                                <td>${response[x].jenis_kelamin}</td>
                                <td>${response[x].nis}</td>
                            </tr>`;
                }

                $("#bodySiswa").html(html);

                new DataTable('#tableSiswa');

                $("#modalSiswa").modal('show');
            },
            complete: function() {
                hideLoader();
            }
        })
    }
</script>
@endsection