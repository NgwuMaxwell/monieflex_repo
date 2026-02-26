<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>MonieFlex Website</title>
        
        <!-- CSRF Token for AJAX requests -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Dynamic Base URL Configuration -->
        <script>
            // Determine the base URL based on the current environment
            function getBaseUrl() {
                const currentUrl = window.location.origin;
                // If we're on localhost, use localhost URL, otherwise use production URL
                if (currentUrl.includes('localhost') || currentUrl.includes('127.0.0.1')) {
                    return currentUrl + '/app1';
                } else {
                    return 'https://monieflex.site';
                }
            }
            
            // Make base URL available globally
            window.APP_BASE_URL = getBaseUrl();
            
            // Update all relative links to use the correct base URL
            document.addEventListener('DOMContentLoaded', function() {
                // Update all links that start with /user/ or /contact
                const links = document.querySelectorAll('a[href^="/user/"], a[href^="/contact"], a[href^="/"]');

                links.forEach(function(link) {
                    const href = link.getAttribute('href');
                    if (href && href.startsWith('/')) {
                        // Skip if it's just "/" (homepage)
                        if (href === '/') {
                            return;
                        }
                        
                        // Update the href to use the correct base URL
                        link.setAttribute('href', window.APP_BASE_URL + href);
                    }
                });
            });
        </script>

        <!-- CSS FILES -->        
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

        <link href="{{ asset('css/templatemo-kind-heart-charity.css') }}" rel="stylesheet">

        <!-- Custom CSS for Blog Layout -->
        <style>
            .news-block-preview {
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                line-height: 1.4;
                max-height: 4.2em; /* 3 lines * 1.4 line-height */
                margin-bottom: 0;
            }
            
            .news-block-body {
                margin-bottom: 1rem;
            }
            
            .news-block {
                margin-bottom: 2rem;
            }
        </style>


    </head>
    
    <body id="section_1">

        <header class="site-header">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-8 col-12 d-flex flex-wrap">
                        <p class="d-flex me-4 mb-0">
                            <i class="bi-geo-alt me-2"></i>
                            Akershusstranda 20, 0150 Oslo, Norway
                        </p>

                        <p class="d-flex mb-0">
                            <i class="bi-envelope me-2"></i>

                            <a href="mailto:info@monieflex.site">
                                info@monieflex.site
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-12 ms-auto d-lg-block d-none">
                        <ul class="social-icon">
                            <li class="social-icon-item">
                                <a href="" class="social-icon-link bi-twitter"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="" class="social-icon-link bi-facebook"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="" class="social-icon-link bi-instagram"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="" class="social-icon-link bi-youtube"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="" class="social-icon-link bi-whatsapp"></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </header>

        <nav class="navbar navbar-expand-lg bg-light shadow-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo0.png') }}" class="logo img-fluid" alt="MonieFlex">
                    <span>
                        MonieFlex
                        <small>Your Investment Platform</small>
                    </span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#top">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_3">Plans</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_4">News</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_5">Contact</a>
                        </li>

                        <li class="nav-item ms-3">
                            <a class="nav-link custom-btn custom-border-btn btn" href="/user/login">Login</a>
                        </li>
                        <li class="nav-item ms-3">
                            <a class="nav-link custom-btn custom-border-btn btn" href="/user/register">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main>

            <section class="hero-section hero-section-full-height">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-12 col-12 p-0">
                            <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/slide/1.png') }}" class="carousel-image img-fluid" alt="...">
                                        
                                        <div class="carousel-caption d-flex flex-column justify-content-end">
                                            <h1>Sign Up!</h1>
                                            
                                            <p>Start your Investment journey </br>With Us Today!</p>
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <img src="{{ asset('images/slide/2.png') }}" class="carousel-image img-fluid" alt="...">
                                        
                                        <div class="carousel-caption d-flex flex-column justify-content-end">
                                            <h1>Login</h1>
                                            
                                            <p>Start your Investment journey </br>With Us Today!</p>
                                        </div>
                                    </div>

                                    <div class="carousel-item">
                                        <img src="{{ asset('images/slide/3.png') }}" class="carousel-image img-fluid" alt="...">
                                        
                                        <div class="carousel-caption d-flex flex-column justify-content-end">
                                            <h1>Register</h1>
                                            
                                            <p>Start your Investment journey </br>With Us Today!</p>
                                        </div>
                                    </div>

                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button" data-bs-target="#hero-slide" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-10 col-12 text-center mx-auto">
                            <h2 class="mb-5">Welcome to MonieFlex</h2>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                            <div class="featured-block d-flex justify-content-center align-items-center">
                                <a href="/user/register" class="d-block">
                                    <img src="{{ asset('images/icons/1.png') }}" class="featured-block-image img-fluid" alt="">

                                    <p class="featured-block-text">Create an <strong>Account</strong></p>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                            <div class="featured-block d-flex justify-content-center align-items-center">
                                <a href="/user/register" class="d-block">
                                    <img src="{{ asset('images/icons/2.png') }}" class="featured-block-image img-fluid" alt="">

                                    <p class="featured-block-text"><strong>Deposit</strong> Capital</p>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-4">
                            <div class="featured-block d-flex justify-content-center align-items-center">
                                <a href="/user/register" class="d-block">
                                    <img src="{{ asset('images/icons/3.png') }}" class="featured-block-image img-fluid" alt="">

                                    <p class="featured-block-text">Buy a <strong>Plan</strong></p>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                            <div class="featured-block d-flex justify-content-center align-items-center">
                                <a href="/user/register" class="d-block">
                                    <img src="{{ asset('images/icons/4.png') }}" class="featured-block-image img-fluid" alt="">

                                    <p class="featured-block-text"><strong>Earn</strong> every<strong> Day</strong></p>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="section-padding section-bg" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                            <img src="{{ asset('images/about-team.jpeg') }}" class="custom-text-box-image img-fluid" alt="">
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="custom-text-box">
                                <h2 class="mb-2">About Us</h2>

                                <h5 class="mb-3">MonieFlex: The Best Investment Platform</h5>

                                <p class="mb-0">MonieFlex is a structured digital earning platform designed to provide individuals with accessible income opportunities through subscription plans, affiliate marketing, and promotional engagement. Built on a simple and transparent model, MonieFlex allows members to activate earning privileges by subscribing to a plan and participating in platform activities.</p>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="custom-text-box mb-lg-0">
                                        <h5 class="mb-3">Our Mission</h5>

                                        <p>MonieFlex combines innovation, structure, and opportunity to create a system where commitment and strategic engagement translate into measurable rewards.</p>

                                        <ul class="custom-list mt-2">
                                            <li class="custom-list-item d-flex">
                                                <i class="bi-check custom-text-box-icon me-2"></i>
                                                Instant Cashback
                                            </li>

                                            <li class="custom-list-item d-flex">
                                                <i class="bi-check custom-text-box-icon me-2"></i>
                                                Earn By Referral 
                                            </li>

                                            <li class="custom-list-item d-flex">
                                                <i class="bi-check custom-text-box-icon me-2"></i>
                                                Earn By Daily Tasks
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="custom-text-box d-flex flex-wrap d-lg-block mb-lg-0">
                                        <div class="counter-thumb"> 
                                            <div class="d-flex">
                                                <span class="counter-number" data-from="1" data-to="2024" data-speed="1000"></span>
                                                <span class="counter-number-text"></span>
                                            </div>

                                            <span class="counter-text">Founded</span>
                                        </div> 

                                        <div class="counter-thumb mt-4"> 
                                            <div class="d-flex">
                                                <span class="counter-number" data-from="1" data-to="10" data-speed="1000"></span>
                                                <span class="counter-number-text">K+</span>
                                            </div>

                                            <span class="counter-text">Investors</span>
                                        </div> 

                                        <div class="counter-thumb mt-4"> 
                                            <div class="d-flex">
                                                <span class="counter-number" data-from="1" data-to="90" data-speed="1000">$</span>
                                                <span class="counter-number-text">K+</span>
                                            </div>

                                            <span class="counter-text">Withdrawals</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="about-section section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-5 col-12">
                            <img src="{{ asset('images/portrait-volunteer-who-organized-donations-charity.jpg') }}" class="about-image ms-lg-auto bg-light shadow-lg img-fluid" alt="">
                        </div>

                        <div class="col-lg-5 col-md-7 col-12">
                            <div class="custom-text-block">
                                <h2 class="mb-0">Sandy Chan</h2>

                                <p class="text-muted mb-lg-4 mb-md-4">Co-Founding Partner</p>

                                <p>Lorem Ipsum dolor sit amet, consectetur adipsicing kengan omeg kohm tokito Professional charity theme based</p>

                                <p>You are not allowed to redistribute this template ZIP file on any other template collection website. Please contact TemplateMo for more information.</p>

                                <ul class="social-icon mt-4">
                                    <li class="social-icon-item">
                                        <a href="" class="social-icon-link bi-twitter"></a>
                                    </li>

                                    <li class="social-icon-item">
                                        <a href="" class="social-icon-link bi-facebook"></a>
                                    </li>

                                    <li class="social-icon-item">
                                        <a href="" class="social-icon-link bi-instagram"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="cta-section section-padding section-bg">
                <div class="container">
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-5 col-12 ms-auto">
                            <h2 class="mb-0">Start Saving! <br> Start Investing!</h2>
                        </div>

                        <div class="col-lg-5 col-12">
                            <a href="/user/login" class="me-4">Login Now!</a>

                            <a href="/user/register" class="custom-btn btn smoothscroll">Create an Account!</a>
                        </div>

                    </div>
                </div>
            </section>


            <section class="section-padding" id="section_3" style="background: linear-gradient(to bottom, white 0%, #f0f2f5 50%, #e9ecef 100%);">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center mb-4">
                            <h2>Our Plans</h2>
                        </div>

                        <div class="col-12">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                    <div class="custom-block-wrap">
                                        <img src="{{ asset('images/causes/plansA.jpeg') }}" class="custom-block-image img-fluid" alt="">

                                        <div class="custom-block">
                                            <div class="custom-block-body">
                                                <h5 class="mb-3">MonieFlex Light</h5>

                                                <p>An entry-level plan designed for individuals starting their earning journey.</p>

                                                <div class="progress mt-4">
                                                    <div class="progress-bar w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                <div class="d-flex align-items-center my-2">
                                                    <p class="mb-0">
                                                        <strong>Price:</strong>
                                                        ₦6,000
                                                    </p>

                                                    <p class="ms-auto mb-0">
                                                        <strong>CashBack:</strong>
                                                        ₦3,000
                                                    </p>
                                                </div>
                                            </div>

                                            <a href="/user/register" class="custom-btn btn">Buy Plan</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                    <div class="custom-block-wrap">
                                        <img src="{{ asset('images/causes/plansB.jpeg') }}" class="custom-block-image img-fluid" alt="">

                                        <div class="custom-block">
                                            <div class="custom-block-body">
                                                <h5 class="mb-3">MonieFlex Gold</h5>

                                                <p>This is a premium plan that unlocks enhanced earning potential and greater benefits.</p>

                                                <div class="progress mt-4">
                                                    <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                <div class="d-flex align-items-center my-2">
                                                    <p class="mb-0">
                                                        <strong>Price:</strong>
                                                        ₦10,000
                                                    </p>

                                                    <p class="ms-auto mb-0">
                                                        <strong>CashBack:</strong>
                                                        ₦7,000
                                                    </p>
                                                </div>
                                            </div>

                                            <a href="/user/register" class="custom-btn btn">Buy Plan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="news-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 mb-5">
                            <h2>Latest News</h2>
                        </div>

                        <div class="col-lg-7 col-12">
                            @foreach($posts as $post)
                            <div class="news-block">
                                <div class="news-block-top">
                                    <a href="{{ route('news.detail', $post->slug) }}">
                                        <img src="{{ asset('storage/' . ($post->data_values->image ?? 'images/default.png')) }}" class="news-image img-fluid" alt="{{ $post->data_values->title ?? 'Blog Post' }}">
                                    </a>

                                    <div class="news-category-block">
                                        <a href="" class="category-block-link">
                                            Investment,
                                        </a>
                                        <a href="" class="category-block-link">
                                            News,
                                        </a>
                                        <a href="" class="category-block-link">
                                            Monieflex
                                        </a>
                                    </div>
                                </div>

                                <div class="news-block-info">
                                    <div class="d-flex mt-2">
                                        <div class="news-block-date">
                                            <p>
                                                <i class="bi-calendar4 custom-icon me-1"></i>
                                                {{ $post->created_at->format('F j, Y') }}
                                            </p>
                                        </div>

                                        <div class="news-block-author mx-5">
                                            <p>
                                                <i class="bi-person custom-icon me-1"></i>
                                                By Admin
                                            </p>
                                        </div>

                                        <div class="news-block-comment">
                                            <p>
                                                <i class="bi-chat-left custom-icon me-1"></i>
                                                {{ $post->comments ? $post->comments->count() : 0 }} Comments
                                            </p>
                                        </div>
                                    </div>

                                    <div class="news-block-title mb-2">
                                        <h4><a href="{{ route('news.detail', $post->slug) }}" class="news-block-title-link">{{ $post->data_values->title ?? 'Untitled Post' }}</a></h4>
                                    </div>

                                    <div class="news-block-body">
                                        <p class="news-block-preview">{{ Str::limit(strip_tags($post->data_values->description ?? ''), 120) }}</p>
                                    </div>
                                </div>
                            </div>
                            @if(!$loop->last)
                            <hr class="my-4">
                            @endif
                            @endforeach

                            @if($posts->isEmpty())
                            <div class="text-center">
                                <p>No news posts available at the moment.</p>
                                <a href="/user/register" class="btn btn-primary">Create an Account to Stay Updated</a>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-4 col-12 mx-auto">
                            <form class="custom-form search-form" action="#" method="get" role="form">
                                <input name="search" type="search" class="form-control" id="search" placeholder="Search" aria-label="Search">

                                <button type="submit" class="form-control">
                                    <i class="bi-search"></i>
                                </button>
                            </form>

                            <h5 class="mt-5 mb-3">Recent news</h5>

                            @foreach($recentPosts as $recentPost)
                            <div class="news-block news-block-two-col d-flex mt-4">
                                <div class="news-block-two-col-image-wrap">
                                    <a href="{{ route('news.detail', $recentPost->slug) }}">
                                        <img src="{{ asset('storage/' . ($recentPost->data_values->image ?? 'images/default.png')) }}" class="news-image img-fluid" alt="{{ $recentPost->data_values->title ?? 'Blog Post' }}">
                                    </a>
                                </div>

                                <div class="news-block-two-col-info">
                                    <div class="news-block-title mb-2">
                                        <h6><a href="{{ route('news.detail', $recentPost->slug) }}" class="news-block-title-link">{{ $recentPost->data_values->title ?? 'Untitled Post' }}</a></h6>
                                    </div>

                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ $recentPost->created_at->format('F j, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="category-block d-flex flex-column">
                                <h5 class="mb-3">Categories</h5>

                                <a href="" class="category-block-link">
                                    Investment
                                    <span class="badge">{{ $posts ? $posts->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Referral System
                                    <span class="badge">{{ $posts ? $posts->where('data_values->category', 'referral')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Monieflex
                                    <span class="badge">{{ $posts ? $posts->where('data_values->category', 'monieflex')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Buy Plans
                                    <span class="badge">{{ $posts ? $posts->where('data_values->category', 'plans')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Performing Tasks
                                    <span class="badge">{{ $posts ? $posts->where('data_values->category', 'tasks')->count() : 0 }}</span>
                                </a>
                            </div>

                            <div class="tags-block">
                                <h5 class="mb-3">Tags</h5>

                                <a href="" class="tags-block-link">
                                    Investment
                                </a>

                                <a href="" class="tags-block-link">
                                    Referral System
                                </a>

                                <a href="" class="tags-block-link">
                                    Monieflex
                                </a>

                                <a href="" class="tags-block-link">
                                    Buy Plans
                                </a>

                                <a href="" class="tags-block-link">
                                    Performing Tasks
                                </a>

                            </div>

                            <form class="custom-form subscribe-form" action="#" method="get" role="form">
                                <h5 class="mb-4">Newsletter Form</h5>

                                <input type="email" name="subscribe-email" id="subscribe-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email Address" required>

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control">Subscribe</button>
                                </div>
                            </form>
                        </div>

                    </row>
                </div>
            </section>


            <section class="testimonial-section section-padding section-bg">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h2 class="mb-lg-3">Happy Customers</h2>
                            
                                <div id="testimonial-carousel" class="carousel carousel-fade slide" data-bs-ride="carousel">

                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                           <div class="carousel-caption">
                                                <h4 class="carousel-title">I was honestly skeptical at first, but MonieFlex surprised me. I earn small but steady cash just by watching ads, and referrals really boost my balance. Withdrawals have been smooth so far.</h4>

                                                <small class="carousel-name"><span class="carousel-name-title">Chinedu</span>, O.</small>
                                           </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="carousel-caption">
                                                <h4 class="carousel-title">I joined with the MonieFlex Light plan and started seeing results within a week. The cashback feature helped me recover part of my subscription cost. It’s simple and easy to use.</h4>

                                                <small class="carousel-name"><span class="carousel-name-title">Amina,</span>Bello</small>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="carousel-caption">
                                                <h4 class="carousel-title">The referral system works well. After inviting a few friends, my earnings increased faster than I expected. It’s a nice side income platform.</h4>

                                                <small class="carousel-name"><span class="carousel-name-title">Kelvin</span>, E.</small>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="carousel-caption">
                                                <h4 class="carousel-title">I upgraded to the Gold plan and the daily advert rewards are better. I like that I can earn even during my free time. Definitely worth trying.</h4>

                                                <small class="carousel-name"><span class="carousel-name-title">BobGrace</span>, Okafor</small>
                                           </div>
                                        </div>

                                          <ol class="carousel-indicators">
                                               <li data-bs-target="#testimonial-carousel" data-bs-slide-to="0" class="active">
                                                    <img src="{{ asset('images/avatar/portrait-beautiful-young-woman-standing-grey-wall.jpg') }}" class="img-fluid rounded-circle avatar-image" alt="avatar">
                                               </li>

                                               <li data-bs-target="#testimonial-carousel" data-bs-slide-to="1" class="">
                                                    <img src="{{ asset('images/avatar/portrait-young-redhead-bearded-male.jpg') }}" class="img-fluid rounded-circle avatar-image" alt="avatar">
                                               </li>

                                               <li data-bs-target="#testimonial-carousel" data-bs-slide-to="2" class="">
                                                    <img src="{{ asset('images/avatar/pretty-blonde-woman-wearing-white-t-shirt.jpg') }}" class="img-fluid rounded-circle avatar-image" alt="avatar">
                                               </li>

                                               <li data-bs-target="#testimonial-carousel" data-bs-slide-to="3" class="">
                                                    <img src="{{ asset('images/avatar/studio-portrait-emotional-happy-funny.jpg') }}" class="img-fluid rounded-circle avatar-image" alt="avatar">
                                               </li>
                                          </ol>

                                 </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-12 ms-auto mb-5 mb-lg-0">
                            <div class="contact-info-wrap">
                                <h2>Get in touch</h2>

                                <div class="contact-image-wrap d-flex flex-wrap">
                                    <img src="{{ asset('images/avatar/pretty-blonde-woman-wearing-white-t-shirt.jpg') }}" class="img-fluid avatar-image" alt="">

                                    <div class="d-flex flex-column justify-content-center ms-3">
                                        <p class="mb-0">Clara Barton</p>
                                        <p class="mb-0"><strong>HR & Office Manager</strong></p>
                                    </div>
                                </div>

                                <div class="contact-info">
                                    <h5 class="mb-3">Contact Infomation</h5>

                                    <p class="d-flex mb-2">
                                        <i class="bi-geo-alt me-2"></i>
                                        Akershusstranda 20, 0150 Oslo, Norway
                                    </p>

                                    <p class="d-flex mb-2">
                                        <i class="bi-telephone me-2"></i>

                                        <a href="tel: 120-240-9600">
                                            120-240-9600
                                        </a>
                                    </p>

                                    <p class="d-flex">
                                        <i class="bi-envelope me-2"></i>

                                        <a href="mailto:info@monieflex.site">
                                            info@monieflex.site
                                        </a>
                                    </p>

                                    <a href="" class="custom-btn btn mt-3">Get Direction</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12 mx-auto">
                            <form class="custom-form contact-form" id="contactForm" method="post" role="form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h2>Contact form</h2>

                                <p class="mb-4">Or, you can just send an email:
                                    <a href="mailto:info@monieflex.site">info@monieflex.site</a>
                                </p>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="first_name" id="first-name" class="form-control" placeholder="Jack" required>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="last_name" id="last-name" class="form-control" placeholder="Doe" required>
                                    </div>
                                </div>

                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Jackdoe@gmail.com" required>

                                <textarea name="message" rows="5" class="form-control" id="message" placeholder="What can we help you?" required></textarea>

                                <button type="submit" class="form-control" id="submitBtn">Send Message</button>
                                
                                <!-- Success/Error Messages -->
                                <div id="formMessage" class="mt-3" style="display: none;"></div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12 mb-4">
                        <img src="{{ asset('images/logo1.png') }}" class="logo img-fluid" alt="">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <h5 class="site-footer-title mb-3">Quick Links</h5>

                        <ul class="footer-menu">
                            <li class="footer-menu-item"><a href="{{ route('home') }}" class="footer-menu-link">Home</a></li>

                            <li class="footer-menu-item"><a href="#section4" class="footer-menu-link">News</a></li>

                            <li class="footer-menu-item"><a href="#section5" class="footer-menu-link">Contact Us</a></li>

                            <li class="footer-menu-item"><a href="/user/login" class="footer-menu-link">Login</a></li>

                            <li class="footer-menu-item"><a href="/user/register" class="footer-menu-link">Sign Up</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mx-auto">
                        <h5 class="site-footer-title mb-3">Contact Infomation</h5>

                        <p class="text-white d-flex mb-2">
                            <i class="bi-telephone me-2"></i>

                            <a href="tel: 120-240-9600" class="site-footer-link">
                                120-240-9600
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <i class="bi-envelope me-2"></i>

                            <a href="mailto:info@monieflex.site" class="site-footer-link">
                                info@monieflex.site
                            </a>
                        </p>

                        <p class="text-white d-flex mt-3">
                            <i class="bi-geo-alt me-2"></i>
                            Akershusstranda 20, 0150 Oslo, Norway
                        </p>

                        <a href="/user/register" class="custom-btn btn mt-3">Get Started Today!</a>
                    </div>
                </div>
            </div>

            <div class="site-footer-bottom">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-7 col-12">
                            <p class="copyright-text mb-0">Copyright © 2026 MonieFlex<a href="/"> monieflex.site</a></p>
                        </div>
                        
                        <div class="col-lg-6 col-md-5 col-12 d-flex justify-content-center align-items-center mx-auto">
                            <ul class="social-icon">
                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-twitter"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-facebook"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-instagram"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-linkedin"></a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="" class="social-icon-link bi-youtube"></a>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.sticky.js') }}"></script>
        <script src="{{ asset('js/click-scroll.js') }}"></script>
        <script src="{{ asset('js/counter.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        
        <!-- AJAX Contact Form Handler -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const formMessage = document.getElementById('formMessage');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = new FormData(form);
                    
                    // Get CSRF token from meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        : document.querySelector('input[name="_token"]').value;
                    
                    // Disable submit button to prevent double submission
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Sending...';
                    
                    // Show loading message
                    formMessage.style.display = 'block';
                    formMessage.className = 'alert alert-info';
                    formMessage.textContent = 'Sending your message...';
                    
                    fetch(window.APP_BASE_URL + "/contact", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Success message
                            formMessage.className = 'alert alert-success';
                            formMessage.textContent = data.message;
                            
                            // Reset form
                            form.reset();
                            
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Send Message';
                            
                            // Scroll to top of form to show success message
                            form.scrollIntoView({ behavior: 'smooth' });
                            
                        } else {
                            // Error message
                            formMessage.className = 'alert alert-danger';
                            formMessage.textContent = data.message || 'Something went wrong. Please try again.';
                            
                            // Re-enable submit button
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Send Message';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Network error message
                        formMessage.className = 'alert alert-danger';
                        formMessage.textContent = 'Network error. Please check your connection and try again.';
                        
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Message';
                    });
                });
            }
        });
        </script>

    </body>
</html>