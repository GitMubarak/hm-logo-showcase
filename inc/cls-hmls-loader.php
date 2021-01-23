<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * General action, hooks loader
*/
class HMLS_Loader {

	protected $hmls_actions;
	protected $hmls_filters;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->hmls_actions = array();
		$this->hmls_filters = array();
	}

	function add_action( $hook, $component, $callback ){
		$this->hmls_actions = $this->add( $this->hmls_actions, $hook, $component, $callback );
	}

	function add_filter( $hook, $component, $callback ){
		$this->hmls_filters = $this->add( $this->hmls_filters, $hook, $component, $callback );
	}

	private function add( $hooks, $hook, $component, $callback ){
		$hooks[] = array( 'hook' => $hook, 'component' => $component, 'callback' => $callback );
		return $hooks;
	}

	public function hmls_run(){
		foreach( $this->hmls_filters as $hook ){
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach( $this->hmls_actions as $hook ){
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
?>