<?php
namespace AoSiX\BBCode;


class BBCodeParser {

    public function __construct($parser)
    {
        $this->parser = $parser;
        $this->setEmoticons();
    }

    public function setEmoticons()
    {
        $this->parser->add_emoticons(array(
            ":)"            => \URL::asset('js/sceditor/emoticons/smile.png'),
            "=)"            => \URL::asset('js/sceditor/emoticons/smile.png'),
            "=]"            => \URL::asset('js/sceditor/emoticons/smile.png'),
            ":angel:"       => \URL::asset('js/sceditor/emoticons/angel.png'),
            ":angry:"       => \URL::asset('js/sceditor/emoticons/angry.png'),
            "8-)"           => \URL::asset('js/sceditor/emoticons/cool.png'),
            ":'("           => \URL::asset('js/sceditor/emoticons/cwy.png'),
            "='("           => \URL::asset('js/sceditor/emoticons/cwy.png'),
            "='["           => \URL::asset('js/sceditor/emoticons/cwy.png'),
            ":ermm:"        => \URL::asset('js/sceditor/emoticons/ermm.png'),
            ":D"            => \URL::asset('js/sceditor/emoticons/grin.png'),
            "=D"            => \URL::asset('js/sceditor/emoticons/grin.png'),
            "<3"            => \URL::asset('js/sceditor/emoticons/heart.png'),
            ":("            => \URL::asset('js/sceditor/emoticons/sad.png'),
            ":O"            => \URL::asset('js/sceditor/emoticons/shocked.png'),
            ":P"            => \URL::asset('js/sceditor/emoticons/tongue.png'),
            "=("            => \URL::asset('js/sceditor/emoticons/sad.png'),
            "=["            => \URL::asset('js/sceditor/emoticons/sad.png'),
            "=O"            => \URL::asset('js/sceditor/emoticons/shocked.png'),
            "=P"            => \URL::asset('js/sceditor/emoticons/tongue.png'),
            ";)"            => \URL::asset('js/sceditor/emoticons/wink.png'),
            ":alien:"       => \URL::asset('js/sceditor/emoticons/alien.png'),
            ":blink:"       => \URL::asset('js/sceditor/emoticons/blink.png'),
            ":blush:"       => \URL::asset('js/sceditor/emoticons/blush.png'),
            ":cheerful:"    => \URL::asset('js/sceditor/emoticons/cheerful.png'),
            ":devil:"       => \URL::asset('js/sceditor/emoticons/devil.png'),
            ":dizzy:"       => \URL::asset('js/sceditor/emoticons/dizzy.png'),
            ":getlost:"     => \URL::asset('js/sceditor/emoticons/getlost.png'),
            ":happy:"       => \URL::asset('js/sceditor/emoticons/happy.png'),
            ":kissing:"     => \URL::asset('js/sceditor/emoticons/kissing.png'),
            ":ninja:"       => \URL::asset('js/sceditor/emoticons/ninja.png'),
            ":pinch:"       => \URL::asset('js/sceditor/emoticons/pinch.png'),
            ":pouty:"       => \URL::asset('js/sceditor/emoticons/pouty.png'),
            ":sick:"        => \URL::asset('js/sceditor/emoticons/sick.png'),
            ":sideways:"    => \URL::asset('js/sceditor/emoticons/sideways.png'),
            ":silly:"       => \URL::asset('js/sceditor/emoticons/silly.png'),
            ":sleeping:"    => \URL::asset('js/sceditor/emoticons/sleeping.png'),
            ":unsure:"      => \URL::asset('js/sceditor/emoticons/unsure.png'),
            ":woot:"        => \URL::asset('js/sceditor/emoticons/w00t.png'),
            ":wassat:"      => \URL::asset('js/sceditor/emoticons/wassat.png')
        ));
    }

    public function parse($elements, $detectLinks = true, $detectEmails = true, $detectEmoticons = true) {
        $parser = $this->parser->parse($elements);

        if ($detectLinks) {
            $parser->detect_links();
        }
        if ($detectEmails) {
            $parser->detect_emails();
        }
        if ($detectEmoticons) {
            $parser->detect_emoticons();
        }

        return $parser->get_html();
    }
}