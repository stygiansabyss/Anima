<?php namespace Library;

use Illuminate\Support\ServiceProvider;

class ParseChatServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerParseChat();
	}

	/**
	 * Register the Post instance.
	 *
	 * @return void
	 */
	protected function registerParseChat()
	{
		$this->app->bindShared('parsechat', function($app)
		{
			return new ParseChat();
		});
	}
}