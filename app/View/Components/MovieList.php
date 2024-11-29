<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MovieList extends Component
{
    public $movies;

    public function __construct($movies)
    {
        $this->movies = $movies;
    }

    public function render()
    {
        return view('components.movie-list');
    }
}
