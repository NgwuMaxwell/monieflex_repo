<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositAmount;
use Illuminate\Http\Request;

class DepositAmountController extends Controller
{
    public function index()
    {
        $pageTitle = 'Deposit Amounts';
        $depositAmounts = DepositAmount::latest()->paginate(getPaginate());
        return view('admin.deposit_amounts.index', compact('pageTitle', 'depositAmounts'));
    }

    public function create()
    {
        $pageTitle = 'Add Deposit Amount';
        return view('admin.deposit_amounts.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        DepositAmount::create([
            'amount' => $request->amount,
            'status' => true,
        ]);

        $notify[] = ['success', 'Deposit amount added successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Deposit Amount';
        $depositAmount = DepositAmount::findOrFail($id);
        return view('admin.deposit_amounts.edit', compact('pageTitle', 'depositAmount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $depositAmount = DepositAmount::findOrFail($id);
        $depositAmount->amount = $request->amount;
        $depositAmount->save();

        $notify[] = ['success', 'Deposit amount updated successfully'];
        return back()->withNotify($notify);
    }

    public function destroy($id)
    {
        $depositAmount = DepositAmount::findOrFail($id);
        $depositAmount->delete();

        $notify[] = ['success', 'Deposit amount deleted successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $depositAmount = DepositAmount::findOrFail($id);
        $depositAmount->status = !$depositAmount->status;
        $depositAmount->save();

        $notify[] = ['success', 'Deposit amount status updated successfully'];
        return back()->withNotify($notify);
    }
}