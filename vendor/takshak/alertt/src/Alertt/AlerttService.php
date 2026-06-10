<?php

namespace Takshak\Alertt\Alertt;

use Illuminate\Session\Store;

class AlerttService
{
	public $request;
	public $header;
	public $message;
	public $footer;
	public $timeout;
	public $type;

	protected Store $session;

	public function __construct(Store $session)
	{
		$this->session = $session;
	}

	public function init()
	{
		return new Alertt;
	}

	public function title($title)
	{
		$this->session->flash('alertt-title', $title);
		return $this;
	}

	public function message($message)
	{
		$this->setMessage($message);
		return $this;
	}

	public function info($message)
	{
		$this->setMessage($message);
		$this->setType('info');
		return $this;
	}

	public function success($message)
	{
		$this->setMessage($message);
		$this->setType('success');
		return $this;
	}

	public function primary($message)
	{
		$this->setMessage($message);
		$this->setType('primary');
		return $this;
	}

	public function danger($message)
	{
		$this->setMessage($message);
		$this->setType('danger');
		return $this;
	}

	public function dark($message)
	{
		$this->setMessage($message);
		$this->setType('dark');
		return $this;
	}

	public function warning($message)
	{
		$this->setMessage($message);
		$this->setType('warning');
		return $this;
	}

	public function footer($footer)
	{
		$this->session->flash('alertt-footer', $footer);
		return $this;
	}

	public function timeout($time=6000)
	{
		$this->session->flash('alertt-timeout', $time);
		return $this;
	}

	public function setMessage($message)
	{
		$this->session->flash('alertt-message', $message);
		return $this;
	}

	public function setType($type)
	{
		$this->session->flash('alertt-type', $type);
		return $this;
	}

}