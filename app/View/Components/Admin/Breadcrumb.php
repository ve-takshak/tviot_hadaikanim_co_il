<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;
    public $links;
    public $actions;
    public $back;
    public function __construct($title='', $links=[], $actions=[],$back=[])
    {
        $this->title = $title;
        $this->links = $links;
        $this->actions = $actions;
        $this->back = $back;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.breadcrumb');
    }
}
