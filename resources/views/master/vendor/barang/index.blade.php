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
                                <td>Harga</td>
                                <td>Stok</td>
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
                    <div class="modal-body" style="height: 400px;">
                        <form id="forms">
                            <input type="hidden" id="id">

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Nama</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="nama">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Harga</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="harga">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Stok</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="stok">
                                    <!-- <span class="form-text text-muted">Please enter your full name</span> -->
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

    var harga = document.getElementById('harga');
    harga.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        harga.value = formatRupiah(this.value, 'Rp. ');
    });

    var stok = document.getElementById('stok');
    stok.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        stok.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }

    $(document).ready(function () {

        $.noConflict();
        var table = $('#Pengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('Master/Barang/getdata') }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'nama'},
                {data: 'harga'},
                {data: 'stok'},
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
              fd.append('nama', $('#nama').val());
              fd.append('harga', $('#harga').val());
              fd.append('stok', $('#stok').val());
              fd.append('_token', '{{ csrf_token() }}');

              $.ajax({
                data: fd,
                url: "{{ route('Master.Barang.store') }}",
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
            $.get("{{ url('Master/Barang/edit')}}" +"/"+ id,function(data){

                console.log(data);

                $('#formInput').modal({backdrop: 'static', keyboard: false});
                $('.textPassword').html('Isi jika ingin mengganti password');
                $('.textPasswordConfirm').html('Isi jika ingin mengganti password');

                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#harga').val(data.harga);
                $('#stok').val(data.stok);

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
                    $.get("{{ url('Master/Barang/destroy')}}" +"/"+ id,function(data){

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