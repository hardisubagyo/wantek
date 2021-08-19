@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar Permintaan </div>

                <div class="card-body">

                    <table id="Pengguna" class="table">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Permintaan</td>
                                <td>Total</td>
                                <td>Tanggal Permintaan</td>
                                <td>Status</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

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
            ajax: "{{ url('Permintaan/getdataListPermintaan') }}",
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'name'},
                {data: 'total'},
                {data: 'created_at'},
                {
                    data: 'status',
                    render: function (data, type, row) {
                        if(data == 0){
                            return 'Proses di admin marketing';
                        }else if(data == 1){
                            return 'Proses di pengadaan';
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

    });

</script>

@endsection