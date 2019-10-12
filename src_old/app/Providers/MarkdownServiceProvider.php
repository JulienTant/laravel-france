<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Providers;


use Illuminate\Support\ServiceProvider;
use LaravelFranceOld\CommonMark\CommonMarkConverter;
use LaravelFranceOld\Markdown\Parsedown;


class MarkdownServiceProvider extends ServiceProvider
{

    public function boot()
    {
        \Blade::directive('markdown', function($expression) {
            return "<?php echo app('markdown')->text{$expression} ?>";
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('markdown', function () {
            $parsedown = new Parsedown();
            $parsedown->setBreaksEnabled(true);
            return $parsedown;
        });
    }

    public function provides()
    {
        return [
            'markdown'
        ];
    }


}
