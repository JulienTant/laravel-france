<?php

namespace Lvlfr\Documentation\Controller;

use \Config;
use \dflydev\markdown\MarkdownParser as Markdown;
use \File;
use \DOMDocument;
use \View;

class DocumentationController extends \BaseController {

    public function showDocs($version = null, $document = null)
    {
        if ($version === null) $version = Config::get('LvlfrDocumentation::docs.defaultVersion');
        $versionConfig = Config::get('LvlfrDocumentation::docs.'.$version);


        if ($document === null) $document = $versionConfig['default'];

        // Build an array of file stubs to load from disk and
        // include the documentation index by default.
        $data = array(
            'document'   => $document,
            'menu'     => $versionConfig['menu']
        );

        // Laravel promotes best practice, please handle Exceptions
        // wisely with appropriate try{}catch{} statements.
        try {

            // We use Markdown Extra for parsing, this library has been
            // included from the package composer.json.
            $markdown = new Markdown();

            // Walk through the data array, loading documentation from
            // the filesystem and converting it to markdown for display
            // on the documentation pages.
            array_walk($data, function(&$raw) use ($markdown, $versionConfig) {
                $path = base_path().Config::get('docs.path', '/docs') . '/' . $versionConfig['path'];
                $raw = File::get($path."/{$raw}.md");
                $raw = $markdown->transformMarkdown($raw);
            });

        }
        catch (Exception $e) {

            // Catch all exceptions and abort the application with the 404
            // status command which will show our 404 page.
            App::abort(404);

        }

        // Parse the index to find out the next and previous pages and add links to them in the footer
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($data['menu'], 'HTML-ENTITIES', "UTF-8"));

        $data['prev'] = false;
        $data['next'] = false;
        $foundCurrent = false;
        $data['title'] = '';

        $domLinks = $dom->getElementsByTagName('a');
        foreach ($domLinks as $domLink) {

            $link['URI'] = $domLink->getAttribute('href');
            $link['title'] = $domLink->nodeValue;

            if($foundCurrent)
            {
                $data['next'] = $link;
                break;
            }
            else
            {
                $foundCurrent = (str_replace('/'.$version.'/', '', $link['URI']) == $document);

                if(!$foundCurrent)
                    $data['prev'] = (!$link['title']) ? null : $link;
                else
                    $data['title'] = $link['title'];
            }
        }

        // Show the documentation template, which extends our master template
        // and provides a documentation index within the sidebar section.
        return View::make('LvlfrDocumentation::docs', $data);
    }

}
