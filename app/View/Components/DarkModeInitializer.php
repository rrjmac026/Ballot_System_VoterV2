<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DarkModeInitializer extends Component
{
    public function __construct()
    {
    }

    public function render()
    {
        return view('components.dark-mode-initializer');
    }
}
