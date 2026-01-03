<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Btn extends Component
{
    public $type;
    public $class;
    public $text;
    public $id;
    public $disabled;
    public $icon;
    public function __construct($type,$class = '',$text = '',$id = '',$disabled = false,$icon = '')
    {
        $this->type = $type;
        $this->class = $class;
        $this->text = $text;
        $this->id = $id;
        $this->disabled = $disabled;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.btn');
    }
}
