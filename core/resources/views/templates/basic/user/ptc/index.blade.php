@include($activeTemplate . 'partials.headers')
<style>
    @import  url('{{ asset('assets/pub/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap') }}');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 44px; background: #fff; font-size: 16px; line-height: 44px; font-weight: 600; color: #151515; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { font-size: 20px; position: absolute; left: 10px; top: 0; }
    
    .container { width: 100%; max-width: 991px; padding: 0px 15px 120px; }
    
    .product { width: 100%; height: fit-content; background-color: #f1f1fe; border-radius: 7px; margin-top: 15px; }
    .product .img-top { width: 100%; height: fit-content; border-radius: 7px; overflow: hidden; }
    .product .txt-body { padding: 15px; }
    .product .title { font-size: 15px; font-weight: 700; color: #ffa200; }
    .product .txt-row { display: flex; flex-direction: row; align-items: center; justify-content: space-between; margin-top: 10px; }
    .product p { font-size: 12px; line-height: 16px; font-weight: 400; color: #9e9aa8; margin-bottom: 0; }
    .product button.btn.btn-rent { width: 250px; height: 45px; border-radius: 25px; background: linear-gradient(90deg,#3244a8,#3244a8); font-size: 16px; font-weight: 400; color: #fff; line-height: 16px; padding: 0; margin: 15px auto 0; }

    .footer-nav { width: 100%; max-width: 991px; height: 100px; /*background: transparent url(images/footer-menubar.png) no-repeat left bottom; background-size: 100%;*/ transform: translateX(-50%); position: fixed; left: 50%; bottom: 0; z-index: 100; }
    .footer-nav .footer-nav-bg { width: 100%; height: 100%; position: absolute; left: 0; top: 0; }
    .footer-nav .nav-set { width: 100%; height: 56px; position: absolute; left: 0; bottom: 6px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .footer-nav .nav-set .nav { width: 20%; height: 56px; padding: 4px 0 2px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; }
    .footer-nav .nav-set .nav img { width: 24px; height: 24px; filter: brightness(1000%); }
    .footer-nav .nav-set .nav span { font-size: 14px; line-height: 14px; font-weight: 400; color: #fff; margin-bottom: 0; }
    .footer-nav .nav-set .nav.center { position: relative; }
    .footer-nav .nav-set .nav.center .circle { width: 60px; height: 60px; background-color: #571fb2; border-radius: 100%; display: flex; align-items: center; justify-content: center; position: absolute; top: -35px; }
    .footer-nav .nav-set .nav.center span { position: absolute; bottom: 2px; }
    .footer-nav .nav-set .nav.active img { filter: brightness(100%); }
    .footer-nav .nav-set .nav.active span { color: rgb(255, 162, 0); }

    .modal.load-modal .modal-content { width: calc(100% - 60px); height: fit-content; margin: 0 30px; padding: 0; border: 0; border-radius: 10px; background: #fff; position: relative; }
    .modal.load-modal .modal-content .modal-close { display: block; width: 28px; height: 28px; position: absolute; top: 5px; right: 5px; }
    .modal.load-modal .modal-content .heads { width: 100%; height: 70px; padding: 25px 0; background: transparent url({{ asset('assets/img/home-modal-head-bg.png') }}) no-repeat center center; background-size: 100%; font-size: 16px; font-weight: 400; color: #fff; line-height: 20px; text-align: center;  margin-top: -3px;}
    .modal.load-modal .modal-content .body { padding: 25px 25px 15px; }
    .modal.load-modal .modal-content p { font-size: 14px; font-weight: 400; line-height: 19px; color: #151515; margin-bottom: 20px; }
    .modal.load-modal .modal-content button.btn.btn-view { width: 240px; height: 45px; border: 0; border-radius: 25px; outline: 0; box-shadow: none; background: linear-gradient(90deg,#3244a8,#3244a8); padding: 0; font-size: 16px; font-weight: 400; color: #fff; }
</style>

</head>

<body>
    <style>
        #con {
            display: none;
            align-items: center;
            justify-content: center;
    
            position: fixed;
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
            background: url("{{ asset('assets/img/loading.gif') }}") no-repeat center center;
            background-size: 100% 100%;
            margin-right: 10px;
        }
    </style>
    <div class="container" id="con">
        <div class="loaderClass" id="loaderId">
            <div class="animation"></div>Loading
        </div>
    </div>
    <div class="header">
        Tasks
    </div>
    <div class="page">
        <div class="container">
           @forelse($ads as $ad)
            
            
            
                                    <div class="product">
                <div class="img-top"></div>
                <div class="txt-body">
                    <div class="title">{{ __($ad->title) }}</div>
                    <div class="txt-row">
                        <p>Task Price:</p>
                        <p>{{ $general->cur_sym }}{{ showAmount($ad->amount) }}</p>
                    </div>
                    <div class="txt-row">
                        <p>Circulation:</p>
                        <p>{{ $ad->duration }}s</p>
                    </div>
             
                <div class="text-center"><button  type="button" onclick="window.location.href='{{ route('user.ptc.show',encrypt($ad->id.'|'.auth()->user()->id)) }}'" class="btn btn-rent">Complete task Now</button></div>
                </div>
            </div>


         

       
            @empty

            <div class="col-12">
                <div class="card custom--card ptc-card">
                    <div class="card-body">
                        <h2 class="text-center text--base">{{ __($emptyMessage) }}</h2>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

    </div>
</section>









@include('partials.notify')
@include($activeTemplate . 'partials.footers')