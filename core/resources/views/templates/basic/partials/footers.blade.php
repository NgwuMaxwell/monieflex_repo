
        <style>

    .footer-nav .nav-set .nav img { width: 24px; height: 24px; filter: brightness(1000%); }
    .footer-nav .nav-set .nav span { font-size: 14px; line-height: 14px; font-weight: 400; color: #fff; margin-bottom: 0; }
    .footer-nav .nav-set .nav.center { position: relative; }
    .footer-nav .nav-set .nav.center .circle { width: 60px; height: 60px; background-color: #3244a8; border-radius: 100%; display: flex; align-items: center; justify-content: center; position: absolute; top: -35px; }
    .footer-nav .nav-set .nav.center span { position: absolute; bottom: 2px; }
    .footer-nav .nav-set .nav.active img { filter: brightness(100%); }
    .footer-nav .nav-set .nav.active span { color: (255, 162, 0); }
   </style>


   <div class="footer-nav">
    <div class="footer-nav-bg"><img src="{{asset ('assets/img/footer-menubar.png')}}" class="w-100 h-100"></div>
    <div class="nav-set">
        <div class="nav active" onclick="window.location.href='{{route ('user.home')}}'">
            <img src="{{asset ('assets/img/icon-home.png')}}">
            <span>Home</span>
        </div>
        <div class="nav " onclick="window.location.href='{{route ('plans')}}'">
            <img src="{{asset ('assets/img/icon-rent.png')}}">
            <span>Plans</span>
        </div>
        <div class="nav center" onclick="window.location.href='{{ route('user.referred') }}'">
            <div class="circle"><img src="{{asset ('assets/img/icon-share.png')}}"></div>
            <span>Share</span>
        </div>
        <div class="nav " onclick="window.location.href='{{ route('user.ptc.index') }}'">
            <img src="{{asset ('assets/img/icon-income.png')}}">
            <span>Task</span>
        </div>
        <div class="nav " onclick="window.location.href='{{ route('user.profile.setting') }}'">
            <img src="{{asset ('assets/img/icon-user.png')}}">
            <span>User</span>
        </div>
    </div>
</div>

  

    </div>


    <!-- Modal -->
    <div id="myModal" class="modal modal-custom fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-body">
                    <h6 class="text-center mb-4">Are you sure you want to buy this plan?</h6>
                    <div class="d-flex flex-row justify-content-end">
                        <input type="hidden" id="custId" name="custId" value="">
                        <a href="#" class="btn-yes" onclick="submite()">Yes</a>
                        <a href="#" data-dismiss="modal" class="btn-no">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

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
</html>
