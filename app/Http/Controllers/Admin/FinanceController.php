<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Expense;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Exports\FinanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    public function index()
    {
        return view('admin.finance.index');
    }
    
    // DataTables: Income + Expense transactions.
    public function transactions(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // Income
        $incomeQuery = Order::selectRaw("
            start_date AS date,
            name AS description,
            order_num AS code,
            CASE 
                WHEN status = 'approved' THEN rental_price
                ELSE rental_price - remaining_cost
            END AS income,
            0 AS expense
        ")->whereIn('status', ['approved', 'waiting']);

        if ($start && $end) {
            $incomeQuery->whereBetween('start_date', [$start, $end]);
        }

        // Expense
        $expenseQuery = Expense::leftJoin('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->selectRaw("
                expenses.date AS date,
                expenses.description AS description,
                CONCAT(expense_categories.code, ' - ', expense_categories.name) AS code,
                0 AS income,
                expenses.nominal AS expense
            ");

        if ($start && $end) {
            $expenseQuery->whereBetween('expenses.date', [$start, $end]);
        }

        // UNION
        $union = $incomeQuery->unionAll($expenseQuery);

        // QUERY AS SUBQUERY
        $finalQuery = DB::query()
            ->fromSub($union, 'trx')
            ->orderBy('date', 'desc');

        // GET ALL DATA
        $records = $finalQuery->get();

        // RUNNING BALANCE
        $running = 0;
        $records = $records->map(function($row) use (&$running) {

            $net = floatval($row->income) - floatval($row->expense);
            $running += $net;

            $row->running_total = $running;
            return $row;
        });

        // DATATABLES
        return datatables()->collection($records)
            ->addIndexColumn()
            ->editColumn('date', fn($r) => date('Y-m-d', strtotime($r->date)))
            ->editColumn('income', fn($r) =>
                $r->income == 0 ? '-' : 'Rp ' . number_format($r->income, 0, ',', '.')
            )
            ->editColumn('expense', fn($r) =>
                $r->expense == 0 ? '-' : 'Rp ' . number_format($r->expense, 0, ',', '.')
            )
            ->addColumn('total', fn($r) =>
                ($r->running_total >= 0 ? 'Rp ' : '- Rp ') .
                number_format(abs($r->running_total), 0, ',', '.')
            )
            ->rawColumns(['total'])
            ->make(true);
    }


    // Summary Cards: total income, total expense, profit/loss.
    public function summary(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        
        // Income
        $incomeQuery = Order::query();
        
        
        // Only include approved and waiting orders
        $incomeQuery->whereIn('status', ['approved', 'waiting']);
        
        if ($startDate && $endDate) {
            $incomeQuery->whereBetween('start_date', [$startDate, $endDate]);
        }
        
        $totalIncome = $incomeQuery->get()->sum(function ($o) {
            return ($o->status === 'approved') ? $o->rental_price : ($o->rental_price - $o->remaining_cost);
        });

        // Expense
        $expenseQuery = Expense::query();
        if ($startDate && $endDate) {
            $expenseQuery->whereBetween('date', [$startDate, $endDate]);
        }
        $totalExpense = $expenseQuery->sum('nominal');
        
        return response()->json([
            "total_income"  => $totalIncome,
            "total_expense" => $totalExpense,
            "profit"        => $totalIncome - $totalExpense,
        ]);
    }


    public function getFinanceData(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;

        // Income
        $incomeQuery = Order::selectRaw("
            start_date AS date,
            name AS description,
            order_num AS code,
            CASE 
                WHEN status = 'approved' THEN rental_price
                ELSE rental_price - remaining_cost
            END AS income,
            0 AS expense
        ")->whereIn('status', ['approved', 'waiting']);


        if ($start && $end) {
            $incomeQuery->whereBetween('start_date', [$start, $end]);
        }

        // Expense
        $expenseQuery = Expense::leftJoin('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->selectRaw("
                expenses.date AS date,
                expenses.description AS description,
                CONCAT(expense_categories.code, ' - ', expense_categories.name) AS code,
                0 AS income,
                expenses.nominal AS expense
            ");

        if ($start && $end) {
            $expenseQuery->whereBetween('expenses.date', [$start, $end]);
        }

        // UNION FINAL
        $union = $incomeQuery->unionAll($expenseQuery);

        $finalQuery = DB::query()
            ->fromSub($union, 'trx')
            ->orderBy('date', 'asc');

        // GET all (NO pagination)
        $records = $finalQuery->get();

        // Running Balance
        $running = 0;
        $records = $records->map(function ($row) use (&$running) {
            $net = floatval($row->income) - floatval($row->expense);
            $running += $net;
            $row->running_total = $running;
            return $row;
        });

        // Summary
        $totalIncome  = $records->sum('income');
        $totalExpense = $records->sum('expense');
        $profit       = $totalIncome - $totalExpense;

        return [
            "transactions"  => $records,
            "total_income"  => $totalIncome,
            "total_expense" => $totalExpense,
            "profit"        => $profit,
        ];
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getFinanceData($request);

        return Excel::download(new FinanceExport($data), 'laporan_keuangan.xlsx');
    }
    
    public function exportPdf(Request $request)
    {
        $data = $this->getFinanceData($request);

        $pdf = Pdf::loadView('admin.finance.export_pdf', $data)
                ->setPaper('A4', 'portrait');

        return $pdf->download('laporan_keuangan.pdf');
    }
}
