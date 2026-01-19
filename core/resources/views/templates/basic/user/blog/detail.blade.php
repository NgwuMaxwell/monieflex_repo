@include($activeTemplate . 'partials.headers')

<style>
    @import  url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
    html, body { width: 100%; max-width: 991px; margin: 0 auto; height: 100%; background: #fff; font-family: 'Roboto', sans-serif; font-size: 15px; font-weight: 400; color: rgba(0,0,0,.9); }
    .page { width: 100%; height: auto; background: #fff; padding-top: 50px; position: relative; }
    .header { width: 100%; max-width: 991px; height: 44px; background: #3244a8; font-size: 16px; line-height: 44px; font-weight: 600; color: #fff; text-align: center; position: fixed; transform: translateX(-50%); left: 50%; top: 0; z-index: 100; }
    .header .left-arrow { font-size: 20px; position: absolute; left: 10px; top: 0; color: #fff; text-decoration: none; }
    
    .container { width: 100%; max-width: 991px; padding: 0px 15px 50px; }
    
    .blog-image { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 20px; }
    .blog-title { font-size: 20px; font-weight: 700; color: #151515; margin-bottom: 10px; }
    .blog-meta { font-size: 12px; color: #9e9aa8; margin-bottom: 20px; }
    .blog-content { font-size: 14px; line-height: 1.8; color: #333; }
    .blog-content img { max-width: 100%; height: auto; border-radius: 7px; margin: 15px 0; }
    .related-title { font-size: 16px; font-weight: 700; color: #151515; margin: 30px 0 15px; }
    .news-block { width: 100%; height: 100px; background-color: #f1f1fe; border-radius: 7px; padding: 0 10px; margin-top: 15px; display: flex; flex-direction: row; align-items: center; cursor: pointer; }
    .news-block .left-img { width: 100px; height: 100px; border-radius: 7px; overflow: hidden; margin-right: 10px; }
    .news-block .right { width: calc(100% - 110px); }
    .news-block .right p { font-size: 14px; font-weight: 700; color: #151515; line-height: 19px; margin-bottom: 2px; }
    .news-block .right h6 { font-size: 12px; font-weight: 400; line-height: 16px; color: #9e9aa8; margin-bottom: 2px; }
</style>

</head>

<body>
    <div class="header">
        <a href="{{ route('user.blog.index') }}" class="left-arrow"><i class="bi bi-arrow-left"></i></a>
        Blog Details
    </div>
    <div class="page">
        <div class="container">
            
            <img src="{{ getImage('assets/images/frontend/blog/'.$blog->data_values->image) }}" class="blog-image">
            
            <h1 class="blog-title">{{ __($blog->data_values->title) }}</h1>
            
            <div class="blog-meta">
                <i class="bi bi-calendar"></i> {{ $blog->created_at->format('M d, Y') }} | 
                <i class="bi bi-person"></i> Posted by Admin
            </div>
            
            <div class="blog-content">
                {!! $blog->data_values->description !!}
            </div>

            <!-- Comments Section -->
            <div class="comments-section" style="margin-top: 40px;">
                <h2 class="related-title">Comments ({{ $comments->count() }})</h2>
                
                <!-- Comment Form -->
                <form action="{{ route('user.blog.comment') }}" method="POST" style="margin-bottom: 30px;">
                    @csrf
                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                    <textarea name="comment" class="form-control" rows="4" placeholder="Write your comment here..." required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 7px; font-size: 14px; margin-bottom: 10px;"></textarea>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(90deg,#9169f3,#7843f5); color: #fff; border: 0; padding: 10px 30px; border-radius: 25px; font-size: 14px; cursor: pointer;">Post Comment</button>
                </form>

                <!-- Comments List -->
                @forelse($comments as $comment)
                    <div class="comment-item" style="background: #f1f1fe; padding: 15px; border-radius: 7px; margin-bottom: 15px;">
                        <div style="display: flex; align-items: flex-start; gap: 12px;">
                            <!-- Profile Picture or Initial -->
                            <div style="flex-shrink: 0;">
                                @if($comment->user->image)
                                    <img src="{{ getImage(getFilePath('userProfile').'/'.$comment->user->image, getFileSize('userProfile')) }}" alt="User" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; font-weight: 600;">
                                        {{ strtoupper(substr($comment->user->email, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Comment Content -->
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <div>
                                        <div style="color: #3244a8; font-weight: 600; font-size: 14px;">{{ $comment->user->email }}</div>
                                    </div>
                                    <span style="font-size: 11px; color: #9e9aa8;">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.6;">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #9e9aa8; padding: 20px;">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>

            @if($relatedBlogs->count() > 0)
                <h2 class="related-title">Related Articles</h2>
                
                @foreach($relatedBlogs as $relatedBlog)
                    <div class="news-block" onclick="window.location.href='{{ route('user.blog.detail', $relatedBlog->id) }}'">
                        <div class="left-img"><img src="{{ getImage('assets/images/frontend/blog/'.$relatedBlog->data_values->image) }}" class="w-100 h-100"></div>
                        <div class="right">
                            <p>{{ __($relatedBlog->data_values->title) }}</p>
                            <h6>{{ strLimit(strip_tags($relatedBlog->data_values->description),80) }}</h6>
                            <h6 class="mb-0">{{ $relatedBlog->created_at->format('M d, Y') }}</h6>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

@include($activeTemplate . 'partials.footers')
