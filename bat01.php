<?php
set_time_limit(3600);
date_default_timezone_set('Asia/Tokyo');
?>

<pre>
<?php
    $raw = 'you & I > he & she';
    $esc = htmlspecialchars($raw);
    echo $raw . "\n";
    echo $esc . "\n";
    $something = "ABC\n";
    for ($i = 0;$i <10;$i++){
        $today = date("Y-m-d H:i:s", time());
        //echo $today;
        echo $today . "\n";
        //echo $something;
        flush();
        ob_flush();
     
        usleep(300); //効果をわかりやすくするためのスリープ
    }

?>
</pre>

<?php
require_once "Log.php";
$firebug = &Log::singleton('firebug', '', 'PHP LOG');

$val = array("apple", "orage", "lemon");

$firebug->log($val, PEAR_LOG_WARNING);
$firebug->log($firebug);

    for ($i = 0;$i <1000;$i++){
        $today = date("Y-m-d H:i:s", time());
        $firebug->log('(' . ($i+1) . ') ' . $today);
        ob_flush();
        flush();
        //sleep(3); //効果をわかりやすくするためのスリープ
        sleep(120); //効果をわかりやすくするためのスリープ
    }

$firebug->log('[eof]');

?>
