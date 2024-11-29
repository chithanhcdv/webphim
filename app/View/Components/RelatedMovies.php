<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RelatedMovies extends Component
{
    public $relatedMovies;

    public function __construct($relatedMovies)
    {
        $this->relatedMovies = $relatedMovies;
    }

    public function render()
    {
        return view('components.related-movies');
    }
}
