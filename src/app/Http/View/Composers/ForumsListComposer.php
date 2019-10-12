<?php
namespace LaravelFrance\Http\View\Composers;

use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\View\View;
use LaravelFrance\ForumsCategory;
use LaravelFrance\ForumsWatch;

class ForumsListComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->getCategories($view);

        if ($user = Auth::user()) {
            $view->with('nbUnreadWatchers', ForumsWatch::active()->whereUserId($user->id)->whereIsUpToDate(false)->count());
        }
    }

    /**
     * @param View $view
     */
    private function getCategories(View $view)
    {
        /** @var Repository $cache */
        $categories = Cache::remember('forums_categories', Carbon::now()->addDay(1), function () {
            return ForumsCategory::orderBy('order', 'asc')->get();
        });

        $view->with('categories', $categories);
    }
}
