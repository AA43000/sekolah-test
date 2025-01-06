<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrangtuaController extends Controller
{
    public function index(Request $req) {
        $data['title'] = 'Orang Tua';
        $data['siswas'] = DB::table('siswas')->get();
        return view('orangtua', $data);
    }

    public function loadData(Request $req) {
        $data = DB::table('orangtuas')->select('orangtuas.*', 'siswas.name as nama_siswa')->leftJoin('siswas', 'siswas.id', '=', 'orangtuas.id_siswa')->get();

        return response()->json($data);
    }

    public function getData(Request $req) {
        $data = DB::table('orangtuas')->where('id', $req->id)->first();

        return response()->json($data);
    }

    public function deleteData(Request $req) {
        $cek = DB::table('orangtuas')->where('id', $req->id)->first();
        if($cek) {
            DB::table('orangtuas')->where('id', $req->id)->delete();
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
            DB::table('orangtuas')->where('id', $req->id)->update([
                'name' => $req->name,
                'id_siswa' => $req->id_siswa,
                'updated_at' => now()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil update data siswa'
            ]);
        } else {
            DB::table('orangtuas')->insert([
                'name' => $req->name,
                'id_siswa' => $req->id_siswa,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil input data siswa'
            ]);
        }
    }
}
