<?php

namespace Takshak\Alertt\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Alert extends Component
{
    public $title;
    public $message;
    public $footer;
    public $timeout;
    public $type;

    public $color;
    public $borderColor;

    public function __construct()
    {
        $this->prepareMessage();
        if (!$this->message) {
            return false;
        }
        
        $this->footer = session('alertt-footer');
        if (!$this->footer) {
            $this->footer = now()->format('d-M-Y h:i:s a');
        }
        if (config('alertt') && config('alertt.footer.status') == false) {
            $this->footer = null;
        }
        
        if (session('alertt-type')) {
            $this->type = session('alertt-type');
        }
        if (session('type')) {
            $this->type = session('type');
        }
        
        $this->setTitle();
        $this->setColor();
        $this->setTimeout();
    }

    public function prepareMessage()
    {
        if (session('alertt-message')) {
            $this->message = session('alertt-message');
            return true;
        }

        if (request()->session()->get('errors')) {
            $this->message .= '<ul>';
            foreach(request()->session()->get('errors')->all() as $error){
                $this->message .= '<li>'.$error.'</li>';
            }
            $this->message .= '</ul>';
            $this->type = 'danger';
            return true;
        }

        if (session('success')) {
            $this->message  = session('success');
            $this->type     = 'success';
            return false;
        }
        if (session('info')) {
            $this->message  = session('info');
            $this->type     = 'info';
            return false;
        }
        if (session('warning')) {
            $this->message  = session('warning');
            $this->type     = 'warning';
            return false;
        }
        if (session('danger')) {
            $this->message  = session('danger');
            $this->type     = 'danger';
            return false;
        }
        if (session('primary')) {
            $this->message  = session('primary');
            $this->type     = 'primary';
            return false;
        }
        if (session('dark')) {
            $this->message  = session('dark');
            $this->type     = 'dark';
            return false;
        }
    }

    public function setTitle()
    {
        if(session('alertt-title')){
            $this->title = session('alertt-title');
            return true;
        }

        if(session('title')){
            $this->title = session('title');
            return true;
        }

        if (config('alertt.'.$this->type.'.title')) {
            $this->title = config('alertt.'.$this->type.'.title');
            return true;
        }

        if ($this->type == 'success') {
            $this->title = 'Operation is successfully done';

        }elseif($this->type == 'danger'){
            $this->title = 'New Alert message';

        }elseif($this->type == 'warning'){
            $this->title = 'Here is a warning message';

        }else{
            $this->title = 'New Information Received';
        }
    }

    public function setColor()
    {
        if (config('alertt.'.$this->type.'.color')) {
            $this->color = config('alertt.'.$this->type.'.color');
            $this->borderColor = $this->color;
            return true;
        }

        if ($this->type == 'success'){
            $this->color = 'green';

        }elseif ($this->type == 'info'){
            $this->color = 'purple';

        }elseif ($this->type == 'primary'){
            $this->color = 'blue';
            
        }elseif ($this->type == 'danger'){
            $this->color = 'red';
            
        }elseif ($this->type == 'dark'){
            $this->color = '#444';
            
        }elseif ($this->type == 'warning'){
            $this->color = 'yellowgreen';
            
        }else{
            $this->color = '#444';
            
        }

        $this->borderColor = $this->color;
    }

    public function setTimeout()
    {
        if (session('alertt-timeout')) {
            $this->timeout = session('alertt-timeout');
            return false;
        }

        if (session('timeout')) {
            $this->timeout = session('timeout');
            return false;
        }

        if (config('alertt.timeout')) {
            $this->timeout = config('alertt.timeout');
            return false;
        }

        $this->timeout = 6000;
    }


    public function render()
    {
        if (!$this->message) {
            return false;
        }
        
        return View::first(['components.alertt', 'alertt::components.alertt']);
    }
}
