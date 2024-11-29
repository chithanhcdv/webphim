<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i>Trang Chủ</a></li>
        
        @if(request()->routeIs('movies.show'))
            <li class="breadcrumb-item"><a href="{{ route('movies.category', $movie->category_slug) }}">{{ $movie->category_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('movies.country', $movie->country_slug) }}">{{ $movie->country_name }}</a></li>
            @foreach($genres as $genre)
            <li class="breadcrumb-item"><a href="{{ route('movies.genre', $genre->slug) }}">{{ $genre->name }}</a></li>
            @endforeach
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('movies.show', $movie->slug) }}">{{ $movie->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thông Tin Phim</li>
        @elseif(request()->routeIs('movies.watch'))
            <li class="breadcrumb-item"><a href="{{ route('movies.category', $movie->category_slug) }}">{{ $movie->category_name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('movies.country', $movie->country_slug) }}">{{ $movie->country_name }}</a></li>
            @foreach($genres as $genre)
            <li class="breadcrumb-item"><a href="{{ route('movies.genre', $genre->slug) }}">{{ $genre->name }}</a></li>
            @endforeach
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('movies.show', $movie->slug) }}">{{ $movie->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem Phim</li>
        @elseif(request()->routeIs('movies.genre'))
            <li class="breadcrumb-item">Thể Loại</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $genre->name }}</li>
        @elseif(request()->routeIs('movies.country'))
            <li class="breadcrumb-item">Quốc Gia</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $country->name }}</li>
        @elseif(request()->routeIs('movies.release_year'))
            <li class="breadcrumb-item">Năm Sản Xuất</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $release_year->year }}</li>
        @elseif(request()->routeIs('movies.category'))
            <li class="breadcrumb-item">Danh Mục</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        @elseif(request()->routeIs('movies.newUpdate'))
            <li class="breadcrumb-item active">Phim Mới Cập Nhật</li>
        @elseif(isset($searchTerm))
            <li class="breadcrumb-item active">Tìm Kiếm</li>
            <li class="breadcrumb-item active">{{ $searchTerm }}</li>
        @elseif(request()->routeIs('movies.filter'))
            <li class="breadcrumb-item active">Lọc Phim</li>
        @elseif(request()->routeIs('movies.watchList'))
            <li class="breadcrumb-item active">Phim Theo Dõi</li>
        @elseif(request()->routeIs('movies.watchHistory'))
            <li class="breadcrumb-item active">Lịch Sử Xem Phim</li>
        @elseif(request()->routeIs('movies.recommended'))
            <li class="breadcrumb-item active">Gợi Ý Phim</li>
        @elseif(request()->routeIs('movies.topView'))
            <li class="breadcrumb-item">Bảng Xếp Hạng</li>
            <li class="breadcrumb-item active">Top Lượt Xem</li>
        @elseif(request()->routeIs('movies.topRating'))
            <li class="breadcrumb-item">Bảng Xếp Hạng</li>
            <li class="breadcrumb-item active">Top Đánh Giá</li>
        @elseif(request()->routeIs('movies.topComment'))
            <li class="breadcrumb-item">Bảng Xếp Hạng</li>
            <li class="breadcrumb-item active">Top Bình Luận</li>
        @elseif(request()->routeIs('user.profile'))
            <li class="breadcrumb-item active">Thông Tin Tài Khoản</li>
        @elseif(request()->routeIs('user.profileEdit'))
            <li class="breadcrumb-item"><a href="{{ route('user.profile') }}">Thông Tin Tài Khoản</a></li>
            <li class="breadcrumb-item active">Cập nhật thông tin</li>
        @elseif(request()->routeIs('user.profile'))
            <li class="breadcrumb-item active">Thông Tin Tài Khoản</li>
        @elseif(request()->routeIs('verification.notice'))
            <li class="breadcrumb-item active">Xác Thực Email</li>
        @elseif(request()->routeIs('user.service'))
            <li class="breadcrumb-item active">Gói Dịch Vụ</li>
        @elseif(request()->routeIs('user.payment'))
            <li class="breadcrumb-item"><a href="{{ route('user.service') }}">Gói Dịch Vụ</a></li>
            <li class="breadcrumb-item active">Thanh Toán Dịch Vụ</li>
        @elseif(request()->routeIs('vnpay.return'))
            <li class="breadcrumb-item active">Thanh Toán Gói Dịch Vụ</li>
        @elseif(request()->routeIs('momo.return'))
            <li class="breadcrumb-item active">Thanh Toán Gói Dịch Vụ</li>   
        @elseif(request()->routeIs('password.edit'))
            <li class="breadcrumb-item active">Đổi Mật Khẩu</li>
        @elseif(request()->routeIs('password.set'))
            <li class="breadcrumb-item active">Đặt Mật Khẩu</li>
        @elseif(request()->routeIs('login'))
            <li class="breadcrumb-item active">Đăng Nhập</li>
        @elseif(request()->routeIs('register'))
            <li class="breadcrumb-item active">Đăng Ký</li> 
        @elseif(request()->routeIs('password.request'))
            <li class="breadcrumb-item active">Quên Mật Khẩu</li> 
        @elseif(request()->routeIs('password.reset'))
            <li class="breadcrumb-item active">Đặt Lại Mật Khẩu</li> 
        @elseif(request()->routeIs('news.newUpdate'))
            <li class="breadcrumb-item active">Tin phim</li> 
        @elseif(request()->routeIs('news.show'))
            <li class="breadcrumb-item"><a href="{{ route('news.newUpdate') }}">Tin phim</a></li> 
            <li class="breadcrumb-item active">{{ $news->title }}</li> 
        @endif
    </ol>
</nav>
