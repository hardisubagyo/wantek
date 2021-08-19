@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Permintaan </div>

                <div class="card-body">

                    <button class="btn btn-info" id="btn-add"><i class="fas fa-plus"></i></button>
                    <br><br>

                    <table id="Pengguna" class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Id Permintaan</td>
                                <td>Nama Pemenang</td>
                                <td>Status</td>
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
                        <h5 class="modal-title" id="exampleModalLabel">Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body" style="height: 500px;">
                        <form id="forms">
                            <input type="hidden" id="id">

                            <input type="hidden" id="id_permintaan" value="{{ $id_permintaan }}">

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Barang</label>
                                <div class="col-lg-9">
                                    <select class="form-control" id="id_barang">
                                        @foreach($barang as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Harga</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="harga_barang">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Kuantitas</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="qty">
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary font-weight-bold" id="SaveBarang"> <i class="icon-sm fas fa-save"></i> Simpan</button>

                            <hr>

                            <table id="DetailPermintaan" class="table" width="100%">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Barang</td>
                                        <td>Harga</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
            ajax: "{{ url('Permintaan/getdata') }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'id_permintaan'},
                {data: 'id_vendor'},
                {
                    data: 'status',
                    render: function (data, type, row) {
                        if(data == 0){
                            return 'Proses di admin marketing';
                        }else if(data == 1){
                            return 'Proses di procurement';
                        }else if(data == 2){
                            return 'Dealing Vendor';
                        }else if(data == 3){
                            return 'Final Dealing';
                        }
                    }
                },
                {data: 'action', className: 'uniqueClassName'}
            ]
        });

        var tablebarang = $('#DetailPermintaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('Permintaan/getbarang/'.$id_permintaan) }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'nama'},
                {data: 'harga'},
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

        $('body').on('click', '#CloseModalEdit', function (e) {
            $('#formEdit').modal('hide');
        });

        $('body').on('click', '#SaveModal', function (e) {
            var fd;
              fd = new FormData();
              fd.append('id', $('#id').val());
              fd.append('id_permintaan', $('#id_permintaan').val());
              fd.append('_token', '{{ csrf_token() }}');

              $.ajax({
                data: fd,
                url: "{{ route('Permintaan.store') }}",
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

        $('body').on('click', '#SaveBarang', function (e) {
            var fd;
              fd = new FormData();
              fd.append('id', '');
              fd.append('id_barang', $('#id_barang').val());
              fd.append('harga', $('#harga_barang').val());
              fd.append('qty', $('#qty').val());
              fd.append('id_permintaan', '{{ $id_permintaan }}');
              fd.append('_token', '{{ csrf_token() }}');

              $.ajax({
                data: fd,
                url: "{{ url('Permintaan/simpanbarang') }}",
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
                        $('#harga_barang').val('');
                        $('#qty').val('');
                    }else{
                        swal(data.msg, "", "error");
                    }
                    tablebarang.draw();

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

        $('body').on('click', '.DeleteBarang', function (e) {
            var id = $(this).data('id');
            swal({
                title: "Anda yakin ?",
                icon: "warning",
                showCancelButton: true,
            }).then(function(result) {
                if (result) {
                    $.get("{{ url('Permintaan/hapusbarang')}}" +"/"+ id,function(data){

                        var datas = JSON.parse(data);

                        if(datas.state == '0'){
                            swal(datas.msg, "", "success");
                        }else{
                            swal(datas.msg, "", "error");
                        }
                        tablebarang.draw();
                    });
                }
            });
        });

    });

</script>

@endsection