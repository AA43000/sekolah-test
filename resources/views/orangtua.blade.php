@extends('index')

@section('content')
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
            <h3>Data Orang Tua</h3>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm">Tambah Data</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableData" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Orang Tua</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="body-table">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formData">
                    @csrf
                    <input type="hidden" id="id" name="id" value="0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalForm">Form Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Orang Tua</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nama Orang Tua" required>
                        </div>
                        <div class="form-group">
                            <label for="id_kelas">Siswa</label>
                            <select name="id_siswa" id="id_siswa" class="form-control">
                                <option value="" selected disabled>Pilih Siswa</option>
                                @foreach($siswas as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="reset_data()" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            load_data();

            $("#formData").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{route('orangtua.action-data')}}",
                    data: $(this).serialize(),
                    dataType: "json",
                    type: "post",
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if(response.success) {
                            $("#modalForm").modal('hide');
                            reset_data();
                            load_data();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            })
        })

        function reset_data() {
            $("#formData")[0].reset();
            $("#id").val('0');
        }

        function load_data() {
            $.ajax({
                url: "{{route('orangtua.load-data')}}",
                dataType: "json",
                type: "get",
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    var html = '';
                    var no = 1;
                    for(var x = 0;x<response.length;x++) {
                        html += `<tr>
                                    <th scope="row">${no++}</th>
                                    <td>${response[x].name}</td>
                                    <td>${response[x].nama_siswa}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="delete_data(${response[x].id})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-success" onclick="edit_data(${response[x].id})"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </td>
                                </tr>`;
                    }

                    $("#body-table").html(html);

                    new DataTable('#tableData');
                },
                complete: function() {
                    hideLoader();
                }
            })
        }

        function delete_data(id) {
            if(confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: "{{route('orangtua.delete-data')}}",
                    data: {
                        id: id,
                        _token: "{{csrf_token()}}"
                    },
                    dataType: "json",
                    type: "delete",
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if(response.success) {
                            load_data();
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            }
        }

        function edit_data(id) {
            $.ajax({
                url: "{{route('orangtua.get-data')}}",
                data: {id: id},
                dataType: "json",
                type: "get",
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    $("#id").val(response.id);
                    $("#name").val(response.name);
                    $("#id_siswa").val(response.id_siswa);

                    $("#modalForm").modal('show');
                },  
                complete: function() {
                    hideLoader();
                }
            })
        }
    </script>
@endsection