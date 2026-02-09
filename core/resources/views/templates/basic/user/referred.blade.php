<title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}" />

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/vendor/animate.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/vendor/nice-select.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/vendor/slick.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">

    <style>
        @import  url('{{ asset('assets/pub/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap') }}');

        html,
        body {
            margin: 0;
            height: 100%;
            background: #fff;
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 400;
            color: #333;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            text-shadow: rgba(0, 0, 0, .01) 0 0 1px;
        }

        .container {
            width: 100%;
            max-width: 991px;
            padding: 20px 15px 120px;
        }

    .header { width: 100%; max-width: 991px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 18px; font-weight: 700; color: #ffffff; text-align: center; line-height: 60px; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; box-shadow: 0 4px 20px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; }
    .header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
    .header .back-btn { width: 30px; height: 30px; position: absolute; left: 15px; top: 15px; cursor: pointer; }
    .header .back-btn i { color: #fff; font-size: 24px; }
    .header span { position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }

        .top-block {
            width: 100%;
            height: fit-content;
            background: #3172f5;
            border-radius: 10px;
            margin: 10px 0px;
        }

        .top-block .flex-area {
            width: 100%;
            height: fit-content;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            flex-wrap: wrap;
            padding: 15px 0;
        }

        .flex-area .part-two,
        .flex-area .part-three {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .flex-area .part-three {
            width: 33.333% !important;
        }

        .flex-area p {
            font-size: 15px;
            line-height: 22px;
            margin-bottom: 0px;
            color: #fff;
        }

        .nav-item.nav-link {
            background-color: transparent;
            height: 44px;
            line-height: 35px;
            font-size: 15px;
            font-weight: 400;
            color: #999;
            position: relative;
        }

        .nav-item.nav-link.active {
            background-color: transparent;
            color: #3172f5;
        }

        .nav-item.nav-link.active::after {
            content: '';
            display: block;
            width: 30px;
            height: 4px;
            background-color: #3172f5;
            position: absolute;
            transform: translateX(-50%);
            left: 50%;
            bottom: 0px;
        }

        .tab-pane {
            padding-top: 20px;
            text-align: center;
        }

        .tab-pane h6 {
            color: #a0a0a0;
            font-size: 13px;
            font-weight: 400;
        }

        .footer-nav {
            width: 100%;
            max-width: 991px;
            height: 50px;
            background-color: #fff;
            border-top: 1px solid rgba( 0, 0, 0, 0.15);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            flex-wrap: wrap;
            position: fixed;
            transform: translateX(-50%);
            bottom: 0;
            left: 50%;
        }

        .footer-nav .nav {
            width: 25%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            line-height: 10px;
            font-weight: 400;
            color: rgb(205, 207, 213);
        }

        .footer-nav .nav img {
            width: 24px;
            height: 24px;
            margin-bottom: 3px;
            filter: grayscale(100%);
            opacity: 0.3;
        }

        .footer-nav .nav.active {
            color: rgb(28, 114, 220);
        }

        .footer-nav .nav.active img {
            filter: grayscale(0%);
            opacity: 1;
        }

        .tab-content .content-block {
            width: 100%;
            height: fit-content;
            background-color: #e5e5e5;
            border-radius: 25px 25px 0 0;
            padding: 15px 30px;
            display: flex;
            flex-direction: row;
            align-items: start;
            justify-content: start;
            flex-wrap: wrap;
        }

        .tab-content .content-block .content {
            width: 50%;
        }

        .tab-content .content-block .content p {
            font-size: 15px;
            font-weight: 400;
            line-height: 19px;
            color: #000;
            margin-bottom: 10px;
        }

        .tab-content .content-block .content h6 {
            font-size: 14px;
            font-weight: 400;
            line-height: 17px;
            color: #b6b6b6;
            margin-bottom: 0;
        }

        .tab-content .content-block .content h5 {
            font-size: 12px;
            font-weight: 600;
            line-height: 23px;
            color: #000;
            margin-bottom: 0;
        }

        .tab-content .nomore {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: #969799;
            text-align: center;
            margin: 25px auto;
        }

        /* Referral link section styles */
        .referral-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .referral-section h4 {
            color: #3172f5;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .referral-section p {
            color: #666;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .referral-link-input {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .referral-link-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .referral-link-input button {
            padding: 10px 15px;
            background-color: #3172f5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .referral-link-input button:hover {
            background-color: #2a5bb9;
        }
    </style>

</head>

<body>

@php
  $authUser = Auth::user();
  $userCount = App\Models\User::where('ref_by', $authUser->id)->count();
@endphp

<h1>‎ ‎ ‎ ‎ ‎ ‎  ‎ </h1>

<div class="container">
        <div class="row">
            <!-- Referral Link Section -->
            <div class="referral-section">
                <h4>Your Unique Referral Link</h4>
                <p>Share this link with friends to earn referral commissions</p>

                <div class="referral-link-input">
                    <input type="text" value="{{ route('home') }}/ref/{{ $authUser->ref }}" class="form-control" id="myInput" readonly>
                    <button class="btn btn-primary" type="button" onclick="myFunction()">Copy Link</button>
                </div>

                <p style="font-size: 12px; color: #888; margin-top: 10px;">
                    Your referral code: <strong>{{ $authUser->ref }}</strong>
                </p>
            </div>

    <div class="header">
        <a href="{{ route('user.profile.setting') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span>My Team</span>
    </div>

@php
    use App\Models\Transaction;
    $authUserId = Auth::id();
    $referralCommission = Transaction::where('user_id', $authUserId)
                                    ->where('remark', 'referral_commission')
                                    ->sum('amount');
    $formattedReferralCommission = number_format($referralCommission, 0, '.', '');
@endphp

    <div class="top-block">
        <div class="flex-area">
            <div class="part-two">
                <p><b>     {{ $userCount }}</b></p>
                <p><b>Team</b></p>
            </div>
            <div class="part-two">
                <p><b>{{ $referralCommission }}</b></p>
                <p><b>Team Earning</b></p>
            </div>
        </div>
    </div>

    <nav>
        <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-one-tab" data-toggle="tab" href="#nav-one" role="tab" aria-controls="nav-one" aria-selected="true">1level</a>
            <a class="nav-item nav-link" id="nav-two-tab" data-toggle="tab" href="#nav-two" role="tab" aria-controls="nav-two" aria-selected="false">2level</a>
            <a class="nav-item nav-link" id="nav-three-tab" data-toggle="tab" href="#nav-three" role="tab" aria-controls="nav-three" aria-selected="false">3level</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-one" role="tabpanel" aria-labelledby="nav-one-tab">
        </div>
        <div class="tab-pane fade" id="nav-two" role="tabpanel" aria-labelledby="nav-two-tab">
        </div>
        <div class="tab-pane fade" id="nav-three" role="tabpanel" aria-labelledby="nav-three-tab">
        </div>
    </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Referred Users</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive-sm">
                                <thead>
                                    <tr>

                                        <th>@lang('Email')</th>

                                        <th>@lang('Plan')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($refUsers as $log)
                                    <tr>

                                        <td data-label="@lang('Email')">{{ $log->email }}</td>

                                        <td data-label="@lang('Plan')">{{ __($log->plan ? $log->plan->name : "No Plan") }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Code Ends -->
        </div>
    </div>
</div>

<script src="/assets/global/js/jquery-3.6.0.min.js"></script>

<script>
    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contents
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
    }

    function myFunction() {
        var copyText = document.getElementById("myInput");
        copyToClipboard(copyText.value);

        /* Alert the copied text */
        alert("Copied Link: " + copyText.value);
    }
</script>

@include('partials.notify')