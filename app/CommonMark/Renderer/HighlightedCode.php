<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFrance\CommonMark\Renderer;


use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class HighlightedCode implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        if (!($block instanceof FencedCode) && !($block instanceof IndentedCode)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $attrs = [];
        if($block instanceof FencedCode) {
            $infoWords = $block->getInfoWords();
            if (count($infoWords) !== 0 && strlen($infoWords[0]) !== 0) {
                $attrs['language'] = $htmlRenderer->escape($infoWords[0], true);
            }
        }

        return new HtmlElement(
            'highlighted-code',
            $attrs,
            $htmlRenderer->escape($block->getStringContent())
        );
    }
}
