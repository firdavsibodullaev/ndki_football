<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FancyBox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $url,
        public string $gallery,
        public ?string $alt = null,
        public string $css = '',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.fancy-box');
    }
}
