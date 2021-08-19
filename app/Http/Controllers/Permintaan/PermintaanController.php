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

class PermintaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $barang = Barang::orderby('nama','asc')->get();
        $id_permintaan = rand();

        return view('permintaan.index',compact(['barang','id_permintaan']));
    }

    public function getdata()
    {
        $data = Permintaan::where('id_pertamina',Auth::user()->id)->orderby('created_at','desc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.url('Permintaan/edit/'.$row->id_permintaan).'"><button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id="' . $row->id . '" data-id_permintaan="' . $row->id_permintaan . '">
                            <i class="fa fa-edit"></i>
                        </button></a>
                        <button type="button" class="btn btn-icon btn-sm btn-danger Delete" data-id_permintaan="' . $row->id_permintaan . '">
                            <i class="fa fa-trash"></i>
                        </button>
                        ';
                return $btn;
            })
            ->rawColumns(['action','harga'])
            ->make(true);
    }

    public function edit($id)
    {
        $barang = Barang::orderby('nama','asc')->get();
        $id_permintaan = $id;

        return view('permintaan.edit',compact(['barang','id_permintaan']));
    }

    public function store(Request $request)
    {

        $get = DB::table('detail_permintaan as p')
                    ->select(DB::raw('SUM(p.harga * p.qty) as total'))
                    ->where('p.id_permintaan',$request->id_permintaan)
                    ->first();

        $data = array(
            'id_pertamina' => Auth::user()->id,
            'status' => '0',
            'id_permintaan' => $request->id_permintaan,
            'harga' => $get->total
        );

        $insert = Permintaan::updateOrCreate(
            [
                'id' => $request->id
            ],
            $data
        );
    
        if($insert){
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

    
    public function getbarang($idpermintaan)
    {
        $data = DB::table('detail_permintaan as p')
                    ->select(
                        'p.id',
                        'p.harga',
                        'b.nama'
                    )
                    ->join('barang as b','b.id','=','p.id_barang')
                    ->where('p.id_permintaan',$idpermintaan)
                    ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                        <button type="button" class="btn btn-icon btn-sm btn-danger DeleteBarang" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                        ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function simpanbarang(Request $request)
    {
        $data = array(
            'id_permintaan' => $request->id_permintaan,
            'id_barang' => $request->id_barang,
            'harga' => $request->harga,
            'qty' => $request->qty
        );

        $insert = DetailPermintaan::updateOrCreate(
            [
                'id' => $request->id
            ],
            $data
        );
    
        if($insert){
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

    public function hapusbarang($id)
    {

        $delete = DetailPermintaan::find($id)->delete();

        if($delete)
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
