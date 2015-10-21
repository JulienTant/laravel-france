<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\Http\Controllers\Api;


use LaravelFrance\Http\Controllers\Controller;

class MarkdownController extends Controller
{
    public function render(\Illuminate\Http\Request $request)
    {
        return ['html' => app('markdown')->text($request->markdown)];
    }
}