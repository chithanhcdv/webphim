<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My Application')</title>
    <link rel="shortcut icon" href="{{ asset('storage/images/logo/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/light-mode.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- emoji -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
</head>
<body>

    @include('partials.header') 

    <main>
        <div class="container mt-3 main">
            @if (!Request::is('/')) 
                @include('partials.breadcrumb')
            @endif
            <div class="row">
                @if (Request::is('/'))
                <div class="col-lg-12 col-md-12 col-12 mb-4">
                    <x-swiper-new-update :swiperMovies="$swiperMovies" />
                </div>             
                @endif
                @if(View::hasSection('show_aside')) 
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                    <div class="col-md-4">
                        @include('partials.aside')
                    </div>
                @else
                    <div class="col">
                        @yield('content')
                    </div> 
                @endif
            </div>
        </div>
    </main>

    @include('partials.footer') 

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- emoji -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.js"></script>

    <script>
        var botmanWidget = {
            title: "Bot",
            aboutText: "ChatBot hỗ trợ",
            introMessage: "{{ Auth::check() ? 'Xin chào ' . Auth::user()->name . ', bạn cần giúp gì' : 'Xin chào, bạn cần giúp gì' }}"
        };
    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>
        $(document).ready(function() {
            // Sự kiện khi gõ phím trong ô tìm kiếm
            $('#search-input').on('keyup', function() {
                var query = $(this).val();

                if (query.length > 1) { // Bắt đầu tìm kiếm khi người dùng nhập trên 2 ký tự
                    var searchInputWidth = $('#search-input').outerWidth(); // Lấy chiều rộng của thanh tìm kiếm
                    $('#search-results').css('width', searchInputWidth + 'px'); // Đặt chiều rộng của kết quả tìm kiếm

                    $.ajax({
                        url: "{{ route('movies.searchAjax') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            $('#search-results').empty(); // Xóa kết quả cũ

                            if (data.length > 0) {
                                $.each(data, function(index, movie) {
                                    $('#search-results').append(
                                        '<a href="/phim/' + movie.slug + '" class="list-group-item list-group-item-action d-flex">' +
                                            '<img src="/storage/images/movies/' + movie.image + '" style="width: 50px;" class="me-2">' + 
                                            '<p>' + movie.name + '</p>'+
                                        '</a>'
                                    );
                                }); 
                            } else {
                                $('#search-results').append('<p class="list-group-item">Không tìm thấy kết quả.</p>');
                            }
                        }
                    });
                } else {
                    $('#search-results').empty(); // Xóa kết quả nếu người dùng xóa từ khóa
                }
            });

            // Sự kiện khi nhấp ra ngoài ô tìm kiếm và kết quả
            $(document).on('click', function(event) {
                // Kiểm tra nếu click ra ngoài vùng tìm kiếm và kết quả
                if (!$(event.target).closest('#search-input, #search-results').length) {
                    $('#search-results').empty(); // Ẩn kết quả tìm kiếm
                }
            });

            // Sự kiện khi mất tiêu điểm (blur) ô tìm kiếm
            $('#search-input').on('blur', function() {
                setTimeout(function() {
                    $('#search-results').empty(); // Ẩn kết quả tìm kiếm sau khi mất tiêu điểm
                }, 200); // Đặt độ trễ để người dùng có thể nhấn vào kết quả tìm kiếm trước khi bị xóa
            });
        });
    </script>
</body>
</html>


