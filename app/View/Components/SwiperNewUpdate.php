<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SwiperNewUpdate extends Component
{
    public $swiperMovies;

    public function __construct($swiperMovies)
    {
        $this->swiperMovies = $swiperMovies;
    }

    public function render()
    {
        return view('components.swiper-new-update');
    }
}
