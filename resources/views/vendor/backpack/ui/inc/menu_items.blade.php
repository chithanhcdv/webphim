{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Thành Viên" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Phim" icon="la la-film" :link="backpack_url('movie')" />
<x-backpack::menu-item title="Thể Loại" icon="la la-tags" :link="backpack_url('genre')" />
<x-backpack::menu-item title="Quốc Gia" icon="la la-globe" :link="backpack_url('country')" />
<x-backpack::menu-item title="Năm Sản Xuất" icon="la la-calendar" :link="backpack_url('release-year')" />
<x-backpack::menu-item title="Danh Mục" icon="la la-list" :link="backpack_url('category')" />
<x-backpack::menu-item title="Tập Phim" icon="la la-video" :link="backpack_url('episode')" />
<x-backpack::menu-item title="Trailer Phim" icon="la la-play" :link="backpack_url('trailer')" />
<x-backpack::menu-item title="Tin Tức" icon="la la-newspaper" :link="backpack_url('news')" />
<x-backpack::menu-item title="Gói dịch vụ" icon="la la-gift" :link="backpack_url('service')" />
<x-backpack::menu-item title="Đơn dịch vụ" icon="la la-file" :link="backpack_url('service-order')" />
<x-backpack::menu-item title="Bình luận phim" icon="la la-comment" :link="backpack_url('comment')" />
<x-backpack::menu-item title="Đánh giá phim" icon="la la-star" :link="backpack_url('rating')" />
<x-backpack::menu-item title="Lượt xem phim" icon="la la-eye" :link="backpack_url('view')" />