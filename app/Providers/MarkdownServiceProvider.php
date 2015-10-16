<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelFrance\CommonMark\CommonMarkConverter;


class MarkdownServiceProvider extends ServiceProvider
{

    public function boot()
    {
        \Blade::directive('markdown', function($expression) {
            return "<?php echo app('commonmark')->convertToHtml{$expression} ?>";
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('commonmark', function () {
            return new CommonMarkConverter;
        });
    }

    public function provides()
    {
        return [
            'commonmark'
        ];
    }


}