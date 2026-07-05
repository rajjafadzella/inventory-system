<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. Menampilkan Laporan di Web
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $reports = $this->getReportData($startDate, $endDate);

        return view('reports.index', compact('reports', 'startDate', 'endDate'));
    }

    // 2. Export Data ke Excel (CSV format yang auto-open di Excel)
    public function export(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $reports = $this->getReportData($startDate, $endDate);

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=laporan-peminjaman.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Peminjam', 'Kode Barang', 'Nama Barang', 'Jumlah (Qty)', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'];

        $callback = function() use($reports, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan UTF-8 BOM agar Excel menampilkan karakter khusus/huruf dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Tulis header tabel
            fputcsv($file, $columns);

            // Tulis baris data
            foreach ($reports as $borrowing) {
                foreach ($borrowing->details as $detail) {
                    fputcsv($file, [
                        $borrowing->user->name,
                        $detail->product->code,
                        $detail->product->name,
                        $detail->qty,
                        $borrowing->borrow_date,
                        $borrowing->return_date ?? '-',
                        $borrowing->status,
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Fungsi pembantu untuk memfilter data
    private function getReportData($startDate, $endDate)
    {
        return Borrowing::with(['user', 'details.product'])
            ->when($startDate, function ($query, $startDate) {
                return $query->whereDate('borrow_date', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->whereDate('borrow_date', '<=', $endDate);
            })
            ->latest()
            ->get();
    }
}