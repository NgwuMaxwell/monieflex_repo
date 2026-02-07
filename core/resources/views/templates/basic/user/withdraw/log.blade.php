@include($activeTemplate . 'partials.headers')




<style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 18px; font-weight: 700; color: #ffffff; text-align: center; line-height: 60px; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; box-shadow: 0 4px 20px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; }
    .header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); }
    .header .back-btn { width: 30px; height: 30px; position: absolute; left: 15px; top: 15px; cursor: pointer; }
    .header .back-btn i { color: #fff; font-size: 24px; }
    .header span { position: relative; z-index: 2; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
    
    .container { width: 100%; max-width: 991px; padding: 20px 15px 120px; }

    .banner { width: 100%; height: fit-content; background: transparent url(https://perview.freelancerawais.online/malltask/t/assets/img/withdraw-record-banner-bg.png) no-repeat center center; background-size: 100%; overflow: hidden; border-radius: 10px 10px 0 0; padding: 30px 0; }
    .banner .txt { width: 100%; text-align: center; color: #fff; }
    .banner .txt p { font-size: 14px; line-height: 19px; font-weight: 700; margin-bottom: 5px; }
    .banner .txt h3 { font-size: 22px; line-height: 29px; font-weight: 700; margin-bottom: 0; }
    
    .empty { width: 140px; height: fit-content; margin: 50px auto; }

    .footer-nav { width: 100%; max-width: 991px; height: 100px; transform: translateX(-50%); position: fixed; left: 50%; bottom: 0; z-index: 100; }
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

    .card.match-card {
        width: 100%;
        background-color: #ddd;
        border: 0px;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
        box-shadow: 0 1px 6px 0 rgba(0, 0, 0, .1);
    }

    .card.match-card .league-row {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .card.match-card .league-row .league-name {
        font-size: 15px;
        line-height: 17px;
        font-weight: 600;
        color: #263249;
    }

    .card.match-card .league-row .timer {
        font-size: 11px;
        line-height: 17px;
        font-weight: 400;
        color: #a20334;
        position: relative;
        padding-left: 15px;
    }

    .card.match-card .league-row .timer::before {
        content: '';
        display: block;
        width: 6px;
        height: 6px;
        border-radius: 100%;
        background-color: #a20334;
        outline: 2px solid rgba(162, 3, 52, .2);
        position: absolute;
        left: 0;
        top: 4.5px;
    }

    .card.match-card .date {
        color: #a20334;
        font-size: 16px;
        font-weight: 400;
        text-align: center;
        margin-bottom: 15px;
    }

    .card.match-card .teams {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        flex-wrap: wrap;
    }

    .card.match-card .teams .team {
        width: calc(50% - 28px);
        font-size: 15px;
        line-height: 18px;
        font-weight: 600;
        color: #263249;
        text-align: left;
        display: flex;
        flex-direction: row;
        align-items: center;
        flex-wrap: wrap;
    }

    .card.match-card .teams .team span {
        width: calc(100% - 41px);
    }

    .card.match-card .teams .team img {
        width: 31px;
        height: 31px;
        margin-right: 10px;
    }

    .card.match-card .teams .team.left {
        text-align: right;
    }

    .card.match-card .teams .team.left img {
        margin-right: 0;

        margin-left: 10px;
    }

    .card.match-card .teams .vs {
        width: 26px;
        height: 26px;
        margin: 0 15px;
    }

    .card.match-card .teams .vs img {
        width: 100%;
        height: 100%;
    }
</style>

</head>

<body>
    <div class="header">
        <a href="{{ route('user.profile.setting') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
        </a>
        <span>Withdraw Record</span>
    </div>
    <div class="page">
        <div class="container">
            <div class="banner">
                <div class="txt">
                    <p></p>
                    <h3></h3>
                </div>
            </div>

            <br/>
            <br/>
            <br/>
            
                        
   @forelse($withdraws as $withdraw)


            <div class="card match-card">
                 
                <div class="league-row">
                   
                    <div class="league-name">Withdraw: {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount ) }}</div>
                    <div class=""> {{ showDateTime($withdraw->created_at) }}</div>
                </div>
                <div style="text-align: right; margin-top: 5px; font-size: 12px; color: #666;">
                    @if($withdraw->wallet_type == 'referral_bonus')
                        From Referral Bonus Wallet
                    @else
                        From Profit Wallet
                    @endif
                </div>

                <div class="teams">
                                        <span class="badge badge-">@php echo $withdraw->statusBadge @endphp</span>
                                    </div>
            </div>
            
     @empty
                  <tr>
                    <td colspan="4">
                      <center>
                        <h2>No History</h2>
                      </center>
                    </td>
                  </tr>
                  @endforelse
                                </div>
             
                                                
                                  
                                      
                                 
                                </div>
                                
                               

    



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>
</html>



        










               

                
             
@include('partials.notify')
@include($activeTemplate . 'partials.footers')
