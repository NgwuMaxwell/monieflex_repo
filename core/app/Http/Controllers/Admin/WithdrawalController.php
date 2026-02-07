<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = $this->withdrawalData('pending');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = $this->withdrawalData('approved');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = $this->withdrawalData('rejected');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals'));
    }

    public function log()
    {
        $pageTitle = 'Withdrawals Log';
        $withdrawalData = $this->withdrawalData($scope = null, $summery = true);
        $withdrawals = $withdrawalData['data'];
        $summery = $withdrawalData['summery'];
        $successful = $summery['successful'];
        $pending = $summery['pending'];
        $rejected = $summery['rejected'];


        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals','successful','pending','rejected'));
    }

    protected function withdrawalData($scope = null, $summery = false){
        if ($scope) {
            $withdrawals = Withdrawal::$scope();
        }else{
            $withdrawals = Withdrawal::where('status','!=',0);
        }

        $request = request();
        //search
        $search = $request->search;
        $withdrawals = $withdrawals->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like',"%$search%")
                ->orWhereHas('user', function ($user) use ($search) {
                    $user->where('username', 'like',"%$search%");
            });
        });


        //date search
        if($request->date) {
            $date = explode('-',$request->date);
            $request->merge([
                'start_date'=> trim(@$date[0]),
                'end_date'  => trim(@$date[1])
            ]);
            $request->validate([
                'start_date'    => 'required|date_format:m/d/Y',
                'end_date'      => 'nullable|date_format:m/d/Y'
            ]);
            if($request->end_date) {
                $endDate = Carbon::parse($request->end_date)->addHours(23)->addMinutes(59)->addSecond(59);
                $withdrawals   = $withdrawals->whereBetween('created_at', [Carbon::parse($request->start_date), $endDate]);
            }else{
                $withdrawals   = $withdrawals->whereDate('created_at', Carbon::parse($request->start_date));
            }
        }

        //via method
        if ($request->method) {
            $withdrawals = $withdrawals->where('method_id',$request->method);
        }
        if (!$summery) {
            return $withdrawals->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate());
        }else{

            $successful = clone $withdrawals;
            $pending = clone $withdrawals;
            $rejected = clone $withdrawals;

            $successfulSummery = $successful->where('status',1)->sum('amount');
            $pendingSummery = $pending->where('status',2)->sum('amount');
            $rejectedSummery = $rejected->where('status',3)->sum('amount');


            return [
                'data'=> $withdrawals->with(['user','method'])->orderBy('id','desc')->paginate(getPaginate()),
                'summery'=>[
                    'successful'=>$successfulSummery,
                    'pending'=>$pendingSummery,
                    'rejected'=>$rejectedSummery,
                ]
            ];
        }
    }

    public function details($id)
    {
        $general = gs();
        $withdrawal = Withdrawal::where('id',$id)->where('status', '!=', 0)->with(['user','method'])->firstOrFail();
        $pageTitle = $withdrawal->user->username.' Withdraw Requested ' . showAmount($withdrawal->amount) . ' '.$general->cur_text;
        $details = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;

        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal','details'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();
        
        $user = $withdraw->user;
        $walletType = $withdraw->wallet_type;
        
        // Calculate current balance for the selected wallet
        $currentBalance = 0;
        if ($walletType === 'profit_wallet') {
            // Calculate profit wallet balance from transactions
            $currentBalance = \App\Models\Transaction::where('user_id', $user->id)
                ->where('wallet', 'main_balance')
                ->sum(\Illuminate\Support\Facades\DB::raw("
                    CASE 
                        WHEN trx_type = '+' THEN amount
                        WHEN trx_type = '-' THEN -amount
                    END
                "));
        } elseif ($walletType === 'referral_bonus') {
            // Calculate referral bonus balance from transactions
            $currentBalance = \App\Models\Transaction::where('user_id', $user->id)
                ->where('wallet', 'referral_bonus')
                ->sum(\Illuminate\Support\Facades\DB::raw("
                    CASE 
                        WHEN trx_type = '+' THEN amount
                        WHEN trx_type = '-' THEN -amount
                    END
                "));
        }
        
        // Validate sufficient balance and prevent negative balance
        if ($withdraw->amount > $currentBalance) {
            $notify[] = ['error', 'Insufficient balance in ' . ($walletType === 'profit_wallet' ? 'Profit Wallet' : 'Referral Bonus Wallet') . '. Current balance: ' . showAmount($currentBalance)];
            return back()->withNotify($notify);
        }
        
        // Additional safety check: ensure withdrawal amount doesn't make balance negative
        $newBalance = $currentBalance - $withdraw->amount;
        if ($newBalance < 0) {
            $notify[] = ['error', 'Withdrawal would result in negative balance. Please reduce the withdrawal amount.'];
            return back()->withNotify($notify);
        }
        
        // Create debit transaction based on selected wallet type
        if ($walletType === 'profit_wallet') {
            // Debit profit wallet via transaction
            \App\Models\Transaction::create([
                'user_id'      => $user->id,
                'wallet'       => 'main_balance',
                'amount'       => $withdraw->amount,
                'charge'       => $withdraw->charge,
                'trx_type'     => '-',
                'details'      => 'Withdrawal approved: ' . $withdraw->trx,
                'trx'          => $withdraw->trx,
                'post_balance' => 0, // Not used for dynamic calculation
            ]);
        } elseif ($walletType === 'referral_bonus') {
            // Debit referral bonus wallet via transaction
            \App\Models\Transaction::create([
                'user_id'      => $user->id,
                'wallet'       => 'referral_bonus',
                'amount'       => $withdraw->amount,
                'charge'       => $withdraw->charge,
                'trx_type'     => '-',
                'details'      => 'Withdrawal approved: ' . $withdraw->trx,
                'trx'          => $withdraw->trx,
                'post_balance' => 0, // Not used for dynamic calculation
            ]);
        }
        
        // DEBUG: Log the transaction creation
        \Log::info('Withdrawal approved', [
            'withdrawal_id' => $withdraw->id,
            'user_id' => $user->id,
            'wallet_type' => $walletType,
            'amount' => $withdraw->amount,
            'current_balance' => $currentBalance,
            'new_balance' => $currentBalance - $withdraw->amount,
            'status_before' => $withdraw->status
        ]);
        
        $withdraw->status = 1;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal approved successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }


    public function reject(Request $request)
    {
        $general = gs();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id',$request->id)->where('status',2)->with('user')->firstOrFail();

        $withdraw->status = 3;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = $withdraw->user;
        $walletType = $withdraw->wallet_type;
        
        // DEBUG: Log the rejection
        \Log::info('Withdrawal rejected', [
            'withdrawal_id' => $withdraw->id,
            'user_id' => $user->id,
            'wallet_type' => $walletType,
            'amount' => $withdraw->amount,
            'status_before' => $withdraw->status
        ]);
        
        // Refund to the correct wallet via transaction
        if ($walletType === 'profit_wallet') {
            // Credit profit wallet via transaction
            \App\Models\Transaction::create([
                'user_id'      => $user->id,
                'wallet'       => 'main_balance',
                'amount'       => $withdraw->amount,
                'charge'       => 0,
                'trx_type'     => '+',
                'details'      => 'Withdrawal rejected: ' . $withdraw->trx,
                'trx'          => $withdraw->trx,
                'post_balance' => 0, // Not used for dynamic calculation
            ]);
        } elseif ($walletType === 'referral_bonus') {
            // Credit referral bonus wallet via transaction
            \App\Models\Transaction::create([
                'user_id'      => $user->id,
                'wallet'       => 'referral_bonus',
                'amount'       => $withdraw->amount,
                'charge'       => 0,
                'trx_type'     => '+',
                'details'      => 'Withdrawal rejected: ' . $withdraw->trx,
                'trx'          => $withdraw->trx,
                'post_balance' => 0, // Not used for dynamic calculation
            ]);
        }

        notify($user, 'WITHDRAW_REJECT', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'admin_details' => $request->details
        ]);

        $notify[] = ['success', 'Withdrawal rejected successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }

}
