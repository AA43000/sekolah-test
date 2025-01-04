@extends('index')

@section('content')
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
            <h3>Data Guru</h3>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalForm">Tambah Data</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableData" class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">nama Guru</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Mata Pelajaran</th>
                            <th scope="col">NIP</th>
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
                            <label for="name">Nama Guru</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Nama Guru" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <option value="Laki laki">Laki Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mata_pelajaran">Mata Pelajaran</label>
                            <input type="text" id="mata_pelajaran" name="mata_pelajaran" class="form-control" placeholder="Mata Pelajaran" required>
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-control" placeholder="NIP" required>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select name="id_kelas[]" id="id_kelas" class="form-control select2" style="width: 100%" multiple="multiple">
                                @foreach($kelas as $row)
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
            $('.select2').select2({
                dropdownParent: $('#modalForm'),
                placeholder: 'Pilih Kelas'

            });

            $("#formData").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{route('guru.action-data')}}",
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
            $("#id_kelas").val('').trigger('change');
        }

        function load_data() {
            $.ajax({
                url: "{{route('guru.load-data')}}",
                dataType: "json",
                type: "get",
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    var html;
                    var no = 1;
                    for(var x = 0;x<response.length;x++) {
                        html += `<tr>
                                    <th scope="row">${no++}</th>
                                    <td>${response[x].name}</td>
                                    <td>${response[x].jenis_kelamin}</td>
                                    <td>${response[x].mata_pelajaran}</td>
                                    <td>${response[x].nip}</td>
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
                    url: "{{route('guru.delete-data')}}",
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
                url: "{{route('guru.get-data')}}",
                data: {id: id},
                dataType: "json",
                type: "get",
                beforeSend: function() {
                    showLoader();
                },
                success: function(response) {
                    $("#id").val(response.guru.id);
                    $("#name").val(response.guru.name);
                    $("#nip").val(response.guru.nip);
                    $("#jenis_kelamin").val(response.guru.jenis_kelamin);
                    $("#mata_pelajaran").val(response.guru.mata_pelajaran);

                    if (response.guru_kelas.length > 0) {
                        var id_kelas = [];

                        for (var x = 0; x < response.guru_kelas.length; x++) {
                            id_kelas.push(response.guru_kelas[x].id_kelas);
                        }

                        // Set nilai ke Select2
                        $("#id_kelas").val(id_kelas).trigger('change');
                    }

                    $("#modalForm").modal('show');
                },  
                complete: function() {
                    hideLoader();
                }
            })
        }
    </script>
@endsection