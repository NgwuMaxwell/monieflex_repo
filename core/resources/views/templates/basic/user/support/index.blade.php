@include($activeTemplate . 'partials.headers')



<style>
    @import  url('{{ asset('assets/pub/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap') }}');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: 100%; background: #f0f3f7; background-size: 100% 100%; position: relative; }
    .header { width: 100%; max-width: 991px; height: 50px; background: linear-gradient( 270deg, #3244a8,#3244a8); font-size: 16px; line-height: 50px; font-weight: 400; color: #fff; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { width: 38px; position: absolute; left: 15px; top: 0; }

    .banner { width: 100%; padding-top: 50px; }
    
    .container { width: 100%; padding: 65px 11px 50px; }

    .white-block { width: 100%; height: fit-content; background-color: #fff; border-radius: 8px; padding: 15px; margin-bottom: 15px; }
    .white-block a.list-link { width: 100%; height: 40px; padding: 9px 0; display: block; text-decoration: none !important; position: relative; }
    .white-block a.list-link img { width: 22px; height: 22px; position: absolute; left: 7px; }
    .white-block a.list-link span { font-size: 14px; font-weight: 400; line-height: 22px; color: #333; margin-left: 38px; text-decoration: none; }

    .white-block .title { font-size: 16px; line-height: 24px; font-weight: 400; color: #333; margin-bottom: 10px; }
    .white-block p { font-size: 14px; line-height: 16px; font-weight: 600; color: #999; margin-bottom: 0; }
</style>

</head>

<body>
    <div class="page">
        <div class="header">
            <div class="left-arrow" onclick="history.back()"><img src="{{ asset('assets/img/left-arrow.png') }}" class="w-100"></div>
            Customer Service
        </div>
        <div class="container">
            <div class="white-block">
                
                <a href="{{ route('user.support') }}" class="list-link">
                    <img src="{{asset ('assets/img/icon-telegram.png')}}">
                    <span>Telegram Customer Service</span>
                </a>
                <a href="{{ route('user.support') }}" class="list-link">
                    <img src="{{asset ('assets/img/icon-telegram.png')}}">
                    <span>Telegram Channel</span>
                </a>
            </div>
            <div class="white-block">
                <div class="title">Tips</div>
                <p>Customer service online time: 10 am to 10 pm</p>
            </div>
        </div>
    </div>















@include($activeTemplate . 'partials.footers')
