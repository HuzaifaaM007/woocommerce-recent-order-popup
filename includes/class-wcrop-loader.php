<?php

if (!defined('ABSPATH')) {
    exit;
}

class WCROP_Loader
{

    protected $actions = array();
    protected $filters = array();

    public function add_actions($hook, $component, $callback, $priority = 10, $accepted_args = 1): void
    {
        error_log('WCROP_Loader : add_actions method');

        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    public function add_filters($hook, $component, $callback, $priority = 10, $accepted_args = 1): void
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args): array
    {

        error_log('WCROP_Loader : add method');
        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );
        return $hooks;
    }

    public function run(): void
    {
        error_log('WCROP_Loader : run method');

        foreach ($this->actions as $hook) {
            add_action(
                $hook['hook'],
                array($hook['component'], $hook['callback']),
                $hook['priority'],
                $hook['accepted_args']
            );
        }

        foreach ($this->filters as $hook) {
            add_filter(
                $hook['hook'],
                array($hook['component'], $hook['callback']),
                $hook['priority'],
                $hook['accepted_args']
            );
        }
    }
}
