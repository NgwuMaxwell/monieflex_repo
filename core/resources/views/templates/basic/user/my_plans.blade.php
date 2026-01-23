<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name = "introduction" content = "no-reference">
<title>{{ $general->siteName(__($pageTitle)) }}</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #f8f8f8; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #f8f8f8; background-size: 100% 100%; padding-top: 50px; padding-bottom: 100px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 50px; padding: 0 15px; background: #3244a8; display: flex; flex-direction: row; align-items: center; justify-content: space-between; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .back-btn { width: 25px; height: 25px; cursor: pointer; }
    .header .back-btn i { color: #fff; font-size: 20px; }
    .header span { font-size: 16px; line-height: 50px; font-weight: 400; color: #fff; }
    
    .container { width: 100%; max-width: 991px; padding: 15px; }

    .plan-card { width: 100%; background-color: #fff; border-radius: 10px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .plan-card .header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px; }
    .plan-card .plan-name { font-size: 18px; font-weight: 700; color: #3244a8; }
    .plan-card .status-badge { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .plan-card .status-badge.active { background-color: #28a745; color: #fff; }
    .plan-card .status-badge.expired { background-color: #dc3545; color: #fff; }
    .plan-card .status-badge.completed { background-color: #6c757d; color: #fff; }
    
    .plan-details { margin-top: 10px; }
    .plan-detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee; }
    .plan-detail-row:last-child { border-bottom: none; }
    .plan-detail-row .label { font-size: 14px; color: #666; }
    .plan-detail-row .value { font-size: 14px; font-weight: 600; color: #151515; }
    .plan-detail-row .value.price { color: #3244a8; font-size: 16px; }
    
    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state img { width: 120px; height: 120px; margin-bottom: 20px; opacity: 0.5; }
    .empty-state h5 { font-size: 18px; font-weight: 600; color: #666; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; color: #999; margin-bottom: 20px; }
    .empty-state .btn-browse { background: linear-gradient(90deg,#9169f3,#7843f5); color: #fff; padding: 10px 30px; border-radius: 25px; text-decoration: none; display: inline-block; }

    .footer-nav { width: 100%; max-width: 991px; height: 100px; transform: translateX(-50%); position: fixed; left: 50%; bottom: 0; z-index: 100; }
    .footer-nav .footer-nav-bg { width: 100%; height: 100%; position: absolute; left: 0; top: 0; }
    .footer-nav .nav-set { width: 100%; height: 56px; position: absolute; left: 0; bottom: 6px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .footer-nav .nav-set .nav { width: 20%; height: 56px; padding: 4px 0 2px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; cursor: pointer; }
    .footer-nav .nav-set .nav img { width: 24px; height: 24px; filter: brightness(1000%); }
    .footer-nav .nav-set .nav span { font-size: 14px; line-height: 14px; font-weight: 400; color: #fff; margin-bottom: 0; }
    .footer-nav .nav-set .nav.center { position: relative; }
    .footer-nav .nav-set .nav.center .circle { width: 60px; height: 60px; background-color: #3244a8; border-radius: 100%; display: flex; align-items: center; justify-content: center; position: absolute; top: -35px; }
    .footer-nav .nav-set .nav.center span { position: absolute; bottom: 2px; }
    .footer-nav .nav-set .nav.active img { filter: brightness(100%); }
    .footer-nav .nav-set .nav.active span { color: rgb(255, 162, 0); }
</style>

</head>

<body>
    <div class="header">
        <div class="back-btn" onclick="window.location.href='{{ route('user.profile.setting') }}'">
            <i class="bi bi-arrow-left"></i>
        </div>
        <span>My Plans</span>
        <div style="width: 25px;"></div>
    </div>
    
    <div class="page">
        <div class="container">
            @if($planHistory->count() > 0)
                @foreach($planHistory as $history)
                    @php
                        // Get plan ID from plan name for the progress link
                        $planForProgress = \App\Models\Plan::where('name', $history->plan_name)->first();
                        $planId = $planForProgress ? $planForProgress->id : 1;
                    @endphp
                    <div class="plan-card">
                        <div class="header-row">
                            <div class="plan-name">{{ __($history->plan_name) }}</div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="status-badge {{ $history->status_class }}">{{ $history->status_text }}</div>
                                <a href="{{ route('user.plan.progress', $planId) }}" class="btn btn-sm" style="background: #3244a8; color: #fff; border-radius: 20px; padding: 5px 15px; font-size: 12px; font-weight: 600; text-decoration: none;">
                                    <i class="fas fa-eye"></i> View Progress
                                </a>
                            </div>
                        </div>
                        
                        <div class="plan-details">
                            <div class="plan-detail-row">
                                <span class="label">Purchase Date</span>
                                <span class="value">{{ showDateTime($history->created_at, 'd M, Y') }}</span>
                            </div>
                            <div class="plan-detail-row">
                                <span class="label">Amount Paid</span>
                                <span class="value price">{{ showAmount($history->amount) }} {{ $general->cur_text }}</span>
                            </div>
                            <div class="plan-detail-row">
                                <span class="label">Validity Period</span>
                                <span class="value">{{ $history->validity }} Days</span>
                            </div>
                            @if($history->expire_date)
                            <div class="plan-detail-row">
                                <span class="label">
                                    @if($history->is_active)
                                        Expires On
                                    @else
                                        Expired On
                                    @endif
                                </span>
                                <span class="value">{{ showDateTime($history->expire_date, 'd M, Y') }}</span>
                            </div>
                            @endif
                            <div class="plan-detail-row">
                                <span class="label">Daily Task Limit</span>
                                <span class="value">{{ $history->daily_limit }}</span>
                            </div>
                            <div class="plan-detail-row">
                                <span class="label">Transaction ID</span>
                                <span class="value">{{ $history->trx }}</span>
                            </div>
                            <div class="plan-detail-row">
                                <span class="label">ROI Percentage</span>
                                <span class="value">{{ $history->roi_percentage }}%</span>
                            </div>
                            <div class="plan-detail-row">
                                <span class="label">Expected Total Profits</span>
                                <span class="value price">{{ showAmount($history->expected_total_profits) }} {{ $general->cur_text }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($originalPlanHistory->hasPages())
                    <div class="mt-4">
                        {{ paginateLinks($originalPlanHistory) }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox" style="font-size: 80px; color: #ccc;"></i>
                    <h5>No Plan Purchase History</h5>
                    <p>You haven't purchased any plans yet. Browse our available plans and get started!</p>
                    <a href="{{ route('plans') }}" class="btn-browse">Browse Plans</a>
                </div>
            @endif
        </div>
    </div>

    @include('partials.notify')
    @include($activeTemplate . 'partials.footers')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>
