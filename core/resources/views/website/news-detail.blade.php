<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>MonieFlex News Detail</title>

        <!-- CSS FILES -->        
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

        <link href="{{ asset('css/templatemo-kind-heart-charity.css') }}" rel="stylesheet">

    </head>
    
    <body>

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

                            <a href="mailto:info@monieflex.com">
                                info@monieflex.com
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
                            <a class="nav-link click-scroll" href="{{ route('home') }}#top">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="{{ route('home') }}#section_2">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="{{ route('home') }}#section_3">Plans</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll active" href="{{ route('home') }}#section_4">News</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="{{ route('home') }}#section_5">Contact</a>
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

            <section class="news-detail-header-section text-center">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <h1 class="text-white">{{ $post->data_values->title ?? 'Blog Post' }}</h1>
                        </div>

                    </div>
                </div>
            </section>

            <section class="news-section section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7 col-12">
                            <div class="news-block">
                                <div class="news-block-top">
                                    <img src="{{ asset('storage/' . ($post->data_values->image ?? 'images/default.png')) }}" class="news-image img-fluid" alt="{{ $post->data_values->title ?? 'Blog Post' }}">

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
                                        <h4>{{ $post->data_values->title ?? 'Untitled Post' }}</h4>
                                    </div>

                                    <div class="news-block-body" style="word-wrap: break-word; overflow-wrap: break-word;">
                                        {!! $post->data_values->description ?? 'No description available.' !!}
                                    </div>

                                    <div class="social-share border-top mt-5 py-4 d-flex flex-wrap align-items-center">
                                        <div class="tags-block me-auto">
                                            <a href="" class="tags-block-link">
                                                Investment
                                            </a>

                                            <a href="" class="tags-block-link">
                                                News
                                            </a>

                                            <a href="" class="tags-block-link">
                                                Monieflex
                                            </a>
                                        </div>

                                        <div class="d-flex">
                                            <a href="" class="social-icon-link bi-facebook"></a>

                                            <a href="" class="social-icon-link bi-twitter"></a>

                                            <a href="" class="social-icon-link bi-printer"></a>

                                            <a href="" class="social-icon-link bi-envelope"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12 mx-auto mt-4 mt-lg-0">
                            <form class="custom-form search-form" action="#" method="post" role="form">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search">

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
                                    <span class="badge">{{ $recentPosts ? $recentPosts->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Referral System
                                    <span class="badge">{{ $recentPosts ? $recentPosts->where('data_values->category', 'referral')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Monieflex
                                    <span class="badge">{{ $recentPosts ? $recentPosts->where('data_values->category', 'monieflex')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Buy Plans
                                    <span class="badge">{{ $recentPosts ? $recentPosts->where('data_values->category', 'plans')->count() : 0 }}</span>
                                </a>

                                <a href="" class="category-block-link">
                                    Performing Tasks
                                    <span class="badge">{{ $recentPosts ? $recentPosts->where('data_values->category', 'tasks')->count() : 0 }}</span>
                                </a>
                            </div>

                            <div class="tags-block">
                                <h5 class="mb-3">Tags</h5>

                                <a href="" class="tags-block-link">
                                    Investment
                                </a>

                                <a href="" class="tags-block-link">
                                    News
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

                            <form class="custom-form subscribe-form" action="#" method="post" role="form">
                                <h5 class="mb-4">Newsletter Form</h5>

                                <input type="email" name="subscribe-email" id="subscribe-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email Address" required>

                                <div class="col-lg-12 col-12">
                                    <button type="submit" class="form-control">Subscribe</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>

            <section class="news-section section-padding section-bg">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 mb-4">
                            <h2>Related news</h2>
                        </div>

                            @foreach($relatedPosts as $relatedPost)
                        <div class="col-lg-6 col-12">
                            <div class="news-block">
                                <div class="news-block-top">
                                    <a href="{{ route('news.detail', $relatedPost->slug) }}">
                                        <img src="{{ asset('storage/' . ($relatedPost->data_values->image ?? 'images/default.png')) }}" class="news-image img-fluid" alt="{{ $relatedPost->data_values->title ?? 'Blog Post' }}">
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
                                                {{ $relatedPost->created_at->format('F j, Y') }}
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
                                                {{ $relatedPost->comments ? $relatedPost->comments->count() : 0 }} Comments
                                            </p>
                                        </div>
                                    </div>

                                    <div class="news-block-title mb-2">
                                        <h4><a href="{{ route('news.detail', $relatedPost->slug) }}" class="news-block-title-link">{{ $relatedPost->data_values->title ?? 'Untitled Post' }}</a></h4>
                                    </div>

                                    <div class="news-block-body" style="word-wrap: break-word; overflow-wrap: break-word;">
                                        <p>{{ Str::limit(strip_tags($relatedPost->data_values->description ?? ''), 150) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-12 mb-4">
                        <img src="{{ asset('images/logo.png') }}" class="logo img-fluid" alt="">
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <h5 class="site-footer-title mb-3">Quick Links</h5>

                        <ul class="footer-menu">
                            <li class="footer-menu-item"><a href="{{ route('home') }}" class="footer-menu-link">Our Story</a></li>

                            <li class="footer-menu-item"><a href="{{ route('home') }}#section_4" class="footer-menu-link">Newsroom</a></li>

                            <li class="footer-menu-item"><a href="{{ route('home') }}#section_3" class="footer-menu-link">Causes</a></li>

                            <li class="footer-menu-item"><a href="/user/register" class="footer-menu-link">Become a volunteer</a></li>

                            <li class="footer-menu-item"><a href="/user/register" class="footer-menu-link">Partner with us</a></li>
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

                        <a href="/user/register" class="custom-btn btn mt-3">Get Direction</a>
                    </div>
                </div>
            </div>

            <div class="site-footer-bottom">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-7 col-12">
                            <p class="copyright-text mb-0">Copyright © 2036 <a href="">Monieflex.site</a> MonieFlex
                        	Design: <a href="">Monieflex.site</a></p>
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
                                    <a href="https://youtube.com/templatemo" class="social-icon-link bi-youtube"></a>
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

    </body>
</html>