<div class="comment-page mt-5 rounded-1 p-2">
    <div class="d-flex justify-content-between align-items-center"> 
        <div class="comment-total">
            {{ $commentCount }} bình luận
        </div>
        <div class="d-flex align-items-center">
            <span>Sắp xếp theo</span>
            <select class="form-select form-select-sm ms-2" style="width: auto;" onchange="window.location.href = '?sort=' + this.value">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Mới nhất</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Cũ nhất</option>
            </select>
        </div>
    </div>
    <hr>

    @if (Auth::check())
    <div class="write-comment pt-2 d-flex align-items-start">
        <div>
            @if(Str::startsWith(Auth::user()->avatar, 'https://lh3.googleusercontent.com')
            || Str::startsWith(Auth::user()->avatar, 'https://graph.facebook.com'))
            <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
            @elseif(!isset(Auth::user()->avatar))
            <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
            @else
            <img src="{{ asset('storage/images/avatar/' . Auth::user()->avatar) }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
            @endif
        </div>
        <div class="flex-grow-1 ms-2">
            <form action="{{ route('comment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                <textarea name="content" class="form-control" rows="3" placeholder="Viết bình luận..."></textarea>
                <!-- Thêm hình ảnh để bình luận--> 
                <!--
                <input type="file" class="image-upload ml-2" accept="image/*" style="display:none;">
                <button type="button" class="btn btn-light ml-2 image-btn">
                    🖼️
                </button>
                -->
                <button class="btn btn-primary float-end mt-2" type="submit">Đăng</button> 
            </form>
            <div class="image-preview mt-2"></div>
        </div>
    </div>
    @endif

    <div class="list-comment">
        @foreach ($comments as $comment)
        <div class="d-flex mt-3">
            <div>                   
                @if(Str::startsWith($comment->avatar, 'https://lh3.googleusercontent.com')
                || Str::startsWith($comment->avatar, 'https://graph.facebook.com'))
                <img src="{{ $comment->avatar }}" alt="User Avatar" class=" object-fit-cover" width="50px" height="50px">
                @elseif(!isset($comment->avatar))
                <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class=" object-fit-cover" width="50px" height="50px">
                @else
                <img src="{{ asset('storage/images/avatar/' . $comment->avatar) }}" alt="User Avatar" class=" object-fit-cover" width="50px" height="50px">
                @endif
            </div>
            <div class="ms-2 text-wrap break-word">
                <h4 class="fs-6">{{ $comment->name }}</h4>
                <h5 class="fs-6 mw-100">{{ $comment->content }}</h5>
                <div class="d-flex gap-2">    
                    @if(Auth::check())
                        @if($comment->user_liked)
                            <a href="{{ route('comment.dislike', ['id' => $comment->id]) }}" class="text-primary"><small>Bỏ thích</small></a>
                        @else
                            <a href="{{ route('comment.like', ['id' => $comment->id]) }}" class="text-primary"><small>Thích</small></a>
                        @endif
                        <a href="javascript:void(0);" class="text-primary reply-button" data-comment-id="{{ $comment->id }}"><small>Phản hồi</small></a>  
                    

                        @if(Auth::user()->name === $comment->name)
                            <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="text-primary"><small>Xóa</small></a>
                        @endif
                    @endif

                    @if($comment->like_count)
                        <p><i class="fa-regular fa-sm fa-thumbs-up bg-primary rounded-circle opacity-75 text-white"></i><small>{{ $comment->like_count }}</small></p>
                    @endif                  
                </div>  
            </div>
        </div>

        @if ($comment->replies->isNotEmpty())
        <div class="list-replies">
            @foreach ($comment->replies as $reply)
            <div class="d-flex mt-2">
                <div>
                    @if(Str::startsWith($reply->avatar, 'https://lh3.googleusercontent.com')
                    || Str::startsWith($reply->avatar, 'https://graph.facebook.com'))
                    <img src="{{ $reply->avatar }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @elseif(!isset($reply->avatar))
                    <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @else
                    <img src="{{ asset('storage/images/avatar/' . $reply->avatar) }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @endif
                </div>
                <div class="ms-2 text-wrap break-word">
                    <h4 class="fs-6">{{ $reply->name }}</h4>
                    <h5 class="fs-6 mw-100">{{ $reply->content }}</h5>
                    <div class="d-flex gap-2">    
                    @if(Auth::check())
                        @if($reply->user_liked_reply)
                            <a href="{{ route('reply.dislike', ['id' => $reply->id]) }}" class="text-primary"><small>Bỏ thích</small></a>
                        @else
                            <a href="{{ route('reply.like', ['id' => $reply->id]) }}" class="text-primary"><small>Thích</small></a>
                        @endif
                    

                        @if(Auth::user()->name === $reply->name)
                            <a href="{{ route('reply.delete', ['id' => $reply->id]) }}" class="text-primary"><small>Xóa</small></a>
                        @endif
                    @endif

                    @if($reply->reply_like_count)
                        <p><i class="fa-regular fa-sm fa-thumbs-up bg-primary rounded-circle opacity-75 text-white"></i><small>{{ $reply->reply_like_count }}</small></p>
                    @endif
                </div> 
                </div>
            </div>
            @endforeach
        </div>
        @endif
        
        @if(Auth::check())
        <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
            <div class="write-comment d-flex align-items-start">
                <div>
                    @if(Str::startsWith(Auth::user()->avatar, 'https://lh3.googleusercontent.com')
                    || Str::startsWith(Auth::user()->avatar, 'https://graph.facebook.com'))
                    <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @elseif(!isset(Auth::user()->avatar))
                    <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @else
                    <img src="{{ asset('storage/images/avatar/' . Auth::user()->avatar) }}" alt="User Avatar" class="object-fit-cover" width="50px" height="50px">
                    @endif
                </div>
                <div class="flex-grow-1 ms-2">
                    <form action="{{ route('reply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <textarea name="content" class="form-control" rows="3" placeholder="Viết câu trả lời..."></textarea>
                        <button class="btn btn-primary float-end mt-2" type="submit">Đăng</button> 
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <div class="d-flex justify-content-center mb-3">
        {{ $comments->links('pagination::bootstrap-4') }} 
    </div>
</div>

<script>
    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById('reply-form-' + commentId);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>