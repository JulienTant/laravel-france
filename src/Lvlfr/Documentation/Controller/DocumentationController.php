<?php

namespace Lvlfr\Documentation\Controller;

use \Config;
use \File;
use \DOMDocument;
use \View;
use Str;
use Redirect;
use App;


class DocumentationController extends \BaseController
{
    public function showDocs($version = null, $document = null)
    {
        if ($version === null) {
            $version = Config::get('LvlfrDocumentation::docs.defaultVersion');
            return Redirect::action('\Lvlfr\Documentation\Controller\DocumentationController@showDocs', [$version]);
        }

        if (Str::startsWith($version, ['v'])) {
            return Redirect::action(
                '\Lvlfr\Documentation\Controller\DocumentationController@showDocs',
                [str_replace('v', '', $version)],
                301
            );
        }


        $versionConfig = Config::get('LvlfrDocumentation::docs.versions');
        if (!array_key_exists((string)$version, $versionConfig)) {
            App::abort(404);
        }

        $versionConfig = Config::get('LvlfrDocumentation::docs.versions')[(string)$version];

        if ($document === null) {
            $document = $versionConfig['default'];
        }

        $data = array(
            'document' => $document,
            'menu' => $versionConfig['menu']
        );

        try {
            array_walk(
                $data,
                function (&$raw) use ($versionConfig) {
                    $path = base_path() . Config::get(
                            'LvlfrDocumentation::docs.path',
                            '/docs'
                        ) . '/' . $versionConfig['path'];
                    $raw = File::get($path . "/{$raw}.md");
                    $raw = markdownThis($raw);
                }
            );

        } catch (Exception $e) {
            App::abort(404);

        }

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($data['menu'], 'HTML-ENTITIES', "UTF-8"));

        $data['version'] = $version;
        $data['prev'] = false;
        $data['next'] = false;
        $foundCurrent = false;
        $data['title'] = '';

        $domLinks = $dom->getElementsByTagName('a');
        foreach ($domLinks as $domLink) {

            $link['URI'] = $domLink->getAttribute('href');
            $link['title'] = $domLink->nodeValue;

            if ($foundCurrent) {
                $data['next'] = $link;
                break;
            } else {
                $foundCurrent = (str_replace('/' . $version . '/', '', $link['URI']) == $document);

                if (!$foundCurrent) {
                    $data['prev'] = (!$link['title']) ? null : $link;
                } else {
                    $data['title'] = $link['title'];
                }
            }
        }

        return View::make('LvlfrDocumentation::docs', $data);
    }
}
