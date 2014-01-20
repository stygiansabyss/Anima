<?php namespace Library\Facades;

use Illuminate\Support\Facades\Facade;

class ParseChat extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'parsechat'; }

}