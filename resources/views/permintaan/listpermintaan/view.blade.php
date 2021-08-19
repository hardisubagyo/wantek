@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Permintaan </div>

                <div class="card-body">

                    <table id="DetailPermintaan" class="table" width="100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Barang</td>
                                <td>Harga</td>
                                <td>Kuantitas</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

                <div class="card-footer">
                    <a href="{{ url('Permintaan/ListPermintaan') }}">
                        <button type="button" class="btn btn-warning font-weight-bold" id="CloseModal"> <i class="icon-sm fas fa-window-close"></i> Kembali</button>
                    </a>
                    <button type="button" class="btn btn-primary font-weight-bold" id="SaveModal"> <i class="icon-sm fas fa-save"></i> Proses</button>
                </div>
            </div>
        </div>

    </div>
</div>


<script>

    $(document).ready(function () {

        $.noConflict();

        var tablebarang = $('#DetailPermintaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('Permintaan/getview/'.$id_permintaan) }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'nama'},
                {data: 'harga'},
                {data: 'qty'},
            ]
        });

        $('body').on('click', '#SaveModal', function (e) {
            var fd;
              fd = new FormData();
              fd.append('id_permintaan', '{{ $id_permintaan }}');
              fd.append('_token', '{{ csrf_token() }}');

              $.ajax({
                data: fd,
                url: "{{ url('Permintaan/pengadaan') }}",
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
                        window.location = "{{ url('Permintaan/ListPermintaan') }}";
                    }else{
                        swal(data.msg, "", "error");
                    }

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

    });

</script>

@endsection