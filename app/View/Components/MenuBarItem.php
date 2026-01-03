<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuBarItem extends Component
{
    public $name;
    public $icon;
    public $route;
    public $class;
    public $count;
    public function __construct($name = '',$icon = '',$route,$class = '',$count = '')
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->route = $route;
        $this->class = $class;
        $this->count = $count;
    }

    public function render(): View|Closure|string
    {
        return view('components.menu-bar-item');
    }
}
