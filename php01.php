<?php header("Content-Type: text/plain; charset=utf-8"); ?>

<pre>
<?php
// http://becodes.com/%E3%82%B3%E3%83%BC%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0/php%E3%81%A7youtube-data-api-v3%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%A6%E5%86%8D%E7%94%9F%E3%83%AA%E3%82%B9%E3%83%88%E3%82%92%E5%8F%96%E5%BE%97%E3%81%99%E3%82%8B/
// https://github.com/google/google-api-php-client
// ①ライブラリの読み込み
//require_once 'google-api-php-client-master/src/Google/Client.php';
//require_once 'google-api-php-client-master/src/Google/Service/YouTube.php';
require_once 'google-api-php-client-master/src/Google/autoload.php';

require_once "Log.php";
$firebug = &Log::singleton('firebug', '', 'PHP LOG');


// ②Youtube Data Api(v3)のインスタンスを作成
$API_KEY = "AIzaSyBXLSLtMVJ8KOGPmDr29NIVrV1neCVxx-w";
$client = new Google_Client();
$client->setDeveloperKey($API_KEY);
$youtube = new Google_Service_YouTube($client);

// ③リクエストを送信
$playListItems = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails', array(
 'playlistId' => "FLjOQQ9Fp_WC_2e6o0MLZXKg", //"PLRuN81nQL86aauZjIn_wclBhi1lfEFmC4",
 'maxResults' => 50
));
 
// ④データを取得
$videos = array();
foreach($playListItems['items'] as $item){
 $video["video_id"] =$item["contentDetails"]["videoId"];
 $video["title"] = $item["snippet"]->title; 
 $video["published"] = date('Y-m-d H:i:s',strtotime($item["snippet"]->publishedAt));
 $video["thumbnail_url"] = $item["snippet"]["thumbnails"]["default"]["url"];
 $video["description"] =$item["snippet"]["description"];
 $videos[] = $video;

}

$firebug->log($videos);
var_dump($videos);

?>
</pre>