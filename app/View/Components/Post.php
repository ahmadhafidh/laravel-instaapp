<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Post extends Component
{
    public $post;
    public $isDetailed;

    public function __construct($post, $isDetailed)
    {
        $this->post = $post;
        $this->isDetailed = $isDetailed;
    }

    public function render(): View|Closure|string
    {
        return view('components.post');
    }
}
