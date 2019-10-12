<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Http\ViewComposers\Forums;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\View\View;
use LaravelFranceOld\ForumsCategory;
use LaravelFranceOld\ForumsWatch;

class Sidebar
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Guard $auth, Repository $cache)
    {
        $this->auth = $auth;
        $this->cache = $cache;
    }


    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->getCategories($view);

        if ($user = $this->auth->user()) {
            $view->with('nbUnreadWatchers', ForumsWatch::active()->whereUserId($user->id)->whereIsUpToDate(false)->count());
        }

    }

    /**
     * @param View $view
     */
    private function getCategories(View $view)
    {
        /** @var Repository $cache */
        $categories = $this->cache->remember('forums_categories', Carbon::now()->addDay(1), function () {
            return ForumsCategory::orderBy('order', 'asc')->get();
        });
        $view->with('categories', $categories);
    }
}
