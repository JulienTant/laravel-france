<?php
/**
 * laravelfr
 *
 * @author Julien Tant - Craftyx <julien@craftyx.fr>
 */

namespace LaravelFranceOld\Markdown;

use DOMDocument;
use Parsedown as OriginalParsedown;

class Parsedown extends OriginalParsedown
{
    #
    # Code

    protected function blockCode($Line, $Block = null)
    {
        if (isset($Block) and ! isset($Block['type']) and ! isset($Block['interrupted']))
        {
            return;
        }

        if ($Line['indent'] >= 4)
        {
            $text = substr($Line['body'], 4);

            $Block = array(
                'element' => array(
                    'name' => 'highlighted-code',
                    'handler' => 'line',
                    'text' => $text,
                ),
            );

            return $Block;
        }
    }

    protected function blockCodeContinue($Line, $Block)
    {
        if ($Line['indent'] >= 4)
        {
            if (isset($Block['interrupted']))
            {
                $Block['element']['text'] .= "\n";

                unset($Block['interrupted']);
            }

            $Block['element']['text'] .= "\n";

            $text = substr($Line['body'], 4);

            $Block['element']['text'] .= $text;

            return $Block;
        }
    }

    protected function blockCodeComplete($Block)
    {
        $text = $Block['element']['text'];

        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');

        $Block['element']['text'] = $text;

        return $Block;
    }

    #
    # Fenced Code

    protected function blockFencedCode($Line)
    {
        if (preg_match('/^['.$Line['text'][0].']{3,}[ ]*([\w-]+)?[ ]*$/', $Line['text'], $matches))
        {
            $Element = array(
                'name' => 'highlighted-code',
                'handler' => 'line',
                'text' => '',
            );

            if (isset($matches[1]))
            {
                $Element['attributes'] = array(
                    'language' => $matches[1],
                );
            }

            $Block = array(
                'char' => $Line['text'][0],
                'element' => $Element
            );

            return $Block;
        }
    }

    protected function blockFencedCodeContinue($Line, $Block)
    {
        if (isset($Block['complete']))
        {
            return;
        }

        if (isset($Block['interrupted']))
        {
            $Block['element']['text'] .= "\n";

            unset($Block['interrupted']);
        }

        if (preg_match('/^'.$Block['char'].'{3,}[ ]*$/', $Line['text']))
        {
            $Block['element']['text'] = substr($Block['element']['text'], 1);

            $Block['complete'] = true;

            return $Block;
        }

        $Block['element']['text'] .= "\n".$Line['body'];;

        return $Block;
    }

    protected function blockFencedCodeComplete($Block)
    {
        $text = $Block['element']['text'];

        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');

        $Block['element']['text'] = $text;

        return $Block;
    }

    function text($text)
    {
        $messageHtml = parent::text($text);

        return $this->closeUnclosedHtmlTags($messageHtml);
    }

    /**
     * @param $messageHtml
     * @return string
     */
    private function closeUnclosedHtmlTags($messageHtml)
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument(null, 'UTF-8');
        $messageHtml = mb_convert_encoding($messageHtml, 'HTML-ENTITIES', "UTF-8");
        $doc->loadHTML($messageHtml, LIBXML_NOWARNING);
        $messageHtml = $doc->saveHTML();
        libxml_use_internal_errors(false);

        return $messageHtml;
    }


}
