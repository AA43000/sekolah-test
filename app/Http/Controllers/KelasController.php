<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index(Request $req) {
        $data['title'] = 'Kelas';

        return view('kelas', $data);
    }

    public function loadData(Request $req) {
        $data = DB::table('kelas')->get();

        return response()->json($data);
    }

    public function getData(Request $req) {
        $data = DB::table('kelas')->where('id', $req->id)->first();

        return response()->json($data);
    }

    public function deleteData(Request $req) {
        $cek = DB::table('kelas')->where('id', $req->id)->first();
        if($cek) {
            DB::table('kelas')->where('id', $req->id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Hapus data berhasil'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Hapus data gagal, Data tidak ditemukan'
            ]);
        }
    }

    public function actionData(Request $req) {
        
        if($req->id > 0) {
            $cek = DB::table('kelas')->where('name', $req->name)->where('id', '!=', $req->id)->first();
            if(!$cek) {
                DB::table('kelas')->where('id', $req->id)->update([
                    'name' => $req->name,
                    'updated_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil update data kelas'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama kelas telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        } else {
            $cek = DB::table('kelas')->where('name', $req->name)->first();
            if(!$cek) {
                DB::table('kelas')->insert([
                    'name' => $req->name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil input data kelas'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama kelas telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        }
    }
}
