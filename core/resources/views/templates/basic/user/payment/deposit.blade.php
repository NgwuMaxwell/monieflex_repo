
@include($activeTemplate . 'partials.headers')

		
		




                <form class="login-form"      action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <input type="hidden" name="method_code">
                    <input type="hidden" name="currency">
                    
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
    .amt-sets button.btn-amt { width: calc(33.333% - 15px); height: 110px; margin: 0 7.5px 15px; background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); border: 2px solid #e8ecf4; border-radius: 15px; outline: 0; box-shadow: 0 4px 15px rgba(0,0,0,0.08); display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; transition: all 0.3s ease; cursor: pointer; }
    .amt-sets button.btn-amt:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); border-color: #3244a8; }
    .amt-sets button.btn-amt .btn-tag { width: fit-content; height: 20px; background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%); border-radius: 12px 12px 12px 0; padding: 4px 12px; font-size: 11px; line-height: 12px; font-weight: 600; color: #fff; position: absolute; top: -8px; right: -8px; box-shadow: 0 2px 8px rgba(255,107,53,0.3); }
    .amt-sets button.btn-amt .icon {width: 32px; height: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px; font-size: 12px; font-weight: 600; color: #fff; line-height: 20px; text-align: center; box-shadow: 0 3px 10px rgba(102,126,234,0.3); }
    .amt-sets button.btn-amt img { width: 28px; height: 28px; }
    .amt-sets button.btn-amt span { font-size: 16px; font-weight: 700; line-height: 20px; color: #2d3748; margin-top: 8px; }
    .amt-sets button.btn-amt.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-color: #667eea; box-shadow: 0 6px 20px rgba(102,126,234,0.4); }
    .amt-sets button.btn-amt.active span { color: #fff; }
    .amt-sets button.btn-amt.active .icon { background: rgba(255,255,255,0.2); }

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
   
     <center>   Recharge</center>
      
    </center>
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
    
    
    
    <div class="page">
        <div class="container">
            <div class="banner">
                <div class="txt">
                    <p>Amount of money</p>
                    <h3> {{__($general->cur_text)}}      {{ $balance }}                      </h3>
                </div>
            </div>
            <nav class="tab-list">
                <div class="tab-tag">Giveaway</div>
                <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-one-tab" data-toggle="tab" href="#nav-one" role="tab" aria-controls="nav-one" aria-selected="true">Cash Recharge</a>
                                       
                </div>
            </nav> <a class="nav-link active" >Important Notes: Please first select amount then Choose Deposit Method</a>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
                   
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







                        <input type="hidden" name="selected_channel" class="selected_channel" value="">
                        <div class="title">Amount</div>
                        <div class="amt-sets">
                            <button type="button" type="button" onclick="amountset('6000')" class="btn-amt active">
                                <div class="icon">{{__($general->cur_text)}}</div>
                                <span>6,000</span>
                            </button>
                            <button type="button" type="button" onclick="amountset('10000')" class="btn-amt">
                                <div class="icon">{{__($general->cur_text)}}</div>
                                <span>10,000</span>
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Other Amount</div>
                                </div>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter the Amount">
                            </div>
                        </div>
                        
                         <div class="mt-3 preview-details d-none">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Limit')</span>
                                        <span><span class="min fw-bold">0</span> {{__($general->cur_text)}} - <span class="max fw-bold">0</span> {{__($general->cur_text)}}</span>
                                    </li>
                                
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>@lang('Payable')</span> <span><span class="payable fw-bold"> 0</span> {{__($general->cur_text)}}</span>
                                    </li>
                                
                            
                                </ul>
                            </div>
                        
                        
                        
                        
                        <div class="title">Channel</div>
                        
                        
                        
                        
                        
                                         <div class="">
                            <div class="">
                                <div class="">
                            
                                </div>
                                
                                
                                     <select class="form-control" name="gateway" required>
                            <option>Select One</option>
                                    @foreach($gatewayCurrency as $data)
                                    <option value="{{$data->method_code}}" @selected(old('gateway') == $data->method_code) data-gateway="{{ $data }}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                                
                                
                                
                               
                            </div>
                        </div>

                            
                            
                            
                                 
                            
                            
                         
                     
                        <button class="btn btn-submit">Determine</button>
                    </form>
                    <div class="rule-txt">
                        <p>1. The recharge amount is the same as the payment amount.</p>
                        <p>2. For the safety of your account and property, you need to enter the rethink recharge page to obtain the latest UPI every time you recharge.</p>
                        <p>3. For recharge issues, please contact online customer service.</p>
                    </div>
                </div>
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
                        <p>1. The recharge amount is the same as the payment amount.</p>
                        <p>2. For the safety of your account and property, you need to enter the rethink recharge page to obtain the latest UPI every time you recharge.</p>
                        <p>3. For recharge issues, please contact online customer service.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    <script>
        var selector = '.form-check label';

        $(selector).on('click', function(){
            $(selector).removeClass('active');
            $(this).addClass('active');
        });
    </script>

    <script>
        var focused = 'button.btn-amt';

        $(focused).on('click', function(){
            $(focused).removeClass('active');
            $(this).addClass('active');
        });
    </script>
    <script>
        function show_channels() {
            $(".channels-data").hide();
            $(".recharge-data").hide();
            $(".selected_channel").val(1);
    
            $("#store_data").submit();
        }
    
        function open_page(ind) {
    
            $(".channels-data").hide();
            $(".recharge-data").hide();
            $(".channels-loader").show();
            // window.location.href = "https://rethink.terrawatt.co.in/pay";
            //$("#store_data").submit();
            // setTimeout(function() {
            $("#store_data").submit()
            // }, 10);
        }
    
        function amountset(pay) {
            $("#amount").val(pay);
        }
    </script>
</body>
</html>
                    
                    
     
                           
                      
                                
                  




    <script src="/assets/global/js/jquery-3.6.0.min.js"></script>
		
		
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <!-- lightcase plugin -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/lightcase.js') }}"></script>
    <!-- custom select js -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/jquery.nice-select.min.js') }}"></script>
    <!-- slick slider js -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/slick.min.js') }}"></script>
    <!-- scroll animation -->
    <script src="{{ asset($activeTemplateTrue . '/js/vendor/wow.min.js') }}"></script>
    <!-- dashboard custom js -->
    <script src="{{ asset($activeTemplateTrue . '/js/app.js') }}"></script>
		
		
		
  <script src="/assets/global/js/jquery-3.6.0.min.js"></script>
    
    <script>
        (function ($) {
            "use strict";
            $('select[name=gateway]').change(function(){
                if(!$('select[name=gateway]').val()){
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = $('select[name=gateway] option:selected').data('gateway');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                if(resource.method.crypto == 1){
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                }else{
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }
                $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                $('.max').text(parseFloat(resource.max_amount).toFixed(2));
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
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge)))*rate).toFixed(toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement = `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{__($general->cur_text)}} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
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
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
                $('input[name=method_code]').val(resource.method_code);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input',function(){
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);
    </script>


     
    @include('partials.notify')
@include($activeTemplate . 'partials.footers')
