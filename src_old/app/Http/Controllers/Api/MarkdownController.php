<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Http\Controllers\Api;


use LaravelFranceOld\Http\Controllers\Controller;

class MarkdownController extends Controller
{
    public function render(\Illuminate\Http\Request $request)
    {
        return ['html' => app('markdown')->text($request->markdown)];
    }
}
