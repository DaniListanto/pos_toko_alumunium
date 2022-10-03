<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Carbon\Carbon;
use App\User;
use App\Acces;
use App\Market;
use App\Supply;
use App\Transaction;
use Illuminate\Http\Request;

class ReportManageController extends Controller
{
    // Show View Report Transaction
    public function reportTransaction()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_laporan == 1) {
            $transactions = Transaction::all();
            $array = [];
            foreach ($transactions as $no => $transaction) {
                array_push(
                    $array,
                    $transactions[$no]->created_at->toDateString()
                );
            }
            $dates = array_unique($array);
            rsort($dates);

            $arr_ammount = count($dates);
            $incomes_data = [];
            if ($arr_ammount > 7) {
                for ($i = 0; $i < 7; $i++) {
                    array_push($incomes_data, $dates[$i]);
                }
            } elseif ($arr_ammount > 0) {
                for ($i = 0; $i < $arr_ammount; $i++) {
                    array_push($incomes_data, $dates[$i]);
                }
            }
            $incomes = array_reverse($incomes_data);

            return view(
                'report.report_transaction',
                compact('dates', 'incomes')
            );
        } else {
            return back();
        }
    }

    // Filter Report Transaction
    public function filterTransaction(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_laporan == 1) {
            $start_date = $req->tgl_awal;
            $end_date = $req->tgl_akhir;
            $start_date2 =
                $start_date[6] .
                $start_date[7] .
                $start_date[8] .
                $start_date[9] .
                '-' .
                $start_date[3] .
                $start_date[4] .
                '-' .
                $start_date[0] .
                $start_date[1] .
                ' 00:00:00';
            $end_date2 =
                $end_date[6] .
                $end_date[7] .
                $end_date[8] .
                $end_date[9] .
                '-' .
                $end_date[3] .
                $end_date[4] .
                '-' .
                $end_date[0] .
                $end_date[1] .
                ' 23:59:59';
            $supplies = Transaction::select()
                ->whereBetween('created_at', [$start_date2, $end_date2])
                ->get();
            $array = [];
            foreach ($supplies as $no => $supply) {
                array_push($array, $supplies[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);

            return view('report.report_transaction_filter', compact('dates'));
        } else {
            return back();
        }
    }

    // Export Transaction Report
    public function exportTransaction(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('user', $id_account)->first();
        if ($check_access->kelola_laporan == 1) {
            $jenis_laporan = $req->jns_laporan;
            $current_time = Carbon::now()->isoFormat('Y-MM-DD') . ' 23:59:59';
            if ($jenis_laporan == 'period') {
                if ($req->period == 'minggu') {
                    $last_time =
                        Carbon::now()
                            ->subWeeks($req->time)
                            ->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                        ->whereBetween('created_at', [
                            $last_time,
                            $current_time,
                        ])
                        ->get();
                    $array = [];
                    foreach ($transactions as $no => $transaction) {
                        array_push(
                            $array,
                            $transactions[$no]->created_at->toDateString()
                        );
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                } elseif ($req->period == 'bulan') {
                    $last_time =
                        Carbon::now()
                            ->subMonths($req->time)
                            ->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                        ->whereBetween('created_at', [
                            $last_time,
                            $current_time,
                        ])
                        ->get();
                    $array = [];
                    foreach ($transactions as $no => $transaction) {
                        array_push(
                            $array,
                            $transactions[$no]->created_at->toDateString()
                        );
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                } elseif ($req->period == 'tahun') {
                    $last_time =
                        Carbon::now()
                            ->subYears($req->time)
                            ->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $transactions = Transaction::select('transactions.*')
                        ->whereBetween('created_at', [
                            $last_time,
                            $current_time,
                        ])
                        ->get();
                    $array = [];
                    foreach ($transactions as $no => $transaction) {
                        array_push(
                            $array,
                            $transactions[$no]->created_at->toDateString()
                        );
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }
            } else {
                $start_date = $req->tgl_awal_export;
                $end_date = $req->tgl_akhir_export;
                $start_date2 =
                    $start_date[6] .
                    $start_date[7] .
                    $start_date[8] .
                    $start_date[9] .
                    '-' .
                    $start_date[3] .
                    $start_date[4] .
                    '-' .
                    $start_date[0] .
                    $start_date[1] .
                    ' 00:00:00';
                $end_date2 =
                    $end_date[6] .
                    $end_date[7] .
                    $end_date[8] .
                    $end_date[9] .
                    '-' .
                    $end_date[3] .
                    $end_date[4] .
                    '-' .
                    $end_date[0] .
                    $end_date[1] .
                    ' 23:59:59';
                $transactions = Transaction::select('transactions.*')
                    ->whereBetween('created_at', [$start_date2, $end_date2])
                    ->get();
                $array = [];
                foreach ($transactions as $no => $transaction) {
                    array_push(
                        $array,
                        $transactions[$no]->created_at->toDateString()
                    );
                }
                $dates = array_unique($array);
                rsort($dates);
                $tgl_awal = $start_date2;
                $tgl_akhir = $end_date2;
            }
            $market = Market::first();

            $pdf = PDF::loadview(
                'report.export_report_transaction',
                compact('dates', 'tgl_awal', 'tgl_akhir', 'market')
            );
            return $pdf->stream();
        } else {
            return back();
        }
    }
}