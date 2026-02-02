<?php 
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class FinanceExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data; // data dari controller
    }

    public function view(): View
    {
        return view('admin.finance.export_excel', [
            'transactions' => $this->data['transactions'],
            'summary' => [
                'income' => $this->data['total_income'],
                'expense' => $this->data['total_expense'],
                'profit' => $this->data['profit']
            ]
        ]);
    }
}
