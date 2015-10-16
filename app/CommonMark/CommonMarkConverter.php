<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\CommonMark;

use LaravelFrance\CommonMark\Renderer\HighlightedCode;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;


/**
 * Converts CommonMark-compatible Markdown to HTML.
 */
class CommonMarkConverter extends Converter
{
    /**
     * Create a new commonmark converter instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->mergeConfig($config);

        $highlightedCodeRenderer = new HighlightedCode();
        $environment->addBlockRenderer('FencedCode', $highlightedCodeRenderer);
        $environment->addBlockRenderer('IndentedCode', $highlightedCodeRenderer);

        parent::__construct(new DocParser($environment), new HtmlRenderer($environment));
    }
}
