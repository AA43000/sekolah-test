<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $req) {
        $data['title'] = 'Dashboard';
        $data['kelas'] = DB::table('kelas')->get();
        $data['bg'] = [
            0 => 'bg-primary',
            1 => 'bg-secondary',
            2 => 'bg-success',
            3 => 'bg-danger',
        ];
        $data['data1'] = DB::table('siswas')
            ->select('siswas.name as nama_siswa', 'kelas.name as nama_kelas')
            ->leftJoin('kelas', 'kelas.id', '=', 'siswas.id_kelas')
            ->get();
        $data['data2'] = DB::table('gurus')
            ->select('gurus.name as nama_guru', 'kelas.name as nama_kelas')
            ->leftJoin('guru_kelas', 'guru_kelas.id_guru', '=', 'gurus.id')
            ->leftJoin('kelas', 'kelas.id', '=', 'guru_kelas.id_kelas')
            ->get();
        $data['data3'] = DB::table('siswas')
            ->select('siswas.name as nama_siswa', 'gurus.name as nama_guru', 'kelas.name as nama_kelas')
            ->leftJoin('guru_kelas', 'guru_kelas.id_kelas', '=', 'siswas.id_kelas')
            ->leftJoin('kelas', 'kelas.id', '=', 'guru_kelas.id_kelas')
            ->leftJoin('gurus', 'gurus.id', '=', 'guru_kelas.id_guru')
            ->get();
        return view('dashboard', $data);
    }

    public function loadGuru(Request $req) {
        $data = DB::table('gurus')->select('gurus.name', 'gurus.mata_pelajaran')->leftJoin('guru_kelas', 'guru_kelas.id_guru', '=', 'gurus.id')->where('guru_kelas.id_kelas', $req->id_kelas)->get();

        return response()->json($data);
    }

    public function loadSiswa(Request $req) {
        $data = DB::table('siswas')->where('id_kelas', $req->id_kelas)->get();

        return response()->json($data);
    }
}
