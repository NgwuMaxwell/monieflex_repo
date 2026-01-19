@include($activeTemplate . 'partials.headers')

<style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; text-shadow: rgba(0,0,0,.01) 0 0 1px; }
    .page { width: 100%; height: auto; background: #fff; background-size: 100% 100%; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 44px; background: #3244a8; font-size: 16px; line-height: 44px; font-weight: 600; color: #fff; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { font-size: 20px; position: absolute; left: 10px; top: 0; color: #fff; text-decoration: none; }
    
    .container { width: 100%; max-width: 991px; padding: 0px 15px 120px; }
    
    .news-block { width: 100%; height: 100px; background-color: #f1f1fe; border-radius: 7px; padding: 0 10px; margin-top: 15px; display: flex; flex-direction: row; align-items: center; justify-content: start; flex-wrap: wrap; cursor: pointer; }
    .news-block .left-img { width: 100px; height: 100px; border-radius: 7px; overflow: hidden; margin-right: 10px; }
    .news-block .right { width: calc(100% - 110px); }
    .news-block .right p { font-size: 14px; font-weight: 700; color: #151515; line-height: 19px; margin-bottom: 2px; }
    .news-block .right h6 { font-size: 12px; font-weight: 400; line-height: 16px; color: #9e9aa8; margin-bottom: 2px; }
</style>

</head>

<body>
    <div class="header">
        <a href="{{ route('user.home') }}" class="left-arrow"><i class="bi bi-arrow-left"></i></a>
        News & Blog
    </div>
    <div class="page">
        <div class="container">
            
            @forelse($blogs as $blog)
                <div class="news-block" onclick="window.location.href='{{ route('user.blog.detail', $blog->id) }}'">
                    <div class="left-img"><img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image) }}" class="w-100 h-100"></div>
                    <div class="right">
                        <p>{{ __($blog->data_values->title) }}</p>
                        <h6>{{ strLimit(strip_tags($blog->data_values->description),80) }}</h6>
                        <h6 class="mb-0">Post by admin | {{ $blog->created_at->format('M d, Y') }}</h6>
                    </div>
                </div>
            @empty
                <div class="text-center mt-5">
                    <p>No blog posts available at the moment.</p>
                </div>
            @endforelse

            @if($blogs->hasPages())
                <div class="mt-4">
                    {{ paginateLinks($blogs) }}
                </div>
            @endif

        </div>
    </div>

@include($activeTemplate . 'partials.footers')
