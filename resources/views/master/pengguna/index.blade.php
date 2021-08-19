@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pengguna</div>

                <div class="card-body">

                    <button class="btn btn-info" id="btn-add"><i class="fas fa-plus"></i></button>
                    <br><br>

                    <table id="Pengguna" class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Akses</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

            </div>
        </div>

        <div class="modal fade" id="formInput" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pengguna</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 400px;">
                        <form id="forms">
                            <input type="hidden" id="id">

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="name">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" class="form-control" id="email">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Password</label>
                                <div class="col-lg-9">
                                    <input type="password" class="form-control" id="password">
                                    <span class="form-text text-muted textPassword"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Ulangi Password</label>
                                <div class="col-lg-9">
                                    <input type="password" class="form-control" id="confirm_password">
                                    <span class="form-text text-muted textPasswordConfirm"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Level</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="akses">
                                        <option value="0">Super Admin</option>
                                        <option value="1">Admin Marketing</option>
                                        <option value="2">Procurement</option>
                                        <option value="3">Vendor</option>
                                        <option value="4">Pertamina</option>
                                    </select>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning font-weight-bold" id="CloseModal"> <i class="icon-sm fas fa-window-close"></i> Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold" id="SaveModal"> <i class="icon-sm fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function () {

        $.noConflict();
        var table = $('#Pengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('Master/Pengguna/getdata') }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'name'},
                {
                    data: 'akses',
                    render: function (data, type, row) {
                        if(data == 0){
                            return 'Super Admin';
                        }else if(data == 1){
                            return 'Admin Marketing';
                        }else if(data == 2){
                            return 'Procurement';
                        }else if(data == 3){
                            return 'Vendor';
                        }else if(data == 4){
                            return 'Pertamina';
                        }
                    }
                },
                {data: 'action', className: 'uniqueClassName'}
            ]
        });

        $('body').on('click', '#btn-add', function (e) {
            $('#formInput').modal({backdrop: 'static', keyboard: false});
            $('#forms').trigger("reset");
            $('#id').val('');
            $('.textPassword').html('');
            $('.textPasswordConfirm').html('');
        });

        $('body').on('click', '#CloseModal', function (e) {
            $('#formInput').modal('hide');
        });

        $('body').on('click', '#SaveModal', function (e) {
            var fd;
              fd = new FormData();
              fd.append('id', $('#id').val());
              fd.append('name', $('#name').val());
              fd.append('email', $('#email').val());
              fd.append('password', $('#password').val());
              fd.append('confirm_password', $('#confirm_password').val());
              fd.append('akses', $('#akses').val());
              fd.append('_token', '{{ csrf_token() }}');

              $.ajax({
                data: fd,
                url: "{{ route('Master.Pengguna.store') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#SaveModal').html('<span class="spinner-grow spinner-grow-sm" role="status"></span> Loading...');
                    $('#SaveModal').prop("disabled",true);
                    $('#CloseModal').prop("disabled",true);
                },
                success: function (data) {

                    if(data.state == '0'){
                        swal(data.msg, "", "success");
                        $('#formInput').modal('hide');
                    }else{
                        swal(data.msg, "", "error");
                    }
                    table.draw();

                },
                error: function (data) {
                    $('#SaveModal').html('<i class="icon-sm fas fa-save"></i> Simpan');
                    $('#SaveModal').prop("disabled",false);
                    $('#CloseModal').prop("disabled",false);

                    console.log(data);
                    swal("Gagal Input", "", "error");
                },
                complete: function() {
                    $('#SaveModal').html('<i class="icon-sm fas fa-save"></i> Simpan');
                    $('#SaveModal').prop("disabled",false);
                    $('#CloseModal').prop("disabled",false);
                }
            });

        });

        $('body').on('click', '.Edit', function (e) {
            $('#forms').trigger("reset");
            $('#id').val('');
            var id = $(this).data('id');
            $.get("{{ url('Master/Pengguna/edit')}}" +"/"+ id,function(data){

                console.log(data);

                $('#formInput').modal({backdrop: 'static', keyboard: false});
                $('.textPassword').html('Isi jika ingin mengganti password');
                $('.textPasswordConfirm').html('Isi jika ingin mengganti password');

                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#akses').val(data.akses);

            });
        });

        $('body').on('click', '.Delete', function (e) {
            var id = $(this).data('id');
            swal({
                title: "Anda yakin ?",
                icon: "warning",
                showCancelButton: true,
            }).then(function(result) {
                if (result) {
                    $.get("{{ url('Master/Pengguna/destroy')}}" +"/"+ id,function(data){

                        var datas = JSON.parse(data);

                        if(datas.state == '0'){
                            swal(datas.msg, "", "success");
                        }else{
                            swal(datas.msg, "", "error");
                        }
                        table.draw();

                    });
                }
            });
        });

    });

</script>

@endsection