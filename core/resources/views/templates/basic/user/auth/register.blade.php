<meta name="viewport" content="width=device-width, initial-scale=1" />

                    <link rel="stylesheet" href="{{asset ('assets/pub/npm/bootstrap%404.5.3/dist/css/bootstrap.min.css')}}" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset ('assets/pub/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css')}}" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="{{asset ('assets/pub/npm/bootstrap-icons%401.9.1/font/bootstrap-icons.css')}}">
<link rel="stylesheet" href="{{asset ('assets/pub/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css')}}" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="{{asset ('assets/pub/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css')}}" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
<link href="css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

<style>
    @import  url('css2');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 44px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 44px; background: #3244a8; font-size: 16px; line-height: 44px; font-weight: 600; color: #fff; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { font-size: 20px; position: absolute; left: 10px; top: 0; }

    .banner { width: 100%; height: 200px; background: linear-gradient(180deg,#3244a8,#3244a8); display: flex; align-items: center; justify-content: center; }
    .banner img { width: 60px; height: 60px; margin-top: -33px; }

    .form-block { width: 100%; height: 100%; background-color: #fff; border-radius: 25px 25px 0 0; padding: 25px 35px; position: relative; margin-top: -25px; }

    .container { width: 100%; max-width: 991px; padding: 30px 20px; }

    form.login-form { margin: 0; }
    form.login-form .form-group { width: 100%; height: 45px; background-color: #f1f1fe; border-radius: 25px; margin-bottom: 25px; }
    form.login-form .input-group-prepend .input-group-text { background-color: transparent; padding: 0; border: 0; width: 90px; padding-left: 15px; height: 45px; font-size: 12px; line-height: 15px; font-weight: 700; color: #571fb2; word-break: break-word; text-align: left; }
    form.login-form .input-group-text span { font-size: 14px; font-weight: 400; margin-left: 10px; color: #151515; }
    form.login-form input.form-control { height: 45px; line-height: 45px; background-color: transparent; border-radius: 0; border: 0; padding: 0px; font-size: 14px; font-weight: 400; color: #151515; padding: 0 15px; }
    form.login-form input.form-control::placeholder { color: #bebebe; }
    form.login-form .input-group-append .input-group-text { background-color: transparent; padding: 0 10px; border: 0; height: 45px; }
    form.login-form button.btn.btn-get { width: fit-content; height: 30px; background: #571fb2; border: 0; border-radius: 18px; font-size: 12px; font-weight: 400; color: #fff; margin: 0px; padding: 0 10px; }

    form.login-form button.btn.btn-submit { width: 100%; height: 45px; font-size: 16px; font-weight: 400; color: #fff; background: linear-gradient(90deg,#efcc00,#efcc00); border: 0px; border-radius: 25px; padding: 0; margin: 20px 0; }
    form.login-form button.btn.btn-submit.other { background: #3244a8; }
    form.login-form input.form-control:focus { box-shadow: none; }

    a.footer-link { font-size: 12px; font-weight: 400; line-height: 17px; color: #571fb2; text-decoration: none; display: block; text-align: right; margin-top: -10px; }

    .footer-modal-backdrop { width: 100%; max-width: 991px; height: 100%; background-color: rgba(0,0,0,0); position: fixed; transform: translateX(-50%); top: 0; left: 50%; z-index: 999; visibility: hidden; transition: all 0.3s ease-in-out; }
    .footer-modal-backdrop.show { background-color: rgba(0,0,0,0.6); visibility: visible; }
    .footer-modal { width: 100%; max-width: 991px; height: 250px; background-color: #fff; border-radius: 13px 13px 0 0; padding: 0 25px; transform: translateX(-50%); position: fixed; left: 50%; bottom: -250px; z-index: 1000; visibility: hidden; transition: all 0.3s ease-in-out; }
    .footer-modal.show { bottom: 0; visibility: visible; }
    .footer-modal .close { width: 100%; padding: 15px 0 0 0; margin-right: -10px; font-size: 16px; color: #151515; text-align: right; height: 50px; cursor: pointer; }
    .footer-modal .scroll-area { width: 100%; height: 150px; overflow-x: hidden; overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none; }
    .footer-modal .scroll-area::-webkit-scrollbar { display: none; }
    .footer-modal ul.list { list-style-type: none; height: 200px; padding: 50px 0 0 0; margin: 0; }
    .footer-modal ul.list li a { width: 100%; height: 50px; font-size: 14px; font-weight: 400; color: #151515; text-decoration: none; cursor: pointer; display: flex; flex-direction: row; align-items: center; justify-content: space-between; scroll-snap-align: center; }
    .footer-modal .scroll-overlay { width: calc(100% - 50px); height: 50px; background: linear-gradient(180deg,hsla(0,0%,100%,.95),hsla(0,0%,100%,.6)); border-bottom: 1px solid #e5e5e5; position: absolute; top: 50px; left: 25px; z-index: 1001; }
    .footer-modal .scroll-overlay::after { content: ''; width: 100%; height: 50px; background: linear-gradient(0deg,hsla(0,0%,100%,.95),hsla(0,0%,100%,.6)); border-top: 1px solid #e5e5e5; position: absolute; top: 100px; left: 0; z-index: 1001; }

    .form-check { margin: -10px 0 0; }
    .form-check .form-check-label, .form-check .form-check-label a.link { font-size: 12px; font-weight: 400; line-height: 17px; color: #571fb2; text-decoration: none; }
    input[type=checkbox] { position: relative; border: 1px solid #d1d1d1; border-radius: 100%; background: transparent; cursor: pointer; line-height: 17px; margin-right: 10px; outline: 0; padding: 0 !important; vertical-align: middle; height: 17px; width: 17px; -webkit-appearance: none; opacity: 1; left: 5px; top: -3px; }
    input[type=checkbox]:hover { opacity: 1; }
    input[type=checkbox]:checked { border-color: rgb(255, 162, 0); background-color: rgb(255, 162, 0); opacity: 1; }
    input[type=checkbox]:checked:before { content: ''; position: absolute; right: 50%; top: 50%; width: 4px; height: 8px; border: solid #fff; border-radius: 0px; border-width: 0 1px 1px 0; margin: 0px; transform: rotate(45deg) translate(-50%, -50%); z-index: 2; }

</style>
<style>

#con1 { display: none;  align-items: center; justify-content: center;

         position:absolute;
        max-width: 100%;
        height: auto;
        top: 50%;
        left: 50%;
        text-align: center;
        z-index: 999;
        transform: translate(-50%, -50%);

     }
    .loaderClass1 { height: 42px; width: fit-content;
  padding: 0px 15px;
    background-color: rgba(0,0,0,1);
    font-size: 15px; font-weight: 400;
    color: #ffffff; border-radius: 8px;
    display: flex; align-items: center; z-index: 9999;

    }

.loaderClass1 .animation { width: 20px; height: 20px; background: url('img/loading.gif')  no-repeat center center; background-size: 100% 100%; margin-right: 10px; }

   #con { display: none;  align-items: center; justify-content: center;

         position:absolute;
        max-width: 100%;
        height: auto;
        top: 50%;
        left: 50%;
        text-align: center;
        z-index: 999;
        transform: translate(-50%, -50%);

     }
    .loaderClass { height: 42px; width: fit-content;
  padding: 0px 15px;
    background-color: rgba(0,0,0,1);
    font-size: 15px; font-weight: 400;
    color: #ffffff; border-radius: 8px;
    display: flex; align-items: center; z-index: 9999;

    }

    .loaderClass .animation { width: 20px; height: 20px; background: url('img/loading.gif')  no-repeat center center; background-size: 100% 100%; margin-right: 10px; }

 .custom-toast {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: black;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      z-index: 9999;
      display: none;
        text-align: center;

    }
    @media (max-width: 767px) {
      .custom-toast {
        top: 50%; /* Center vertically */
        left: 50%; /* Center horizontally */
        transform: translate(-50%, -50%);
      }
    }

    .custom-toast.show {
      display: block;

    }

</style>

</head>

<body>

     <div id="custom-toast" class="custom-toast">
      <div class="custom-toast-content">

      </div>
    </div>

    <div class="header">
  Register
        <div class="left-arrow" onclick="window.location.href=''"><i class="bi bi-chevron-left"></i></div>
    </div>

    <div class="page">
        <div class="banner">
            <img      src="{{ asset('assets/images/logoIcon/logo.png') }}">
        </div>

        <div class="form-block">

                                  <form                 action="{{ route('user.register') }}" method="post"

                class="login-form">
          @csrf

               <div class="form-group">
                    <div class="input-group">

                        <div class="input-group-prepend">
                            <div class="input-group-text" style="width: fit-content;">Email ID<span id="contry-code"> </span></div>
                        </div>

                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email Address" required>

                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Password</div>
                        </div>

                         <input type="password" name="password" placeholder="@lang('Password')" class="form-control" required>

                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Re Pass</div>
                        </div>

                          <input type="password" name="password_confirmation" placeholder="@lang('Re-type Password')" class="form-control" required>

                    </div>
                </div>

                <!-- Referral Code Input - Optional -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Referral Code</div>
                        </div>
                        <input type="text" name="referral_code" class="form-control" placeholder="Enter referral code (optional)" value="{{ session()->get('ref') }}" readonly>
                    </div>
                </div>

                <!-- Show referral message if referral code is in session -->
                @if (session()->get('ref') != null)
                    <?php
                    // Get the user's username from the session
                    $username = session()->get('ref');

                    // Search for the username in the users table
                    $user = App\Models\User::where('ref', $username)->first();

                    // Check if the user exists
                    if ($user) {
                        // Username exists
                        $message = "<center><p class='alert alert-success'><strong>{$user->username}</strong> has invited you to join <strong>Our Platform</strong></p></center>";
                    } else {
                        // Username does not exist
                        $message = "<center><p class='alert alert-danger'><strong>{$username}</strong> User not found.</p></center>";
                    }

                    // Display the message
                    echo $message;
                    ?>
                @endif

                <button class="btn btn-submit"  type="submit">Register</button>

                <button class="btn btn-submit other mt-0" type="button" onclick="window.location.href='{{route ('user.login')}}'">login</button>

        </div>

    <div class="container" id="con">
        <div class="loaderClass" id="loaderId">
            <div class="animation"></div>Loading
        </div>
    </div>
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
            background: url("img/loading.gif") no-repeat center center;
            background-size: 100% 100%;
            margin-right: 10px;
        }
    </style>
    <script src="https://perview.freelancerawais.online/malltask/assets/pub/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</body>
</html>

  @include('partials.notify')

</html>