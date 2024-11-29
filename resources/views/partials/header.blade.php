<header class="position-sticky top-0 z-3">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/storage/images/logo/logo.png" class="transparent-bg logo" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="menu collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" id="home-page" aria-current="page" href="/">TRANG CHỦ</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownGenre" role="button" aria-expanded="false">
                            THỂ LOẠI
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownGenre">
                            @foreach($genresList as $genre)
                                <li><a class="dropdown-item" href="{{ route('movies.genre', $genre->slug) }}">{{ $genre->name }}</a></li>                          
                            @endforeach  
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownCountry" role="button" aria-expanded="false">
                            QUỐC GIA
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCountry">
                            @foreach($countries as $country)
                                <li><a class="dropdown-item" href="{{ route('movies.country', $country->slug) }}">{{ $country->name }}</a></li>        
                            @endforeach  
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownReleaseYear" role="button" aria-expanded="false">
                            NĂM SẢN XUẤT
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownReleaseYear">
                            @foreach($release_years as $release_year)
                                <li><a class="dropdown-item" href="{{ route('movies.release_year', $release_year->year) }}">{{ $release_year->year }}</a></li>        
                            @endforeach  
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownCategory" role="button" aria-expanded="false">
                            DANH MỤC
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategory">
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('movies.category', $category->slug) }}">{{ $category->name }}</a></li>        
                            @endforeach  
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownRanking" role="button" aria-expanded="false">
                            XẾP HẠNG
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownRanking">
                            <li><a class="dropdown-item" href="{{ route('movies.topView') }}">Lượt Xem</a></li>   
                            <li><a class="dropdown-item" href="{{ route('movies.topRating') }}">Đánh Giá</a></li>                          
                            <li><a class="dropdown-item" href="{{ route('movies.topComment') }}">Bình Luận</a></li>                                                 
                        </ul>
                    </li>

                    <li>
                        <button class="nav-link text-white" id="theme-toggle"><i class="fa-solid fa-moon"></i></button>
                    </li>
                </ul>

                <div id="search">
                    <form action="{{ route('movies.search') }}" method="GET"> <!-- Giữ form tìm kiếm chính -->
                        <div class="input-group" id="search-bar">
                            <input class="form-control" type="search" name="q" id="search-input" placeholder="Tìm kiếm" aria-label="Search">
                            <button class="input-group-text" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <div id="search-results" class="list-group z-1 position-absolute rounded-1 mt-1"></div> <!-- hiển thị kết quả tìm kiếm -->
                </div>

               <div class="header-login-button">
                    @if (Auth::check())
                        <!-- User Avatar Dropdown -->
                        <div class="dropdown">
                            <button class="btn rounded-circle p-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Str::startsWith(Auth::user()->avatar, 'https://lh3.googleusercontent.com')
                                    || Str::startsWith(Auth::user()->avatar, 'https://graph.facebook.com'))
                                <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-circle object-fit-cover" width="40px" height="40px">
                                @elseif(!isset(Auth::user()->avatar))
                                <img src="/storage/images/avatar/default-avatar.jpg" alt="User Avatar" class="rounded-circle object-fit-cover" width="40px" height="40px">
                                @else
                                <img src="{{ asset('storage/images/avatar/' . Auth::user()->avatar) }}" alt="User Avatar" class="rounded-circle object-fit-cover" width="40px" height="40px">
                                @endif
                            </button>
                            <ul class="dropdown-menu bg-dark dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Thông tin tài khoản</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.service') }}">Gói dịch vụ</a></li>
                                @if(!isset(Auth::user()->password))
                                <li><a class="dropdown-item" href="{{ route('password.set')}}">Đặt mật khẩu</a></li>
                                @else
                                <li><a class="dropdown-item" href="{{ route('password.edit')}}">Đổi mật khẩu</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('movies.watchList') }}">Phim theo dõi</a></li>
                                <li><a class="dropdown-item" href="{{ route('movies.watchHistory') }}">Lịch sử xem phim</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}">ĐĂNG NHẬP</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>