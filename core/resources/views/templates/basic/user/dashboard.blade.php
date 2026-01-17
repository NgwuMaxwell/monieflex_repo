
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')

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
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 50px; padding: 0 15px; background: #3244a8; display: flex; flex-direction: row; align-items: center; justify-content: space-between; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .logo { width: 175px; }
    .header .lang { display: flex; flex-direction: row; align-items: center; justify-content: start; font-size: 16px; font-weight: 400; color: #fff; }
    .header .lang img { width: 20px; margin-right: 5px; }

    .banner { width: 100%; height: fit-content; padding: 0 15px 25px; margin-bottom: 25px; position: relative; }
    .banner .bg-img { width: 100%; height: auto; position: absolute; left: 0; bottom: 0; z-index: 1; }
    .banner .video-area { width: 100%; height: fit-content; margin: 0; position: relative; left: 0; top: 0; z-index: 2; }
    .banner .video-area video { border-radius: 10px;}
    .banner .news-area { width: 100%; margin: 0; height: 38px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; position: relative; z-index: 2; }
    .banner .news-area img { width: 15px; height: 15px; margin-right: 5px; }
    .banner .news-area marquee { width: calc(100% - 20px); height: 38px; line-height: 38px; overflow: hidden; font-size: 14px; font-weight: 400; color: #fff; }
    
    .container { width: 100%; max-width: 991px; padding: 0px 15px 100px; }

    .top-nav { width: 100%; height: 66px; margin-bottom: 25px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .top-nav .nav { width: 25%; height: 66px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; cursor: pointer; }
    .top-nav .nav img { width: 45px; height: 45px; }
    .top-nav .nav span { font-size: 12px; font-weight: 700; color: #151515; }

    .headings { width: 100%; height: 30px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; }
    .headings .title { font-size: 16px; font-weight: 400; color: #151515; position: relative; }
    .headings .title::after { content: ''; display: block; width: 40px; height: 4px; border-radius: 5px; background-color: #571fb2; position: absolute; left: 0; bottom: -4px; }
    .headings .right-link { font-size: 13px; font-weight: 400; color: #a1a1a1; }
    .headings .right-link i { font-size: 12px; }

    .news-block { width: 100%; height: 100px; background-color: #f1f1fe; border-radius: 7px; padding: 0 10px; margin-top: 15px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .news-block .left-img { width: 100px; height: 100px; border-radius: 7px; overflow: hidden; margin-right: 10px; }
    .news-block .right { width: calc(100% - 110px); }
    .news-block .right p { font-size: 14px; font-weight: 700; color: #151515; line-height: 19px; margin-bottom: 2px; }
    .news-block .right h6 { font-size: 12px; font-weight: 400; line-height: 16px; color: #9e9aa8; margin-bottom: 2px; }

    .sticky-service { width: 45px; height: 45px; background-color: #ffa200; border-radius: 25px 0 0 25px; display: flex; align-items: center; justify-content: center; position: fixed; right: 0; bottom: 200px; }
    .sticky-service img { width: 25px; height: 25px; }

    .footer-nav { width: 100%; max-width: 991px; height: 100px;  transform: translateX(-50%); position: fixed; left: 50%; bottom: 0; z-index: 100; }
    .footer-nav .footer-nav-bg { width: 100%; height: 100%; position: absolute; left: 0; top: 0; }
    .footer-nav .nav-set { width: 100%; height: 56px; position: absolute; left: 0; bottom: 6px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; }
    .footer-nav .nav-set .nav { width: 20%; height: 56px; padding: 4px 0 2px; display: flex; flex-direction: column; align-items: center; justify-content: space-between; }
    .footer-nav .nav-set .nav img { width: 24px; height: 24px; filter: brightness(1000%); }
    .footer-nav .nav-set .nav span { font-size: 14px; line-height: 14px; font-weight: 400; color: #fff; margin-bottom: 0; }
    .footer-nav .nav-set .nav.center { position: relative; }
    .footer-nav .nav-set .nav.center .circle { width: 60px; height: 60px; background-color: #080808; border-radius: 100%; display: flex; align-items: center; justify-content: center; position: absolute; top: -35px; }
    .footer-nav .nav-set .nav.center span { position: absolute; bottom: 2px; }
    .footer-nav .nav-set .nav.active img { filter: brightness(100%); }
    .footer-nav .nav-set .nav.active span { color: rgb(255, 162, 0); }

    .modal.load-modal .modal-content { width: calc(100% - 60px); height: fit-content; margin: 0 30px; padding: 0; border: 0; border-radius: 10px; background: #fff; position: relative; }
    .modal.load-modal .modal-content .modal-close { display: block; width: 28px; height: 28px; position: absolute; top: 5px; right: 5px; }
    .modal.load-modal .modal-content .heads { width: 100%; height: 70px; padding: 25px 0; background: transparent url(https://perview.freelancerawais.online/malltask/t/assets/img/home-modal-head-bg.png) no-repeat center center; background-size: 100%; font-size: 16px; font-weight: 400; color: #fff; line-height: 20px; text-align: center;  margin-top: -3px;}
    .modal.load-modal .modal-content .body { padding: 25px 25px 15px; }
    .modal.load-modal .modal-content p { font-size: 14px; font-weight: 400; line-height: 19px; color: #151515; margin-bottom: 20px; }
    .modal.load-modal .modal-content button.btn.btn-view { width: 240px; height: 45px; border: 0; border-radius: 25px; outline: 0; box-shadow: none; background: linear-gradient(90deg,#9169f3,#7843f5); padding: 0; font-size: 16px; font-weight: 400; color: #fff; }
</style>

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
        background-color: rgba(0, 0, 0, .5);
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
        background: url("") no-repeat center center;
        background-size: 100% 100%;
        margin-right: 10px;
    }


    


 
</style>

</head>







  <div class="header">
        <div class="logo"><img src="{{ asset('assets/images/logoIcon/logo.png') }}"  width="40"   ></div>
        
    </div>
    
    


@php
    $banners = getContent('banner.element');
@endphp
         
<body>
    <div class="container" id="con">
        <div class="loaderClass" id="loaderId">
            <div class="animation"></div>Loading
        </div>
        
        
    </div>
    
    @php
    $kycInfo = getContent('kyc_info.content',true);
@endphp
    
    
    <!-- Auto Modal -->
    <div class="modal load-modal fade" id="homeModal" tabindex="-1" aria-labelledby="homeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- <div class="modal-close" data-dismiss="modal"></div> -->
                <div class="heads">Announcement</div>
                <div class="body">
                    @if($kycInfo->data_values->image)
                        <img src="{{ getImage('assets/images/frontend/kyc_info/' . $kycInfo->data_values->image) }}" class="w-100 mb-3" style="max-height: 300px; object-fit: cover;">
                    @endif
                    <p>{{ __($kycInfo->data_values->verification_content) }}</p>
                    <div class="text-center"><button class="btn btn-view" onclick="" data-dismiss="modal">Close</button></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Auto Modal -->



 
    
    

    <div class="page">
            
   
        
        
        
        
        <div class="banner">
            
            <div class="video-area">
                   @foreach($banners as $banner)
                <div class="w-100">
                    
                    <br/>
                    <br/>
                    
                    <img src="{{ asset('assets/images/frontend/banner/'.$banner->data_values->image) }}" class="w-100">
                </div>
                 @endforeach
            
               
            </div>
            
          
            
            
            <div class="news-area">
                <img src="https://rethink.terrawatt.co.in/img/icon-notice.png">
                <marquee  > <font style="color:black;">Congratulations to user 598****661 for successfully withdrawing 8632{{ $general->cur_text }};Congratulations to user 983****124 for upgrading to VIP4, product profit increased by 1.2%;Congratulations to user 632****966 for upgrading to VIP2, product profit increased by 0.6%;Congratulations to user 856****778 for successfully withdrawing 1894{{ $general->cur_text }};</marquee></font>
            </div>
        </div>
        
        <div class="container">
            <div class="top-nav">
                <div class="nav" onclick="window.location.href='{{route ('user.deposit')}}'">
                    <img src="{{asset ('assets/img/icon-recharge.png')}}">
                    <span>Recharge</span>
                </div>
                <div class="nav" onclick="window.location.href='{{route ('user.withdraw')}}'">
                    <img src="{{asset ('assets/img/icon-withdraw.png')}}">
                    <span>Withdraw</span>
                </div>
                <div class="nav " onclick="window.location.href='{{ route('user.referred') }}'">
                    <img src="{{asset ('assets/img/icon-invite.png')}}">
                    <span>Invite</span>
                </div>
                <div class="nav" onclick="window.location.href=''">
                    <img src="{{asset ('assets/img/icon-download.png')}}">
                    <span>Download</span>
                </div>
            </div>
            
            
            
            @php
    $blogCaption = getContent('blog.content',true);
    $blogs = getContent('blog.element',false,3);
@endphp
            
            
            
            
            
            
            <div class="headings">
                <div class="title">News Notice</div>
                <div class="right-link" onclick="window.location.href=''"> <i class="bi bi-chevron-double-right"></i></div>
            </div>
             @foreach($blogs as $blog)
            
            <div class="news-block" onclick="window.location.href=''">
                <div class="left-img"><img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image) }}" class="w-100 h-100"></div>
               
                <div class="right">
                    <p>   {{ __($blog->data_values->title) }}  </p>
                    <h6>{{ strLimit(strip_tags($blog->data_values->description),80) }}</h6>
                    <h6 class="mb-0">Post by admin</h6>
                </div>
              
            </div>
                   
               @endforeach
        </div>
        
        
        
        
        
        
            <script type="text/javascript">
        $(window).on('load', function() {
            
        });
    </script>

    <script>
        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    
        $(document).ready(function() {
    
            let user = getCookie("username");
            if (user != "") {
    
            } else {
    
                $('#homeModal').modal('toggle');
            }
    
    
        });


        function showLoader(message) {
    
            $('#teleModal').modal('toggle');
            console.log("13");
    
            console.log("15");
            console.log(message);
            document.getElementById("loaderId").innerHTML = message
            $('.loaderClass').delay(3000).fadeOut(500);
    
            setTimeout(function() {
                location.reload();
            }, 1000);
    
    
    
        }
    </script>

    <script>
        $(".button-addon2").on('click', function() {
            document.getElementById("con").style.display = "flex";
        
            var target = $("#link");
    
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(target.val()).select();
            document.execCommand("copy");
            $temp.remove();
    
            // $(".button-addon2").text('Copied');
            window.setTimeout(function() {
    
                showLoader('Copy Link');
                // $(".button-addon2").text('Copy Link');
            }, 2000);
        });
        $(".button-addon3").on('click', function() {
            var target = $("#link1");
    
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(target.val()).select();
            document.execCommand("copy");
            $temp.remove();
    
            $(".button-addon3").text('Copied');
            window.setTimeout(function() {
                $(".button-addon3").text('Copy Code');
            }, 2000);
        });
    </script>

    <script>
        var selector = document.getElementById('contry-code');
        var modclose = document.getElementById('modal-close');
        var modback = document.getElementById('modal-back');
        var modfoot = document.getElementById('modal-foot');

        $(selector).on('click', function(){
            $(modback).addClass('show');
            $(modfoot).addClass('show');
        });
        $(modclose).on('click', function(){
            $(modback).removeClass('show');
            $(modfoot).removeClass('show');
        });
    </script>
</body>
        
        
        
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        
        
        
    @include($activeTemplate . 'partials.footers')
