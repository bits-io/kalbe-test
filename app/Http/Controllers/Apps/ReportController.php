<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', now()->format('Y-m'));
        $outlets = $request->input('outlets', []);

        // Validate input
        if (!$this->validateInput($periode, $outlets)) {
            return redirect()->back()->withErrors(['error' => 'Periode atau Outlet tidak valid.']);
        }

        // Query report data
        $reportData = $this->queryData($periode, $outlets);

        // Export to Excel
        if ($request->has('export')) {
            return Excel::download(new ReportExport($reportData), 'report.xlsx');
        }

        // Get outlet list
        $outlets = Outlet::all();

        return view('report.index', compact('reportData', 'periode', 'outlets'));
    }

    private function validateInput($periode, $outlets)
    {
        return preg_match('/^\d{4}-\d{2}$/', $periode) && is_array($outlets);
    }

    private function queryData($periode, $outlets)
    {
        $startDate = "{$periode}-01"; // Awal bulan
        $endDate = date("Y-m-t", strtotime($startDate)); // Akhir bulan

        return DB::table('sales_transactions as st')
            ->join('outlets as o', 'st.OutletID', '=', 'o.OutletID')
            ->join('salesmen as s', 'st.SalesmanID', '=', 's.SalesmanID')
            ->selectRaw(<<<SQL
                DATE_FORMAT(st.TransactionDate, '%Y-%m') AS Periode,
                o.OutletName,
                o.Region,
                s.SalesmanID,
                s.SalesmanName,
                COUNT(DISTINCT st.OutletID) AS JumlahOutlet,
                SUM(st.Subtotal) AS Penjualan,
                COUNT(st.InvoiceID) AS JumlahTransaksi,
                COUNT(DISTINCT CASE WHEN st.OutletID IN (
                    SELECT OutletID
                    FROM sales_transactions
                    WHERE TransactionDate BETWEEN ? AND ?
                    GROUP BY OutletID
                    HAVING COUNT(*) >= 3
                ) THEN st.OutletID END) AS JumlahOutlet3xTrans
            SQL, [$startDate, $endDate])
            ->whereRaw("DATE_FORMAT(st.TransactionDate, '%Y-%m') = ?", [$periode])
            ->whereIn('o.OutletID', $outlets)
            ->groupBy('Periode', 'o.OutletName', 'o.Region', 's.SalesmanID', 's.SalesmanName')
            ->get();
    }
}
