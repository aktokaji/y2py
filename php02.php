  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

<pre>
<?php
// http://becodes.com/%E3%82%B3%E3%83%BC%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0/php%E3%81%A7youtube-data-api-v3%E3%82%92%E4%BD%BF%E3%81%A3%E3%81%A6%E5%86%8D%E7%94%9F%E3%83%AA%E3%82%B9%E3%83%88%E3%82%92%E5%8F%96%E5%BE%97%E3%81%99%E3%82%8B/
// https://github.com/google/google-api-php-client
// http://localhost/phpmyadmin/index.php
// https://console.developers.google.com
// array_chunk http://php.plus-server.net/function.array-chunk.html

// ①ライブラリの読み込み
require_once 'google-api-php-client-master/src/Google/autoload.php';

require_once 'myconst.php';

require_once "Log.php";
$firebug = &Log::singleton('firebug', '', 'PHP LOG');

$conf = array('mode' => 0777, 'timeFormat' => '%x %X');
$file = &Log::factory('file', '@out.log', 'PHP LOG', $conf); 

/*
// ②Youtube Data Api(v3)のインスタンスを作成
$client = new Google_Client();
$client->setDeveloperKey(YOUTUBE_API_KEY);
$youtube = new Google_Service_YouTube($client);

// ③リクエストを送信
$playListItems = $youtube->playlistItems->listPlaylistItems('snippet,contentDetails', array(
 'playlistId' => FAVORITE_PL_AKTOKAJI, //"PLRuN81nQL86aauZjIn_wclBhi1lfEFmC4",
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

$file->log($videos);
$firebug->log($videos);
var_dump($videos);
*/

// https://developers.google.com/api-client-library/php/guide/pagination
// http://stackoverflow.com/questions/20727560/retrieve-all-playlist-entry-youtube-api-v3-using-pagetoken




?>
</pre>

<?php
function youtube_search($query, $max_results, $next_page_token=''){

        $client = new Google_Client();
        $client->setDeveloperKey(YOUTUBE_API_KEY);
        $youtube = new Google_Service_YouTube($client);

        $params = array(
            'playlistId'=>$query,
            'maxResults'=>$max_results,
        );

            // if next_page_token exist add 'pageToken' to $params
        if(!empty($next_page_token)){
            $params['pageToken'] = $next_page_token;
        }

            // than first loop
        $searchResponse = $youtube->playlistItems->listPlaylistItems('id,snippet,contentDetails', $params);
        $videoPos = 0;
        foreach ($searchResponse['items'] as $searchResult) {
        $videoPos = $searchResult['snippet']['position'] + 1;
        $videoId = $searchResult['snippet']['resourceId']['videoId'];
        $videoTitle = $searchResult['snippet']['title'];
        $videoThumb = $searchResult['snippet']['thumbnails']['high']['url'];
        $videoDesc = $searchResult['snippet']['description'];
        //$watchUrl = 'http://www.youtube.com/embed/' . $videoId .'?autoplay=1&rel=0">';
        $watchUrl = 'http://www.youtube.com/watch?v=' . $videoId;
        print '<div id="video' . $videoPos . '"><a target="_blank" href="' . $watchUrl . '">'.
                    $videoPos . '. ' . $videoTitle.'<br/><br/><img src="'.
                    $videoThumb.'" /><br/>'.
                    $videoId.'<br/>'.
                    '<pre>'.$videoDesc.'</pre><br/>'.
                    '</a></div><br/><br/>'; //.
                    //'<script>$("html,body").animate({scrollTop:$("#video'.$videoPos.'").offset().top});</script>';
        ob_flush();
        flush();
        }
        if($videoPos != 0) {
            echo '<script>$("html,body").animate({scrollTop:$("#video'.$videoPos.'").offset().top});</script>';
            ob_flush();
            flush();
        }

          // checking if nextPageToken exist than return our function and 
          // insert $next_page_token with value inside nextPageToken
        if(isset($searchResponse['nextPageToken'])){
              // return to our function and loop again
            return youtube_search($query, $max_results, $searchResponse['nextPageToken']);
        }
    }
?>

<?php
youtube_search(FAVORITE_PL_AKTOKAJI, 50);
?>