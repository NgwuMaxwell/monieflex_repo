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

    .progress-card { width: 100%; background-color: #fff; border-radius: 10px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .progress-card .card-header { font-size: 18px; font-weight: 700; color: #3244a8; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #f1f1f1; }
    .progress-card .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #eee; }
    .progress-card .info-row:last-child { border-bottom: none; }
    .progress-card .label { font-size: 14px; color: #666; }
    .progress-card .value { font-size: 14px; font-weight: 600; color: #151515; }
    .progress-card .value.price { color: #3244a8; font-size: 16px; }
    .progress-card .value.success { color: #28a745; }
    .progress-card .value.danger { color: #dc3545; }

    .status-badge { padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-badge.active { background-color: #28a745; color: #fff; }
    .status-badge.expired { background-color: #dc3545; color: #fff; }

    .table-responsive { margin-top: 15px; }
    .table { margin-bottom: 0; }
    .table th { background-color: #f8f9fa; font-weight: 600; font-size: 14px; padding: 12px 8px; }
    .table td { font-size: 14px; padding: 10px 8px; vertical-align: middle; }

    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state img { width: 120px; height: 120px; margin-bottom: 20px; opacity: 0.5; }
    .empty-state h5 { font-size: 18px; font-weight: 600; color: #666; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; color: #999; }

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
        <div class="back-btn" onclick="window.location.href='{{ route('user.my.plans') }}'">
            <i class="fas fa-arrow-left"></i>
        </div>
        <span>{{ __($pageTitle) }}</span>
        <div style="width: 25px;"></div>
    </div>

    <div class="page">
        <div class="container">
            <!-- Plan Information -->
            <div class="progress-card">
                <div class="card-header">{{ __('Plan Information') }}</div>
                <div class="info-row">
                    <span class="label">{{ __('Plan Name') }}:</span>
                    <span class="value">{{ __($plan->name) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Plan Price') }}:</span>
                    <span class="value price">{{ showAmount($plan->price) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('ROI Percentage') }}:</span>
                    <span class="value">{{ $plan->roi_percentage }}%</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Validity') }}:</span>
                    <span class="value">{{ $plan->validity }} {{ __('Days') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Status') }}:</span>
                    <span class="status-badge {{ $isActive ? 'active' : 'expired' }}">
                        {{ $isActive ? __('Active') : __('Completed/Expired') }}
                    </span>
                </div>
            </div>

            <!-- Profit Summary -->
            <div class="progress-card">
                <div class="card-header">{{ __('Profit Summary') }}</div>
                <div class="info-row">
                    <span class="label">{{ __('Total Profits Added') }}:</span>
                    <span class="value success">{{ showAmount($totalProfitsAdded) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Expected Total Profits') }}:</span>
                    <span class="value price">{{ showAmount($totalExpectedProfits) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Remaining Profits') }}:</span>
                    <span class="value {{ $remainingProfits > 0 ? 'danger' : 'success' }}">{{ showAmount($remainingProfits) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Days Elapsed') }}:</span>
                    <span class="value">{{ $daysElapsed }} / {{ $totalDays }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Remaining Days') }}:</span>
                    <span class="value">{{ $remainingDays }}</span>
                </div>
            </div>

            <!-- Daily Profit Additions -->
            <div class="progress-card">
                <div class="card-header">{{ __('Daily Profit Additions') }}</div>
                @php
                    // Filter profits to only show those that have actually been earned (not future ones)
                    $earnedProfits = $profits->filter(function($profit) {
                        return $profit->profit_date <= now()->toDateString();
                    });
                @endphp
                @if($earnedProfits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Daily Profit') }}</th>
                                    <th>{{ __('Time Added') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earnedProfits as $profit)
                                <tr>
                                    <td>{{ $profit->profit_date->format('M d, Y') }}</td>
                                    <td class="text-success font-weight-bold">
                                        +{{ showAmount($profit->daily_profit) }} {{ $general->cur_text }}
                                    </td>
                                    <td>{{ $profit->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-line" style="font-size: 80px; color: #ccc;"></i>
                        <h5>{{ __('No Profits Yet') }}</h5>
                        <p>{{ __('Daily profits will appear here as they are added to your account after the 24-hour waiting period.') }}</p>
                    </div>
                @endif
            </div>

            <!-- Current User Balances -->
            <div class="progress-card">
                <div class="card-header">{{ __('Current User Balances') }}</div>
                <div class="info-row">
                    <span class="label">{{ __('Main Balance') }}:</span>
                    <span class="value price">{{ showAmount($user->balance) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Profit Wallet') }}:</span>
                    <span class="value success">{{ showAmount($user->profit_wallet) }} {{ $general->cur_text }}</span>
                </div>
                <div class="info-row">
                    <span class="label">{{ __('Total Deposits') }}:</span>
                    <span class="value">{{ showAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}</span>
                </div>
            </div>
        </div>
    </div>

    @include('partials.notify')
    @include($activeTemplate . 'partials.footers')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>
