@include($activeTemplate . 'partials.headers')

     
   <style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 44px; background: #fff; font-size: 16px; line-height: 44px; font-weight: 600; color: #151515; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { font-size: 20px; position: absolute; left: 10px; top: 0; }
    .header .right-icon { font-size: 18px; position: absolute; color: rgb(87, 31, 178); right: 10px; top: 0; }
    
    .container { width: 100%; max-width: 991px; padding: 20px 15px 15px; }

    .banner { width: 100%; height: fit-content; background: linear-gradient(90deg,#3244a8,#7d2b73); border-radius: 10px 10px 0 0; padding: 30px 0; }
    .banner .txt { width: 100%; text-align: left; color: #fff; padding: 0 25px; }
    .banner .txt p { font-size: 14px; line-height: 19px; font-weight: 700; margin-bottom: 5px; }
    .banner .txt h3 { font-size: 22px; line-height: 29px; font-weight: 700; margin-bottom: 0; }

    nav.tab-list { width: 100%; height: 40px; background-color: #fff; position: relative; }
    nav.tab-list .tab-tag { position: absolute; font-size: 8px; line-height: 8px; font-weight: 400; color: #fff; width: fit-content; height: fit-content; background-color: #e83426; padding: 1px 5px; border-radius: 5px 5px 5px 0; top: 0; right: -5px; z-index: 2; }
    nav.tab-list a.nav-link { width: 33.333%; height: 40px; margin: 0; font-size: 15px; color: rgb(48, 49, 51); padding: 0; border: 0; border-radius: 0; line-height: 40px; background-color: #fff; position: relative; }
    nav.tab-list a.nav-link.active { background-color: #fff; font-weight: 700; color: rgb(87, 31, 178); }
    nav.tab-list a.nav-link.active::after { display: block; content: ''; width: 20px; height: 3px; border-radius: 3px; background-color: rgb(87, 31, 178); position: absolute; transform: translateX(-50%); left: 50%; bottom: 3px; }

    .title { font-size: 16px; font-weight: 700; line-height: 21px; color: #151515; margin: 15px 0; }

    .amt-sets { width: calc(100% + 15px); margin: 0 -7.5px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .amt-sets button.btn-amt { width: calc(33.333% - 15px); height: 105px; margin: 0 7.5px 10px; background-color: #f1f1fe; border: 0; border-radius: 10px; outline: 0; box-shadow: none; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; }
    .amt-sets button.btn-amt .btn-tag { width: fit-content; height: 18px; background-color: #ffa200; border-radius: 10px 10px 10px 0; padding: 3px 10px; font-size: 12px; line-height: 12px; font-weight: 400; color: #fff; position: absolute; top: -5px; right: -7px; }
    .amt-sets button.btn-amt .icon {width: 25px; height: 25px; background-color: #ffa200; border-radius: 100%; font-size: 14px; font-weight: 400; color: #fff; line-height: 25px; text-align: center; }
    .amt-sets button.btn-amt img { width: 25px; height: 25px; }
    .amt-sets button.btn-amt span { font-size: 18px; font-weight: 700; line-height: 24px; color: #151515; margin-top: 10px; }
    .amt-sets button.btn-amt.active { background-color: #3244a8; }
    .amt-sets button.btn-amt.active span { color: #fff; }

    form.login-form { margin: 0; }
    form.login-form .form-group { width: 100%; height: 45px; background-color: #f1f1fe; border-radius: 7px; margin: 10px 0; }
    form.login-form .input-group-prepend .input-group-text { background-color: transparent; padding: 0; border: 0; width: 100px; padding-left: 15px; height: 45px; font-size: 14px; line-height: 17px; font-weight: 700; color: #151515; word-break: break-word; text-align: left; }
    form.login-form input.form-control { height: 45px; line-height: 45px; background-color: transparent; border-radius: 0; border: 0; padding: 0px; font-size: 14px; font-weight: 400; color: #151515; padding: 0 15px; }
    form.login-form input.form-control::placeholder { color: #bebebe; }
    form.login-form .input-group-append .input-group-text { background-color: transparent; padding: 0 10px; border: 0; height: 45px; }
    form.login-form button.btn.btn-get { width: fit-content; height: 30px; background: #571fb2; border: 0; border-radius: 18px; font-size: 12px; font-weight: 400; color: #fff; margin: 0px; padding: 0 20px; }
    
    form.login-form button.btn.btn-submit { width: 100%; height: 45px; font-size: 14px; font-weight: 400; color: #fff; background: linear-gradient(90deg,#3244a8,#7843f5); border: 0px; border-radius: 25px; padding: 0; margin: 20px 0; }
    form.login-form input.form-control:focus { box-shadow: none; }

    .check-block { width: 100%; height: fit-content; background: #f1f1fe; border-radius: 10px; }
    .form-check { padding: 0; margin: 0; position: relative; }
    .form-check label { display: block; width: 100%; height: 50px; padding: 0px 15px; border-bottom: 1px solid #eee; margin-bottom: 0px; font-size: 14px; font-weight: 400; line-height: 50px; color: #151515; position: relative; }
    input[type=radio] { position: absolute; cursor: pointer; height: 22px; width: 22px; background-color: #fff; border: 1px solid #d1d1d1; border-radius: 100%; -webkit-appearance: none; opacity: 1; top: 7px; right: 15px; z-index: 1; }
    input[type=radio]:hover { opacity: 1; }
    input[type=radio]:checked { opacity: 1; background-color: rgb(87, 31, 178); border-color: rgb(87, 31, 178); }
    input[type=radio]:checked::before { content: ''; display: block; width: 12px; height: 6px; border-left: 2px solid #fff; border-bottom: 2px solid #fff; transform: rotate(-45deg); position: absolute; left: 4px; top: 6px; }

    .rule-txt { padding: 10px; }
    .rule-txt p { font-size: 15px; font-weight: 700; line-height: 22px; color: #3244a8; margin-bottom: 15px; }
</style>
                    
                    
                    <body>
    <center class="header">
   
     <center>   Cashout Now</center>
      
    </center>

@php
  $authUser = Auth::user();
  $balance = number_format($authUser->profit_wallet, 0, '.', '');
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
       
    
    <div class="page">
        <div class="container">
            <div class="banner">
                <div class="txt">
                    <p>Amount of money</p>
                    <h3> {{__($general->cur_text)}}                      {{ $balance }}        </h3>
                </div>
            </div>
            <nav class="tab-list">
                <div class="tab-tag">Giveaway</div>
                <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-one-tab" data-toggle="tab" href="#nav-one" role="tab" aria-controls="nav-one" aria-selected="true">Cash Withdraw</a>
                                       
                </div>
            </nav> <a class="nav-link active" id="min-withdraw-display">The Minimum Withdraw is <span id="min-withdraw-amount">{{ $withdrawMethod->first()->min_limit ?? 100 }}</span> {{__($general->cur_text)}}  </a>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                    <form class="login-form" action="{{ route('user.withdraw.money') }}" method="post">
                  @csrf
      
                                               <style>
    #con {
        display: none;
        align-items: center;
        justify-content: center;

        position: absolute;
        max-width: 100%;
        height: auto;
        top: 50%;
        left: 50%;
        z-index: 999;
        transform: translate(-50%, -50%);


    }

    .loaderClass {
        height: 46px;
        width: fit-content;
        padding: 0px 20px;
        background-color: #ffa200;
        font-size: 15px;
        font-weight: 400;
        color: #ffffff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        z-index: 9999;
    }

    .loaderClass .animation {
        width: 20px;
        height: 20px;
        background: url("https://rethink.terrawatt.co.in/img/loading.gif") no-repeat center center;
        background-size: 100% 100%;
        margin-right: 10px;
    }
</style>






      @if(!Auth::user()->plan)
                <div class="alert alert-warning solid alert-dismissible fade show">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                  <strong>Sorry!</strong> Please buy a plan first! <a href="{{route ('plans')}}" class="badge badge-sm light badge-warning ms-1">Buy Plan</a>
                </div>
                @else
                        <input type="hidden" name="selected_channel" class="selected_channel" value="">
                        <div class="title">Amount</div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Other Amount</div>
                                </div>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter the Amount">
                            </div>
                        </div>
                        

                        
                        
                        <div class="title">Channel</div>
                        
                        
                        
                        
                        
                                         <div class="">
                            <div class="">
                                <div class="">
                            
                                </div>
                                
                                
                                     <select class="form-control" name="method_code" required>
                                       @foreach($withdrawMethod as $data)    
                                          @if($data->name == 'Bank Transfer')
                                              <option value="{{ $data->id }}" data-resource="{{ $data }}" selected>{{__($data->name)}}</option>
                                          @else
                                              <option value="{{ $data->id }}" data-resource="{{ $data }}">{{__($data->name)}}</option>
                                          @endif
                          @endforeach
                                </select>
                                
                                
                                
                               
                            </div>
                        </div>

                            
                            
                            
                              
                            
                         
                     
                        <button class="btn btn-submit">Cashout</button>
                    </form>
                    <div class="rule-txt">
                        <p>1. The Withdraw amount is the same as the payment amount.</p>
                        <p>2. For the safety of your account and property, you need to enter the rethink recharge page to obtain the latest UPI every time you recharge.</p>
                        <p>3. For  issues, please contact online customer service.</p>
                    </div>
                </div>
                @endif      
                            
                
                
                
                <div class="tab-pane fade" id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab">
                    <form action="" class="login-form">
                        <div class="title">Amount</div>
                        <div class="amt-sets">
                            <button type="button" class="btn-amt active">
                                <div class="btn-tag">+0.40</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>5.10</span>
                            </button>
                            <button type="button" class="btn-amt">
                                <div class="btn-tag">+0.97</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>12.24</span>
                            </button>
                            <button type="button" class="btn-amt">
                                <div class="btn-tag">+2.44</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>30.61</span>
                            </button>
                            <button type="button" class="btn-amt">
                                <div class="btn-tag">+4.00</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>51.00</span>
                            </button>
                            <button type="button" class="btn-amt">
                                <div class="btn-tag">+13.00</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>163.20</span>
                            </button>
                            <button type="button" class="btn-amt">
                                <div class="btn-tag">+39.20</div>
                                <img src="https://rethink.terrawatt.co.in/img/icon-usdt.png">
                                <span>489.80</span>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Other Amount</div>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter the Amount">
                            </div>
                        </div>
                        <div class="title">Channel</div>
                        <div class="check-block">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="methods" id="methods1" value="option1" checked>
                                <label class="form-check-label" for="methods1">USDT-TRC20 PAY</label>
                            </div>
                        </div>
                        <button class="btn btn-submit">Determine</button>
                    </form>
                    <div class="rule-txt">
                        <p>1. The amount is the same as the payment amount.</p>
                        <p>2. For the safety of your account and property, you need to enter the rethink recharge page to obtain the latest UPI every time you recharge.</p>
                        <p>3. For  issues, please contact online customer service.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>













<script src="/assets/global/js/jquery-3.6.0.min.js"></script>




<script type="text/javascript">
    (function ($) {
            "use strict";
            
            // Function to update minimum withdrawal amount display
            function updateMinWithdrawAmount() {
                var selectedMethod = $('select[name=method_code] option:selected');
                if (selectedMethod.length > 0) {
                    var resource = selectedMethod.data('resource');
                    if (resource && resource.min_limit) {
                        $('#min-withdraw-amount').text(parseFloat(resource.min_limit).toFixed(2));
                    } else {
                        $('#min-withdraw-amount').text('100');
                    }
                }
            }
            
            $('select[name=method_code]').change(function(){
                // Update minimum withdrawal amount when method changes
                updateMinWithdrawAmount();
                
                if(!$('select[name=method_code]').val()){
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = $('select[name=method_code] option:selected').data('resource');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                var toFixedDigit = 2;
                $('.min').text(parseFloat(resource.min_limit).toFixed(2));
                $('.max').text(parseFloat(resource.max_limit).toFixed(2));
                var amount = parseFloat($('input[name=amount]').val());
                if (!amount) {
                    amount = 0;
                }
                if(amount <= 0){
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');

                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement = `<span>@lang('Conversion Rate')</span> <span class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span>`;
                    $('.rate-element').html(rateElement);
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                }else{
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                var receivable = parseFloat((parseFloat(amount) - parseFloat(charge))).toFixed(2);
                $('.receivable').text(receivable);
                var final_amo = parseFloat(parseFloat(receivable)*rate).toFixed(toFixedDigit);
                $('.final_amo').text(final_amo);
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=amount]').on('input');
            });
            
            // Initialize minimum withdrawal amount on page load
            updateMinWithdrawAmount();
            
            $('input[name=amount]').on('input',function(){
                var data = $('select[name=method_code]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);
</script>


@include('partials.notify')
@include($activeTemplate . 'partials.footers')
