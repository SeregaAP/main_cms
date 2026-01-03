<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Btn_link extends Component
{
    
    public $href;
    public $class;
    public $text;
    public $icon;
    public $directions;
    public function __construct(
        $href = '#',
        $class = '',
        $text = '',
        $icon = '',
        $directions = 'right')
    {
        $this->href = $href;
        $this->class = $class;
        $this->text = $text;
        $this->icon = $icon;
        $this->directions = $directions;
    }
    public function render(): View|Closure|string
    {
        return view('components.btn_link');
    }
}
