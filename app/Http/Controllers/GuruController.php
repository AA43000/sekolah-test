<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index(Request $req) {
        $data['title'] = 'Guru';

        $data['kelas'] = DB::table('kelas')->get();
        return view('guru', $data);
    }

    public function loadData(Request $req) {
        $data = DB::table('gurus')->get();

        return response()->json($data);
    }

    public function getData(Request $req) {
        $data['guru'] = DB::table('gurus')->where('id', $req->id)->first();
        $data['guru_kelas'] = DB::table('guru_kelas')->where('id_guru', $req->id)->get();

        return response()->json($data);
    }

    public function deleteData(Request $req) {
        $cek = DB::table('gurus')->where('id', $req->id)->first();
        if($cek) {
            DB::table('gurus')->where('id', $req->id)->delete();
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
            $cek = DB::table('gurus')->where('nip', $req->nip)->where('id', '!=', $req->id)->first();
            if(!$cek) {
                DB::table('gurus')->where('id', $req->id)->update([
                    'name' => $req->name,
                    'jenis_kelamin' => $req->jenis_kelamin,
                    'mata_pelajaran' => $req->mata_pelajaran,
                    'nip' => $req->nip,
                    'updated_at' => now()
                ]);

                $this->proses_kelas($req->id_kelas, $req->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil update data guru'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS guru telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        } else {
            $cek = DB::table('gurus')->where('nip', $req->nip)->first();
            if(!$cek) {
                $id_guru = DB::table('gurus')->insertgetId([
                    'name' => $req->name,
                    'jenis_kelamin' => $req->jenis_kelamin,
                    'mata_pelajaran' => $req->mata_pelajaran,
                    'nip' => $req->nip,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $this->proses_kelas($req->id_kelas, $id_guru);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil input data guru'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'NIS guru telah dipakai, silahkan coba lainnya!!'
                ]);
            }
        }
    }

    public function proses_kelas($id_kelas, $id_guru) {
        DB::table('guru_kelas')
            ->where('id_guru', $id_guru)
            ->whereNotIn('id_kelas', $id_kelas)
            ->delete();

        foreach($id_kelas as $kelas) {
            DB::table('guru_kelas')->updateOrInsert(
                ['id_kelas' => $kelas, 'id_guru' => $id_guru]
            );
        }
    }
}
