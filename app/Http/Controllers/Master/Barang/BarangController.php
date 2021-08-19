<?php

namespace App\Http\Controllers\Master\Barang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator; 
use App\Models\Master\Barang;
use DataTables;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.vendor.barang.index');
    }

    public function getdata()
    {
        $data = Barang::where('id_vendor',Auth::user()->id)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('harga', function ($row) {
                $btn = number_format($row->harga,0,'.','.');
                return $btn;
            })
            ->addColumn('stok', function ($row) {
                $btn = number_format($row->stok,0,'.','.');
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-danger Delete" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                        ';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<button type="button" class="btn btn-icon btn-sm btn-warning Edit" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-sm btn-danger Delete" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                        ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($id)
    {
        $data = Barang::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $delete = Barang::find($id)->delete();

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
    
    public function store(Request $request){

        $data = array(
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'id_vendor' => Auth::user()->id
        );

        $insert = Barang::updateOrCreate(
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
    
}
