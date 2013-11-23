<?php namespace AoSiX\BBCode;

use Illuminate\Support\ServiceProvider;

class BBCodeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('aosix/bbcode');
        require __DIR__ . '/SBBCode/SBBCodeParser.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('bbcodeparser', function() {
            return new BBCodeParser(new \SBBCodeParser\Node_Container_Document());
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('bbcodeparser');
	}

}