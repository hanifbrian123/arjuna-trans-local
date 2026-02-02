<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        return view('admin.expense_categories.index', [
            'categories' => ExpenseCategory::orderBy('code')->get(),
            'colors' => ['#7C4DFF', '#00C853', '#00B8D4', '#FF6D00', '#FF5252', '#536DFE', '#FFC400', '#FFAB00', '#26A69A', '#546E7A']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:expense_categories,code',
            'name' => 'required',
            'pallete' => 'required'
        ]);

        ExpenseCategory::create($request->only('code', 'name', 'pallete'));

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        ExpenseCategory::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:expense_categories,code,' . $id,
            'name' => 'required',
            'pallete' => 'required',
        ]);

        $category = ExpenseCategory::findOrFail($id);
        $category->update($request->only('code', 'name', 'pallete'));

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }
}
