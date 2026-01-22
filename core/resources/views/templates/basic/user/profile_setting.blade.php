<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name = "introduction" content = "no-reference">
<title>User</title>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">


<style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #f8f8f8; background-size: 100% 100%; padding-top: 0px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 50px; padding: 0 15px; background: transparent; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; transition: all 0.3s ease-in-out; }
    .header span { font-size: 16px; line-height: 50px; font-weight: 400; color: #fff; opacity: 0; transition: all 0.3s ease-in-out; }
    .header .right-icon { width: 25px; height: 25px; position: absolute; top: 12.5px; right: 10px; }

    .banner { width: 100%; height: fit-content; border-radius: 0 0 25px 25px; padding: 50px 10px 15px; background: linear-gradient(180deg,#3244a8,#3244a8); }
    .banner .profile { width: calc(100% - 30px); margin: 0 15px 35px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .profile .dp { width: 70px; height: 70px; border-radius: 100%; overflow: hidden; margin-right: 20px; }
    .profile .txt-right { display: block; width: calc(100% - 90px); }
    .profile .txt-right .number-row { display: flex; flex-direction: row; align-items: center; justify-content: start; margin-bottom: 10px; }
    .profile .txt-right .number-row span { font-size: 18px; line-height: 24px; font-weight: 700; color: #fff; }
    .profile .txt-right .number-row .vip-box { width: fit-content; height: 20px; background-color: #ffa200; padding: 0 10px; font-size: 12px; line-height: 20px; font-weight: 400; color: #fff; border-radius: 12px; margin-left: 10px; }
    .profile .txt-right p { font-size: 14px; line-height: 19px; font-weight: 400; color: #fff; margin-bottom: 0; }

    .top-nav { width: 100%; height: 80px; background-color: #fff; border-radius: 7px; padding: 25px 0 10px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .top-nav .nav { width: 25%; height: 45px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; cursor: pointer; }
    .top-nav .nav img { width: 25px; }
    .top-nav .nav span { font-size: 12px; line-height: 16px; font-weight: 700; color: #151515; }
    
    .container { width: 100%; max-width: 991px; padding: 0px 15px 100px; }

    .top-white-box { width: 100%; height: fit-content; background-color: #fff; padding: 15px; border-radius: 7px 7px 0 0; }
    .top-white-box .title { font-size: 16px; line-height: 25px; font-weight: 700; color: #151515; padding-left: 15px; position: relative; }
    .top-white-box .title::before { content: ''; display: block; width: 5px; height: 25px; background-color: #ffa200; border-radius: 4px; position: absolute; left: 0; top: 0; }
    .top-white-box hr { width: 100%; height: 1px; background-color: #eee; border: 0; margin: 15px 0; }
    .top-white-box .detail-row { width: 100%; height: fit-content; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .top-white-box .part-one { width: 50%; min-height: 53px; padding: 0 15px; display: flex; flex-direction: column; align-items: start; justify-content: space-between; }
    .top-white-box .part-two { width: 50%; height: 53px; padding: 0 15px; display: flex; flex-direction: column; align-items: start; justify-content: space-between; border-left: 1px solid #eee; }
    .top-white-box .part-two:first-child { border: none; }
    .top-white-box p, .top-grey-box p { font-size: 18px; font-weight: 700; line-height: 24px; color: #3244a8; margin-bottom: 0; }
    .top-white-box p span, .top-grey-box p span { font-size: 14px; }
    .top-white-box h6, .top-grey-box h6 { font-size: 14px; line-height: 19px; font-weight: 400; color: #9e9aa8; margin-bottom: 0; }
    .top-white-box img { width: 80px; height: 80px; float: right; }

    .top-grey-box { width: 100%; height: fit-content; background-color: #f1f1fe; padding: 15px; border-radius: 0 0 7px 7px; border-top: 1px solid #f1f1fe; margin-bottom: 15px; display: flex; flex-direction: row; align-items: center; justify-content: start; }
    .top-grey-box p, .top-grey-box h6 { width: 50%; padding-left: 15px; }

    .mid-navs { width: 100%; background-color: #fff; border-radius: 7px; padding: 0 0 15px; margin-bottom: 15px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .mid-navs .nav { width: 25%; height: 60px; padding-top: 15px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; cursor: pointer; }
    .mid-navs .nav img { width: 25px; }
    .mid-navs .nav span { font-size: 12px; line-height: 16px; font-weight: 700; color: #151515; }

    .mid-link { width: 100%; height: fit-content; background-color: #fff; padding: 10px 15px; border-radius: 7px; margin-bottom: 15px; cursor: pointer; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .mid-link .icon { width: 25px; height: 25px; margin-right: 10px; }
    .mid-link span { font-size: 12px; line-height: 16px; font-weight: 700; color: #151515; }
    .mid-link i { font-size: 16px; color: #9e9aa8; margin-left: auto; }

    .sticky-service { width: 45px; height: 45px; background-color: #ffa200; border-radius: 25px 0 0 25px; display: flex; align-items: center; justify-content: center; position: fixed; right: 0; bottom: 200px; }
    .sticky-service img { width: 25px; height: 25px; }

    .footer-nav { width: 100%; max-width: 991px; height: 100px; /*background: transparent url(images/footer-menubar.png) no-repeat left bottom; background-size: 100%;*/ transform: translateX(-50%); position: fixed; left: 50%; bottom: 0; z-index: 100; }
    .footer-nav .footer-nav-bg { width: 100%; height: 100%; position: absolute; left: 0; top: 0; }
    .footer-nav .nav-set { width: 100%; height: 56px; position: absolute; left: 0; bottom: 6px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .footer-nav .nav-set .nav { width: 20%; height: 56px; padding: 4px 0 2px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; }
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
    <div class="header" id="header">
        <span id="head-txt">User</span>
        <div class="right-icon" onclick="window.location.href='{{ route('user.profile.complete') }}'"><img src="{{asset ('assets/img/icon-setting.png')}}" class="w-100 h-100"></div>
    </div>
    <div class="page">
        <div class="banner">
            <div class="profile">
                <div class="dp"><img src="{{ getImage(getFilePath('userProfile').'/'. @$user->image, getFileSize('userProfile')) }}" class="w-100 h-100"></div>
                <div class="txt-right">
                    <div class="number-row">
                        <span>{{ $user->fullname ?: 'Complete Your Profile' }}</span>
                        <div class="vip-box"> @if ($user->plan)
                            <strong>{{ __($user->plan->name) }}</strong>
                        @else
                Unpaid Account
                        @endif</div>
                    </div>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
            <div class="top-nav">
                <div class="nav" onclick="window.location.href='{{route ('user.deposit')}}'">
                    <img src="{{asset ('assets/img/icon-recharge2.png')}}">
                    <span>Recharge</span>
                </div>
                <div class="nav" onclick="window.location.href='{{route ('user.withdraw')}}'">
                    <img src="{{asset ('assets/img/icon-withdraw2.png')}}">
                    <span>Withdraw</span>
                </div>
                <div class="nav" onclick="window.location.href='{{route ('plans')}}'">
                    <img src="{{asset ('assets/img/icon-bill.png')}}">
                    <span>plans</span>
                </div>
                <div class="nav" onclick="window.location.href='{{route ('user.ptc.index')}}'">
                    <img src="{{asset ('assets/img/icon-coupon.png')}}">
                    <span>Task</span>
                </div>
            </div>
        </div>
        
        
        
        
        
        @php
  $authUser = Auth::user();
  $balance = number_format($authUser->balance, 0, '.', '');
@endphp



@php
    use App\Models\Transaction;
    $authUserId = Auth::id();
    $referralCommission = Transaction::where('user_id', $authUserId)
                                    ->where('remark', 'referral_commission')
                                    ->sum('amount');
    $formattedReferralCommission = number_format($referralCommission, 0, '.', '');
@endphp


@php
    $authUserId = Auth::id();
    $ptcEarn = Transaction::where('user_id', $authUserId)
                            ->where('remark', 'ptc_earn')
                            ->sum('amount');
    $formattedPtcEarn = intval($ptcEarn);
@endphp


@php
  use App\Models\Withdrawal;
  $authUserId = Auth::id();
  $withdrawal = Withdrawal::where('user_id', $authUserId)
                          ->where('status', 2)
                          ->first();
  $finalAmount = $withdrawal ? number_format($withdrawal->final_amount, 0, '.', '') : 0;
@endphp

@php
  $authUserId = Auth::id();
  $withdrawal = Withdrawal::where('user_id', $authUserId)
                          ->where('status', 1)
                          ->first();
  $withdrawalAmount = $withdrawal ? number_format($withdrawal->final_amount, 0, '.', '') : 0;
  

@endphp

@php
  $authUserId = Auth::id();
  $withdrawal = Withdrawal::where('user_id', $authUserId)
                          ->where('status', 3)
                          ->first();
  $withdrawalAmountre = $withdrawal ? number_format($withdrawal->final_amount, 0, '.', '') : 0;
  
$pageTitle = 'wallet';
@endphp
        
        
        
        
        <div class="container">
            <div class="top-white-box">
                <div class="title">Asset Details</div>
                <hr></hr>
                <div class="detail-row">
                    <div class="part-one">
                        <p>
                                                  {{ $balance }}
                            <span>{{ $general->cur_text }}</span></p>
                        <h6>Wallet Balance</h6>
                    </div>
                    <div class="part-one">
                        <p>{{ number_format($user->profit_wallet, 2) }}<span>{{ $general->cur_text }}</span></p>
                        <h6>Profit Wallet</h6>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="part-one d-block">
                        <img src="{{asset ('assets/img/wallet-animation.gif')}}">
                    </div>
                </div>
                <hr></hr>
                <div class="detail-row">
                    <div class="part-two">
                        <h6>Task Earning</h6>
                        <p>{{ $formattedPtcEarn }}<span>{{ $general->cur_text }}</span></p>
                    </div>
                    <div class="part-two">
                        <h6>Approve Withdraw</h6>
                        <p>{{ $withdrawalAmount }}<span>{{ $general->cur_text }}</span></p>
                    </div>
                </div>
                <hr></hr>
                <div class="detail-row">
                    <div class="part-two">
                        <h6>Pending Withdraw</h6>
                        <p>{{ $finalAmount }}<span>{{ $general->cur_text }}</span></p>
                    </div>
                    <div class="part-two">
                        <h6>Total Recharge</h6>
                        <p>{{ showAmount($user->deposits->sum('amount')) }} <span>{{ $general->cur_text }}</span></p>
                    </div>
                </div>
            </div>
            <div class="top-grey-box">
                <h6>Total Withdrawal</h6>
                <p>{{ showAmount($user->withdrawals->where('status', 1)->sum('amount')) }}<span>{{ $general->cur_text }}</span></p>
            </div>
            <div class="mid-navs">
                
                <div class="nav" onclick="window.location.href='{{route ('user.deposit.history')}}'">
                    <img src="{{asset ('assets/img/icon-bankaccount.png')}}">
                    <span>My Recharge</span>
                </div>
                <div class="nav" onclick="window.location.href='{{route ('user.withdraw.history')}}'">
                    <img src="{{asset ('assets/img/icon-task.png')}}">
                    <span>My withdraw</span>
                </div>
                <div class="nav" onclick="window.location.href='{{ route('user.referred') }}'">
                    <img src="{{asset ('assets/img/icon-about.png')}}">
                    <span>My Team</span>
                </div>
                <!--<div class="nav" onclick="window.location.href='https://rethink.terrawatt.co.in/turntable'">-->
                <!--    <img src="https://rethink.terrawatt.co.in/img/icon-about.png">-->
                <!--    <span>Lucky</span>-->
                <!--</div>-->
                <div class="nav" onclick="window.location.href='{{ route('user.my.plans') }}'">
                    <img src="{{asset ('assets/img/icon-bill.png')}}">
                    <span>My Plans</span>
                </div>
            </div>
         
            
            @forelse($serviceLinks as $link)
                <div class="mid-link" onclick="window.location.href='{{ $link->url }}'">
                    <div class="icon"><img src="{{asset($link->icon ?: 'assets/img/icon-crowdfund.png')}}" class="w-100"></div>
                    <span>{{ $link->title }}</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
            @empty
                <div class="mid-link" onclick="window.location.href='{{ route('ticket') }}'">
                    <div class="icon"><img src="{{asset ('assets/img/icon-crowdfund.png')}}" class="w-100"></div>
                    <span>Services</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
            @endforelse
            
            @forelse($contactLinks as $link)
                <div class="mid-link" onclick="window.location.href='{{ $link->url }}'">
                    <div class="icon"><img src="{{asset($link->icon ?: 'assets/img/icon-crowdfund.png')}}" class="w-100"></div>
                    <span>{{ $link->title }}</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
            @empty
                <div class="mid-link" onclick="window.location.href='https://wa.me/+923042324661'">
                    <div class="icon"><img src="{{asset ('assets/img/icon-crowdfund.png')}}" class="w-100"></div>
                    <span>Contact Developers</span>
                    <i class="bi bi-chevron-right"></i>
                </div>
            @endforelse
            
            
            
            
            
            <div class="mid-link" onclick="window.location.href='{{route ('user.logout')}}'">
                <div class="icon"><img src="{{asset ('assets/img/icon-logout.png')}}" class="w-100"></div>
                <span>Logout</span>
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>





@include('partials.notify')
@include($activeTemplate . 'partials.footers')
