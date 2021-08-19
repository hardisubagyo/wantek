@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">
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

            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Daftar Vendor </div>

                <div class="card-body">

                    <table id="DetailVendor" class="table" width="100%">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama Vendor</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>

            </div>
        </div>

        <hr>
        <div class="col-md-12">
            <div class="card-footer">
                <a href="{{ url('Pengadaan') }}">
                    <button type="button" class="btn btn-warning font-weight-bold" id="CloseModal"> <i class="icon-sm fas fa-window-close"></i> Kembali</button>
                </a>
                <button type="button" class="btn btn-primary font-weight-bold" id="SaveModal"> <i class="icon-sm fas fa-save"></i> Proses</button>
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
            ajax: "{{ url('Pengadaan/getview/'.$id_permintaan) }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'nama'},
                {data: 'harga'},
                {data: 'qty'},
            ]
        });

        var tablevendor = $('#DetailVendor').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('Pengadaan/getvendor') }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'name'},
                {data: 'action', className: 'uniqueClassName'}
            ]
        });

    });

</script>

@endsection