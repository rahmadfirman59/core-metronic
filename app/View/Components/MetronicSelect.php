<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetronicSelect extends Component
{
    public $name, $caption, $placeholder, $value, $options, $viewtype, $required, $class;
    public function __construct($name = '', $caption = '', $placeholder = '', $value = '', $options = [], $required = '', $viewtype = 1, $class = '')
    {
        $this->name = $name;
        $this->caption = $caption;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->options = $options;
        $this->viewtype = $viewtype;
        $this->required = $required;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.metronic-select');
    }
}
