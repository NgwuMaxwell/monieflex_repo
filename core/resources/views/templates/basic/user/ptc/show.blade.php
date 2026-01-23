<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/png" href="{{ getImage(fileManager()->logoIcon()->path . '/favicon.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- bootstrap -->
    @php
        $activeTemplateTrue = activeTemplate(true);
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <script>
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.body.innerHTML = `
                       <div class="d-flex flex-wrap justify-content-center align-items-center clear-msg">
                            <h3 class="text-danger text-center">@lang('Currently you are unavailable to view this add. Please dont\'t leave the window.')</h3>
                        </div>
                    `;
            }
        });
    </script>
    <style>
        #myProgress {
            width: 100%;
            background-color: #ddd;
        }

        #myBar {
            width: 10%;
            height: 30px;
            background-color: #5FA625;
            text-align: center;
            line-height: 30px;
            color: white;
        }

        #confirm {
            color: white;
            font-weight: 600;
        }

        .inputcaptcha {
            width: 60px;
        }

        .btn {
            margin-top: -4px;
        }

        @media (max-width: 767px) {
            ul.nav.navbar-nav.navbar-right {
                margin-top: 15px;
            }

            .container {
                display: flex !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 320px) {
            .row {
                display: flex;
                justify-content: center;
            }

            .btn {
                margin-top: 5px;

            }
        }

        .adFram {
            border: 0;
            position: absolute;
            top: 14%;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%
        }

        .adFram {
            top: 86px;
        }

        @media (max-width: 400px) {
            .advertise-wrapper iframe {
                margin-top: unset;
            }
        }

        .adBody {
            position: absolute;
            top: 30%;
            left: 40%;
        }

        @media (max-width: 400px) {
            .advertise-wrapper iframe {
                margin-top: 43px;
            }
        }

        .iframe-container {
            position: absolute;
            width: 60%;
            padding-bottom: 56.25%;
            display: flex;
            justify-content: center;
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media only screen and (max-width: 768px) {
            .adFram {
                top: 124px !important;
            }
        }

        @media only screen and (max-width: 446px) {
            .adFram {
                top: 162px !important;
            }
        }

        @media only screen and (max-width: 288px) {
            .adFram {
                top: 192px !important;
            }
        }

        @media only screen and (max-width: 218px) {
            .adFram {
                top: 202px !important;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-primary p-4">
        <div class="container">
            <div class="row w-100">
                <div class="col-md-4">
                    <div id="myProgress">
                        <div id="myBar">0%</div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form action="" id="confirm-form" method="post">
                        @csrf
                        <ul class="nav navbar-nav text-end mt-md-0 mt-2">
                            <li class="active">
                                <span id="inputcaptchahidden" class="d-none">
                                    <input id="cap_number_1" name="first_number" class="inputcaptcha" value="{{ rand(0, 9) }}" type="text" readonly>
                                    <label for="exampleInputEmail2 text-white"> + </label>
                                    <input id="cap_number_2" name="second_number" class="inputcaptcha" value="{{ rand(0, 9) }}" type="text" readonly>
                                    <label for="exampleInputEmail2 text-white">=</label>
                                    <input type="number" name="result" class="inputcaptcha" id="cap_result" required>&nbsp;
                                </span>
                                <button type="button" id="confirm" class="btn btn-danger btn-md mt-sm-0 mt-2" disabled>
                                    @lang('Loading Task')
                                </button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <script>
        (function($, document) {
            "use strict";
            $('#cap_result').on('input', function() {
                var val1 = document.getElementById("cap_number_1").value;
                var val2 = document.getElementById("cap_number_2").value;
                var val3 = document.getElementById("cap_result").value;
                var sum = parseInt(+val1 + +val2);
                if (sum == val3) {
                    var confirmButton = document.getElementById("confirm");
                    confirmButton.removeAttribute('disabled');
                    confirmButton.setAttribute('type', 'submit');
                    confirmButton.className = "btn btn-success";
                    document.getElementById('confirm-form').setAttribute('action', '{{ route('user.ptc.confirm', encrypt($ptc->id . '|' . auth()->user()->id)) }}');

                    // Try to unmute video when user interacts with captcha
                    tryToUnmuteVideo();
                } else {
                    var confirmButton = document.getElementById("confirm");
                    confirmButton.setAttribute('disabled', '');
                    confirmButton.className = "btn btn-danger";
                    confirmButton.removeAttribute('href', '#');
                }
            });

            function move() {
                var elem = document.getElementById("myBar");
                var width = 0;
                var id = setInterval(frame, {{ $ptc->duration * 10 }});

                function frame() {
                    if (width >= 100) {
                        var confirmButton = document.getElementById("confirm");
                        confirmButton.className = "btn btn-danger mt-sm-0 mt-2";
                        confirmButton.innerHTML = "Confirm Earn";
                        var captchaInputHidden = document.getElementById("inputcaptchahidden");
                        captchaInputHidden.classList.remove("d-none");
                        clearInterval(id);
                    } else {
                        width++;
                        elem.style.width = width + '%';
                        elem.innerHTML = width + '%';
                    }
                }
            }

            // Function to try unmuting video after user interaction
            function tryToUnmuteVideo() {
                const video = document.getElementById('ptcVideo');
                if (video) {
                    video.muted = false;
                    video.volume = 1.0;
                    // Try to play again to ensure it's unmuted
                    video.play().catch(function(error) {
                        console.log('Video unmute failed:', error);
                        // If unmute fails, keep it muted but playing
                        video.muted = true;
                        video.play();
                    });
                }
            }

            // Add click event to document to try unmuting on any user interaction
            document.addEventListener('click', function() {
                tryToUnmuteVideo();
            }, { once: true }); // Only trigger once

            // Also try on keypress
            document.addEventListener('keypress', function() {
                tryToUnmuteVideo();
            }, { once: true });

            window.onload = function() {
                move();

                // Try to unmute after a short delay (browsers may allow this)
                setTimeout(function() {
                    tryToUnmuteVideo();
                }, 1000);

                // Ensure video plays and loops if needed
                const video = document.getElementById('ptcVideo');
                if (video) {
                    video.addEventListener('ended', function() {
                        // If video ends, restart it
                        video.currentTime = 0;
                        video.play();
                    });

                    // Force play on load
                    video.play().catch(function(error) {
                        console.log('Initial video play failed:', error);
                    });
                }
            };
        })(jQuery, document);
    </script>

    <div class="advertise-wrapper">
        @if ($ptc->ads_type == 1)
            <iframe src="{{ $ptc->ads_body }}" class="adFram"></iframe>
        @elseif($ptc->ads_type == 2)
            <div class="container mt-5">
                <img src="{{ getImage(fileManager()->ptc()->path . '/' . $ptc->ads_body) }}" class="w-100">
            </div>
        @elseif($ptc->ads_type == 3)
            <div class="adBody">
                @php echo $ptc->ads_body @endphp
            </div>
        @elseif($ptc->ads_type == 5)
            <div class="d-flex justify-content-center align-items-center" style="position: absolute; top: 86px; left: 0; right: 0; bottom: 0; padding: 20px; box-sizing: border-box;">
                <video id="ptcVideo" autoplay muted playsinline disablepictureinpicture controlslist="nodownload" style="max-width: 100%; max-height: 100%; pointer-events: none;">
                    <source src="{{ url('assets/images/ptc/' . $ptc->ads_body) }}" type="video/mp4">
                    <source src="{{ url('assets/images/ptc/' . $ptc->ads_body) }}" type="video/avi">
                    <source src="{{ url('assets/images/ptc/' . $ptc->ads_body) }}" type="video/mov">
                    <source src="{{ url('assets/images/ptc/' . $ptc->ads_body) }}" type="video/wmv">
                    Your browser does not support the video tag.
                </video>
            </div>
        @else
            <div class="d-flex justify-content-center">
                <div class="iframe-container">
                    <iframe src="{{ $ptc->ads_body }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen" allowfullscreen sandbox="allow-scripts allow-same-origin allow-presentation" loading="lazy"></iframe>
                    @if(config('app.debug'))
                        <div class="mt-2 p-2 bg-light text-center">
                            <small class="text-muted">Debug: YouTube URL: {{ $ptc->ads_body }}</small>
                        </div>
                    @endif
                </div>
                <div class="mt-3 text-center">
                    <small class="text-muted">If video doesn't load, try refreshing the page or check your browser settings.</small>
                </div>
            </div>
        @endif
    </div>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
