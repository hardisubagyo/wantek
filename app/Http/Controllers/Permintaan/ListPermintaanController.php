<?php

namespace App\Http\Controllers\Permintaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator; 
use App\Models\Master\Barang;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Permintaan\Permintaan;
use App\Models\Permintaan\DetailPermintaan;
use DB;

class ListPermintaanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('permintaan.listpermintaan.index');
    }

    public function getdata()
    {
        $data = DB::table('master_pemintaan as p')
                    ->select(
                        'p.id_permintaan',
                        'u.name',
                        'p.status',
                        'p.created_at'
                    )
                    ->join('users as u','u.id','=','p.id_pertamina')
                    ->orderby('p.created_at','desc')
                    ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total', function ($row) {
                $get = DB::table('detail_permintaan as k')
                    ->select(DB::raw('SUM(k.harga * k.qty) as total'))
                    ->where('k.id_permintaan',$row->id_permintaan)
                    ->first();
            
                return number_format($get->total,0,'.','.');
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.url('Permintaan/view/'.$row->id_permintaan).'"><button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id_permintaan="' . $row->id_permintaan . '">
                            <i class="fa fa-edit"></i>
                        </button></a>
                        ';
                return $btn;
            })
            ->rawColumns(['action','harga'])
            ->make(true);
    }

    public function view($id)
    {
        $id_permintaan = $id;

        return view('permintaan.listpermintaan.view',compact(['id_permintaan']));
    }

    public function getview($idpermintaan)
    {
        $data = DB::table('detail_permintaan as p')
                    ->select(
                        'p.id',
                        'p.harga',
                        'p.qty',
                        'b.nama'
                    )
                    ->join('barang as b','b.id','=','p.id_barang')
                    ->where('p.id_permintaan',$idpermintaan)
                    ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('harga', function ($row) {
                $harga = number_format($row->harga,0,'.','.');
                return $harga;
            })
            ->addColumn('qty', function ($row) {
                $qty = number_format($row->qty,0,'.','.');
                return $qty;
            })
            ->rawColumns(['harga','qty'])
            ->make(true);
    }

    public function pengadaan(Request $request)
    {
        $data = array(
            'status' => '1'
        );

        $update = DB::table('master_pemintaan')
                            ->where('id_permintaan', $request->id_permintaan)
                            ->update($data);

        if($update)
        {
            $output = array(
                'state' => 0,
                'msg' => 'Sukses'
            );

        }else{
            $output = array(
                'state' => 1,
                'msg' => 'Gagal'
            );
        }

        echo json_encode($output);                  
    }
}
