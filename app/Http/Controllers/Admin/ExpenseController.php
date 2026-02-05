<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->datatables($request);
        }

        $vehicles = Vehicle::all();
        $expense_categories = ExpenseCategory::all();
        $expenses_data = Expense::all();
        return view('admin.expenses.index', compact('vehicles', 'expense_categories', 'expenses_data'));
    }

    public function datatables(Request $request)
    {
        $query = Expense::leftJoin('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->select('expenses.*', 'expense_categories.code as category_code', 'expense_categories.name as category_name', 'expense_categories.pallete as pallete');

        // Filter Armada (via many-to-many)
        if ($request->vehicle_id) {
            $query->whereHas('vehicles', function($q) use ($request) {
                $q->where('vehicles.id', $request->vehicle_id);
            });
        }

        // Filter Category
        if ($request->category_code) {
            $query->where('expense_categories.code', $request->category_code);
        }

        // Filter tanggal
        Log::info('debug filter', [$request->start_date , $request->end_date]);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('expenses.date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('date', fn($row) => $row->date)
            ->addColumn('vehicle', function($row) {
                $vehicleNames = $row->vehicles->pluck('name')->join(', ');
                return "
                    <div class='d-flex flex-column'>
                        <span class='fw-semibold text-primary'>{$vehicleNames}</span>
                    </div>
                ";
            })
            ->addColumn('category', function($row) {
                if (!$row->category_code) {
                    return "<span class='badge bg-secondary px-2 py-2'>NULL</span>";
                }
                $color = $row->pallete;
                return "
                    <div class='d-flex align-items-center gap-2'>
                        <span class='badge px-2 py-2' style='background: {$color}; color: white;'>{$row->category_code}</span>
                        <span>{$row->category_name}</span>
                    </div>
                ";
            })
            ->addColumn('description', function($row) {
                return "<span class='fst-italic text-muted'>{$row->description}</span>";
            })
            ->addColumn('nominal', function($row) {
                return "<span class='fw-semibold'>Rp " . number_format($row->nominal, 0, ',', '.') . "</span>";
            })
            ->addColumn('action', function($row){
                return view('admin.expenses.partials.actions', compact('row'))->render();
            })
            ->filter(function($query) use ($request) {
                $search = $request->get('search')['value'] ?? null;

                if ($search) {
                    $query->where(function($q) use ($search) {
                        // Search category code OR name
                        $q->where('expense_categories.code', 'like', "%{$search}%")
                        ->orWhere('expense_categories.name', 'like', "%{$search}%")
                        ->orWhere('expenses.nominal', 'like', "%{$search}%")
                        ->orWhere('expenses.description', 'like', "%{$search}%")
                        ->orWhere('expenses.date', 'like', "%{$search}%")
                        // Search vehicles via whereHas
                        ->orWhereHas('vehicles', function($q) use ($search) {
                            $q->where('vehicles.name', 'like', "%{$search}%");
                        });
                    });
                }
            })
            ->orderColumn('date', 'expenses.date $1')
            ->orderColumn('nominal', 'expenses.nominal $1')
            ->orderColumn('category', 'expense_categories.code $1')
            ->orderColumn('description', 'expenses.description $1')
            ->rawColumns(['vehicle', 'category', 'description', 'nominal', 'action'])
            ->make(true);
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $expense_categories = ExpenseCategory::all();

        return view('admin.expenses.create', compact('vehicles', 'expense_categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'vehicle_id' => 'required|array',
            'vehicle_id.*' => 'exists:vehicles,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'nominal' => 'required',
            'description' => 'nullable|string',
        ]);

        // PARSE RUPIAH KE ANGKA MURNI
        $nominal = (int) preg_replace('/[^0-9]/', '', $request->nominal);

        $expense = Expense::create([
            'date' => $request->date,
            'expense_category_id' => $request->expense_category_id,
            'nominal' => $nominal,
            'description' => $request->description,
        ]);

        // Attach multiple vehicles via many-to-many
        if ($request->vehicle_id) {
            $expense->vehicles()->attach($request->vehicle_id);
        }

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan.');
    }
    
    public function edit($id)
    {
        $expense = Expense::with(['vehicles', 'category'])->findOrFail($id);

        return view('admin.expenses.edit', [
            'expense' => $expense,
            'vehicles' => Vehicle::all(),
            'expense_categories' => ExpenseCategory::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'vehicle_id' => 'required|array',
            'vehicle_id.*' => 'exists:vehicles,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'nominal' => 'required',
            'description' => 'nullable|string',
        ]);

        $expense = Expense::findOrFail($id);

        // Normalisasi Rupiah ke angka
        $nominal = (int) preg_replace('/[^0-9]/', '', $request->nominal);

        $expense->update([
            'date' => $request->date,
            'expense_category_id' => $request->expense_category_id,
            'nominal' => $nominal,
            'description' => $request->description,
        ]);

        // Sync multiple vehicles via many-to-many
        if ($request->vehicle_id) {
            $expense->vehicles()->sync($request->vehicle_id);
        }

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }


    public function filterData(Request $request)
    {
        $query = Expense::leftJoin('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->select('expenses.*', 'expense_categories.code as category_code', 'expense_categories.name as category_name');
        
        // Filter Armada (via many-to-many)
        if ($request->vehicle_id) {
            $query->whereHas('vehicles', function($q) use ($request) {
                $q->where('vehicles.id', $request->vehicle_id);
            });
        }
            
        // Filter Category
        if ($request->category_code) {
            $query->where('expense_categories.code', $request->category_code);
        }

        // Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('expenses.date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $expenses = $query->get();

        // SUMMARY
        $totalExpense = $expenses->sum('nominal');
        
        // Count distinct vehicles across all filtered expenses
        $totalVehicles = $expenses->flatMap(function($expense) {
            return $expense->vehicles->pluck('id');
        })->unique()->count();
        
        $avgPerVehicle = $totalVehicles > 0 ? $totalExpense / $totalVehicles : 0;

        // PIE CHART (by category)
        $categorySummary = $expenses->groupBy('expense_category_id')
            ->map(function ($g, $key) {
                $category = $g->first()->category;

                return [
                    'name'  => $category?->name ?? 'Uncategorized',
                    'code'  => $category?->code ?? 'NONE',
                    'color' => $category?->pallete ?? '#9ca3af', // gray default
                    'total' => $g->sum('nominal'),
                ];
            })
            ->values();

        // BAR CHART (by vehicle) - group by vehicle across all expenses
        $vehicleNominals = [];
        foreach ($expenses as $expense) {
            foreach ($expense->vehicles as $vehicle) {
                if (!isset($vehicleNominals[$vehicle->id])) {
                    $vehicleNominals[$vehicle->id] = [
                        'name' => $vehicle->name,
                        'total' => 0,
                    ];
                }
                $vehicleNominals[$vehicle->id]['total'] += $expense->nominal;
            }
        }
        $vehicleSummary = collect($vehicleNominals)->values();
        
        return response()->json([
            'summary' => [
                'total' => $totalExpense,
                'totalVehicles' => $totalVehicles,
                'avgPerVehicle' => $avgPerVehicle,
            ],
            'categories' => $categorySummary,
            'vehicles' => $vehicleSummary,
        ]);
    }


}
