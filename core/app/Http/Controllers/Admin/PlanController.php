<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Referral;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Subscription Plan';
        $levels = Referral::max('level');
        $plans = Plan::get();
        return view('admin.plan',compact('pageTitle','levels','plans'));
    }

    public function savePlan(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'daily_limit' => 'required|numeric|min:1',
            'ref_level' => 'required|numeric|min:0',
            'validity' => 'required|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->id == 0){
            $plan = new Plan();
        }else{
            $plan = Plan::findOrFail($request->id);
        }
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->daily_limit = $request->daily_limit;
        $plan->ref_level = $request->ref_level;
        $plan->validity = $request->validity;
        $plan->status = isset($request->status) ? 1:0;

        if($request->hasFile('image')){
            $plan->image = fileUploader($request->image, 'assets/images/plan', null, @$plan->image);
        }

        $plan->save();

        $notify[] = ['success', 'Plan has been Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $plan = Plan::findOrFail($id);
        if($plan->image){
            fileManager()->removeFile('assets/images/plan/' . $plan->image);
        }
        $plan->delete();
        $notify[] = ['success', 'Plan deleted successfully.'];
        return back()->withNotify($notify);
    }

    public function subscriptions(Request $request)
    {
        $pageTitle = "User's Plans";
        
        $subscriptions = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with(['user', 'user.plan'])
            ->whereHas('user') // Only show subscriptions where user exists
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $subscriptions = $subscriptions->whereHas('user', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $subscriptions = $subscriptions->whereHas('user', function ($query) {
                    $query->whereNotNull('plan_id')
                          ->where('expire_date', '>', now());
                });
            } elseif ($request->status == 'expired') {
                $subscriptions = $subscriptions->whereHas('user', function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('plan_id')
                          ->orWhere('expire_date', '<=', now());
                    });
                });
            }
        }

        $subscriptions = $subscriptions->paginate(getPaginate());

        return view('admin.plan_subscriptions', compact('pageTitle', 'subscriptions'));
    }

    public function subscriptionDetails($id)
    {
        $subscription = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with('user')
            ->findOrFail($id);

        // Extract plan name from transaction details
        preg_match('/Subscribe\s+(.+?)\s+Plan/', $subscription->details, $matches);
        $planName = $matches[1] ?? 'Plan';
        
        $plan = Plan::where('name', $planName)->first();
        
        $validity = $plan ? $plan->validity : 30;
        $dailyLimit = $plan ? $plan->daily_limit : 0;
        
        $expireDate = \Carbon\Carbon::parse($subscription->created_at)->addDays($validity);
        $isActive = $subscription->user->expire_date && $subscription->user->expire_date > now();

        $data = [
            'subscription' => $subscription,
            'plan_name' => $planName,
            'validity' => $validity,
            'daily_limit' => $dailyLimit,
            'expire_date' => $expireDate,
            'is_active' => $isActive,
            'user' => $subscription->user
        ];

        return response()->json($data);
    }

    public function updateSubscription(Request $request, $id)
    {
        $request->validate([
            'validity' => 'required|numeric|min:1',
            'daily_limit' => 'required|numeric|min:0',
        ]);

        $subscription = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with('user')
            ->findOrFail($id);

        $user = $subscription->user;
        
        // Update user's plan settings
        $user->daily_limit = $request->daily_limit;
        $user->expire_date = \Carbon\Carbon::parse($subscription->created_at)->addDays($request->validity);
        $user->save();

        $notify[] = ['success', 'Subscription updated successfully'];
        return back()->withNotify($notify);
    }

    public function deactivateSubscription($id)
    {
        $subscription = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with('user')
            ->findOrFail($id);

        $user = $subscription->user;
        $user->plan_id = null;
        $user->expire_date = now();
        $user->daily_limit = 0;
        $user->save();

        $notify[] = ['success', 'Subscription deactivated successfully'];
        return back()->withNotify($notify);
    }

    public function deleteSubscription($id)
    {
        $subscription = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->findOrFail($id);

        $subscription->delete();

        $notify[] = ['success', 'Subscription deleted successfully'];
        return back()->withNotify($notify);
    }

    public function activeSubscriptions(Request $request)
    {
        $pageTitle = "Active Plans";
        
        $subscriptions = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with(['user', 'user.plan'])
            ->whereHas('user', function ($query) {
                $query->whereNotNull('plan_id')
                      ->where('expire_date', '>', now());
            })
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $subscriptions = $subscriptions->whereHas('user', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $subscriptions->paginate(getPaginate());

        return view('admin.plan_subscriptions', compact('pageTitle', 'subscriptions'));
    }

    public function completedSubscriptions(Request $request)
    {
        $pageTitle = "Completed Plans";
        
        $subscriptions = \App\Models\Transaction::where('remark', 'subscribe_plan')
            ->with(['user', 'user.plan'])
            ->whereHas('user', function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('plan_id')
                      ->orWhere('expire_date', '<=', now());
                });
            })
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $subscriptions = $subscriptions->whereHas('user', function ($query) use ($search) {
                $query->where('username', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $subscriptions->paginate(getPaginate());

        return view('admin.plan_subscriptions', compact('pageTitle', 'subscriptions'));
    }
}
