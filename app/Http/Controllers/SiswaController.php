<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(Request $req) {
        $data['title'] = 'Siswa';

        $data['kelas'] = DB::table('kelas')->get();
        return view('siswa', $data);
    }

    public function loadData(Request $req) {
        $data = DB::table('siswas')
        ->select('siswas.*', 'kelas.name as nama_kelas', 'orangtuas.name as nama_orangtua')
        ->leftJoin('kelas', 'kelas.id', '=', 'siswas.id_kelas')
        ->leftJoin('orangtuas', 'orangtuas.id_siswa', '=', 'siswas.id')
        ->get();

        return response()->json($data);
    }

    public function getData(Request $req) {
        $data = DB::table('siswas')->where('id', $req->id)->first();

        return response()->json($data);
    }

    public function deleteData(Request $req) {
        $cek = DB::table('siswas')->where('id', $req->id)->first();
        if($cek) {
            DB::table('siswas')->where('id', $req->id)->delete();
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
            $cek = DB::table('siswas')->where('nis', $req->nis)->where('id', '!=', $req->id)->first();
            if(!$cek) {
                DB::table('siswas')->where('id', $req->id)->update([
                    'name' => $req->name,
                    'jenis_kelamin' => $req->jenis_kelamin,
                    'nis' => $req->nis,
                    'id_kelas' => $req->id_kelas,
                    'updated_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil update data siswa'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS siswa telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        } else {
            $cek = DB::table('siswas')->where('nis', $req->nis)->first();
            if(!$cek) {
                DB::table('siswas')->insert([
                    'name' => $req->name,
                    'jenis_kelamin' => $req->jenis_kelamin,
                    'nis' => $req->nis,
                    'id_kelas' => $req->id_kelas,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil input data siswa'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS siswa telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        }
    }
}
