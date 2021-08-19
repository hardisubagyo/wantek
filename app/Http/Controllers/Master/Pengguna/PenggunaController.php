<?php

namespace App\Http\Controllers\Master\Pengguna;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator; 
use App\User;
use DataTables;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('master.pengguna.index');
    }

    public function getdata()
    {
        $data = User::all();
        return DataTables::of($data)
            ->addIndexColumn()
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

    public function store(Request $request)
    {
        if($request->id == ''){

            if($request->password == '')
            {
                $output = array(
                    'state' => 1,
                    'msg' => 'Password tidak boleh kosong'
                );
            }else if($request->password != $request->confirm_password)
            {
                $output = array(
                    'state' => 1,
                    'msg' => 'Password tidak sama'
                );
            }else{

                $checkemail = User::where('email',$request->email)->get();

                if(count($checkemail) == '1')
                {
                    $output = array(
                        'state' => 1,
                        'msg' => 'Email sudah tersedia'
                    );
                }else{

                    $insert = User::updateOrCreate(
                        [
                            'id' => $request->id
                        ],
                        [
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'akses' => $request->akses
                        ]
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

                }

            }

        }else{

            $data = array(
                'name' => $request->name,
                'email' => $request->email,
                'akses' => $request->akses
            );

            if($request->password != '')
            {
                if($request->password != $request->confirm_password)
                {
                    $output = array(
                        'state' => 1,
                        'msg' => 'Password tidak sama'
                    );

                }else{
                    $data['password'] = Hash::make($request->password);

                    $insert = User::updateOrCreate(
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
                }
            }else{
                $insert = User::updateOrCreate(
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
            }
        }

        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $delete = User::find($id)->delete();

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
