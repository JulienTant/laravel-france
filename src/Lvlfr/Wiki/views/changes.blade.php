{{ '<?xml version="1.0" encoding="UTF-8" ?>' }}

<rss version="2.0">
<channel>
 <title>Changemements du wiki Laravel.fr</title>
 <description>Changemements du wiki Laravel.fr</description>
 <link>http://wiki.laravel.fr/</link>
 <lastBuildDate>{{ date(DATE_RFC2822) }}</lastBuildDate>
 <pubDate>{{ date(DATE_RFC2822) }}</pubDate>
@foreach($versions as $version)
 <item>
  <title>{{ $version->title }} - version #{{$version->version}} - par {{ $version->user->username }}</title>
  <description>{{{$version->content}}}</description>
  <link>{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $version->page->slug, 'version' => $version->version)) }}</link>
  <guid>{{ URL::action('\Lvlfr\Wiki\Controller\HomeController@index', array('slug' => $version->page->slug, 'version' => $version->version)) }}</guid>
  <pubDate>{{ $version->created_at->format(DATE_RFC2822) }}</pubDate>
 </item>
@endforeach
</channel>
</rss>