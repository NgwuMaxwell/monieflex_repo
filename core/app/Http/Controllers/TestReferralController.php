<?php

namespace App\Http\Controllers;

use App\Services\ReferralCommissionService;
use Illuminate\Http\Request;

class TestReferralController extends Controller
{
    public function testCommission()
    {
        // Get a user with a referrer
        $user = \App\Models\User::where('ref_by', '!=', null)->first();
        
        if (!$user) {
            return response()->json(['error' => 'No users with referrers found'], 404);
        }
        
        $referrer = \App\Models\User::find($user->ref_by);
        
        // Test the ReferralCommissionService
        $commissionService = new ReferralCommissionService();
        
        // Test deposit commission
        $result1 = $commissionService->awardCommission($user, 'deposit', 1000, null, 'TEST_DEPOSIT_' . time());
        
        // Test PTC view commission
        $result2 = $commissionService->awardCommission($user, 'ptc_view', 100, null, 'TEST_PTC_' . time());
        
        // Test plan subscription commission
        $result3 = $commissionService->awardCommission($user, 'plan_subscription', 5000, null, 'TEST_PLAN_' . time());
        
        return response()->json([
            'user' => $user->username,
            'referrer' => $referrer->username,
            'deposit_commission' => $result1 ? 'SUCCESS' : 'FAILED',
            'ptc_commission' => $result2 ? 'SUCCESS' : 'FAILED',
            'plan_commission' => $result3 ? 'SUCCESS' : 'FAILED',
            'timestamp' => now()
        ]);
    }
    
    public function checkState()
    {
        $referralTransactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->count();
        
        $data = [
            'referral_transactions' => $referralTransactions,
            'transactions' => []
        ];
        
        if ($referralTransactions > 0) {
            $transactions = \App\Models\Transaction::where('wallet', 'referral_bonus')->get();
            foreach ($transactions as $transaction) {
                $data['transactions'][] = [
                    'user_id' => $transaction->user_id,
                    'amount' => $transaction->amount,
                    'details' => $transaction->details,
                    'trx' => $transaction->trx
                ];
            }
        }
        
        // Check admin settings
        $general = \App\Models\GeneralSetting::first();
        if ($general) {
            $data['admin_settings'] = [
                'deposit_commission' => $general->deposit_commission,
                'plan_subscribe_commission' => $general->plan_subscribe_commission,
                'ptc_view_commission' => $general->ptc_view_commission,
                'signup_commission' => $general->signup_commission
            ];
        }
        
        // Check referral settings
        $referralSettings = \App\Models\Referral::all();
        $data['referral_settings'] = $referralSettings->map(function($setting) {
            return [
                'commission_type' => $setting->commission_type,
                'level' => $setting->level,
                'percent' => $setting->percent
            ];
        });
        
        return response()->json($data);
    }
}