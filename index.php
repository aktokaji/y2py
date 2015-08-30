  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js" type="text/javascript"></script> <!-- https://cdnjs.com/libraries/jquery.lazyload -->

<?php
//指定のURLから取得
$json = file_get_contents('test.temp.json');
//JSONファイルは配列に変換しておく
$arr = json_decode($json,true);

for($i=0; $i<count($arr['d']); $i++)
{
  $v=$arr['d'][$i];
  ?>
  <a target="_blank" href="http://www.youtube.com/embed/<?= $v['video_id'] ?>?autoplay=1&rel=0">
    <!-- <img class="lazy" data-original="https://i.ytimg.com/vi/<?= $v['video_id'] ?>/default.jpg" width="120" height="90" style="vertical-align: middle;" /> -->
    <img src='https://i.ytimg.com/vi/<?= $v['video_id'] ?>/default.jpg' width='120' height='90' style="vertical-align: middle;" />
    <?= $v['pos'] ?>. <?= $v['title'] ?> <br />
  </a>
  <?php
}


//var_dumpで表示して確認(ここは不要)
echo "<pre>";
var_dump(count($arr['d']));
//var_dump($arr['d'][1]);
for($i=0; $i<count($arr['d']); $i++)
{
  var_dump($arr['d'][$i]);
}
//var_dump($arr);
echo "</pre>";
?>




<script type="text/javascript">
<!--
// $(function() { $("img.lazy").lazyload(); });
-->
</script>
