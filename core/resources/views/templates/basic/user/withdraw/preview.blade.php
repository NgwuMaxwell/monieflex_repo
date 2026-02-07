
                  <form class="needs-validation" action="{{ route('user.withdraw.submit') }}" method="post">
                    @csrf
                    
                    
                    
                    
                    
                    
                   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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

        html,
        body {
            margin: 0;
            background: #fff;
            font-size: 15px;
            font-weight: 400;
            color: rgba(0,0,0,.9);
            font-family: 'Roboto', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            text-shadow: rgba(0,0,0,.01) 0 0 1px;
        }

        .page-header {
            width: 100%;
            max-width: 991px;
            height: 44px;
            background: #fff;
            font-size: 16px;
            line-height: 44px;
            font-weight: 600;
            color: #151515;
            text-align: center;
            position: fixed;
            transform: translateX(-50%);
            left: 50%;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #eee;
        }

        .page-header .left-arrow {
            font-size: 20px;
            position: absolute;
            left: 10px;
            top: 0;
            cursor: pointer;
            color: rgb(87, 31, 178);
        }

        .page-header .right-icon {
            font-size: 18px;
            position: absolute;
            color: rgb(87, 31, 178);
            right: 10px;
            top: 0;
        }

        .container {
            width: 100%;
            max-width: 991px;
            padding: 20px 15px 15px;
            margin-top: 44px;
        }

        .banner {
            width: 100%;
            height: fit-content;
            background: linear-gradient(90deg,#3244a8,#7d2b73);
            border-radius: 10px 10px 0 0;
            padding: 30px 0;
        }

        .banner .txt {
            width: 100%;
            text-align: left;
            color: #fff;
            padding: 0 25px;
        }

        .banner .txt p {
            font-size: 14px;
            line-height: 19px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .banner .txt h3 {
            font-size: 22px;
            line-height: 29px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .title {
            font-size: 16px;
            font-weight: 700;
            line-height: 21px;
            color: #151515;
            margin: 15px 0;
        }

        .code-copy-row {
            width: 100%;
            height: 46px;
            border-top: 2px solid #f3f3f3;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .code-copy-row .left {
            font-size: 16px;
            font-weight: 700;
            color: #000;
        }

        .code-copy-row .code {
            font-size: 15px;
            font-weight: 400;
            color: #000;
        }

        .code-copy-row .copy {
            width: 60px;
            height: 46px;
            line-height: 46px;
            display: block;
            border-left: 1px solid #e5e5e5;
            font-size: 15px;
            font-weight: 400;
            color: #07c160;
            text-align: center;
        }

        .input-footer {
            font-size: 13px;
            font-weight: 400;
            color: #9e9e9e;
        }

        .demo-block {
            width: 100%;
            height: fit-content;
            background-color: #f1f1f1;
            border-top: 1px solid #ededed;
            border-bottom: 1px solid #ededed;
            padding: 15px 20px;
            margin-bottom: 75px;
        }

        .demo-title {
            font-size: 14px;
            font-weight: 400;
            color: #888;
            margin-bottom: 15px;
        }

        .demo-img {
            width: 100%;
            height: fit-content;
            margin-bottom: 8px;
        }

        .demo-img img {
            width: 100%;
        }

        button.btn.footer-btn {
            width: 100%;
            height: 46px;
            background: linear-gradient(90deg,#3244a8,#7843f5);
            border: 0px;
            border-radius: 25px;
            position: fixed;
            left: 0;
            bottom: 0;
            z-index: 100;
            font-size: 18px;
            font-weight: 400;
            color: #fff;
        }

        button:focus,
        input:focus {
            box-shadow: none !important;
        }
    </style>

</head>

<body>
  
        

        

                

        <div class="page-header">
            <div class="left-arrow" onclick="history.back()">
                <i class="fas fa-arrow-left"></i>
            </div>
            Cashout Now
        </div>
        <div class="container">
            <div class="banner">
                <div class="txt">
                    <p>Transfer to the following</p>
                    <h3>Pay Details</h3>
                </div>
            </div>
            
            <div class="icons-title"></div>
            <div class="icons-set">

            </div>
        </div>
        <hr>
        </hr>
        <div class="container pt-2">
            <div class="code-copy-row">
                <div class="left">Pay Details</div>
                <div class="code">  @php
                        echo $withdraw->method->description;
                      @endphp</div>
                <input type="hidden" id="link" class="form-control" value="">
                
                
                
                
                <div type="button" class="copy button-addon2"></div>
            </div>
  <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}"></x-viser-form>
          
            <div class="input-footer">Generally, your transfer will be confirmed within 2 working days</div>
        </div>
        <div class="demo-block">

      
        <button type="submit"  class="btn footer-btn">Confirm withdraw</button>

    </form>
						  


                

   
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    


                  

<script src="/assets/global/js/jquery-3.6.0.min.js"></script>

@include('partials.notify')

