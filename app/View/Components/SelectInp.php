<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectInp extends Component
{
    public $name;
    public $type;
    public $label;
    public $elements;
    public $placeholder;
    public $default;
    public function __construct($name = '',$type = '',$label = '',$elements = null,$placeholder = '',$default = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label;
        $this->elements = $elements;
        $this->placeholder = $placeholder;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-inp');
    }
}
