<?php

namespace App\Http\Controllers\Pengadaan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator; 
use App\Models\Master\Barang;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Permintaan\Permintaan;
use App\Models\Permintaan\DetailPermintaan;
use App\User;
use DB;

class PengadaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pengadaan.index');
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
                    ->where('p.status','1')
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
                $btn = '<a href="'.url('Pengadaan/view/'.$row->id_permintaan).'">
                            <button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id_permintaan="' . $row->id_permintaan . '">
                            <i class="fa fa-info-circle"></i>
                            </button>
                        </a>
                        ';
                return $btn;
            })
            ->rawColumns(['action','harga'])
            ->make(true);
    }

    public function view($id)
    {
        $id_permintaan = $id;

        return view('pengadaan.view',compact(['id_permintaan']));
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

    public function getVendor(){
        $get = User::where('akses','3')->orderby('name','asc')->get();
        return DataTables::of($get)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id="' . $row->id . '">
                            <i class="fa fa-info-circle"></i>
                        </button>
                        ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
