<?

require_once 'words.php';
require_once 'random.php';

header("Content-Type: application/rss+xml");
echo <<<END
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" media="screen"
  href="/~d/styles/rss2enclosuresfull.xsl"?><?xml-stylesheet type="text/css"
  media="screen"
  href="feed.css"?>
END;

Random::seed(post_time($index));

$interval = (!isset($_GET['interval']) || empty($_GET['interval']) ? 10 : $_GET['interval']);
$latest_time = (!isset($_GET['time']) || empty($_GET['time']) ? time() : $_GET['time']); # time of latest post

function toBase($num) { return base_convert($num, 10, 36); }
function to10( $num) { return base_convert($num, 36, 10); }

function post_time($index) {
  global $interval, $latest_time;
  $time = $latest_time - $index * $interval;
  return $time - $time % $interval;
}

function time_string($index) {
  $post_time = post_time($index);
  #$rounded = $post_time - $post_time % 10;
  return date("H:i:s",$rounded) . " on " . date("jS", $rounded) . " of " . date("M", $rounded) . ", " . date("Y", $rounded);
}

function guid($index) {
  //return base64_encode(post_time($index));
  return toBase(post_time($index));
}

function sample($array) {
  $index = Random::num(0, count($array)-1);
  return $array[$index];
  #return $index;
}

function title($index, $ucfirst="") {
  global $adjectives, $animals, $countries;
  #mt_srand(post_time($index));
  #Random::seed(post_time($index));
  $title = sprintf("%s %s in %s", sample($adjectives), sample($animals), sample($countries));
  return $ucfirst ? ucfirst($title) : $title;
}

function mp3($index) {
  $query = preg_replace('/\s+/', '+', title($index));
  return "http://tts-api.com/tts.mp3?q=" . $query;
}

function image($index) {
  return 'http://player.fm/assets/logos/playerwide-lightx40.png'; // hard-coded for now
}

function keywords($index) {
  return "wow,much,cake,many,crum,yum"; #hardcoded
}

// http://css-tricks.com/snippets/php/get-current-page-url/
function self_url() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] !== "80" ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return $url;
}

function pubDate($index) {
  return date('D, d M Y H:i:s O', post_time($index));
}

?>

<rss xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
  version="2.0">
  <channel>

    <title>My Delightful Feed</title>
    <link><?= self_url() ?></link>
    <description>It's been said this is the most sublime feed any human has ever beared witness to. Who am I to argue?</description>
    <language>en-us</language>
    <lastBuildDate><?= pubDate(0) ?></lastBuildDate>
    <pubDate><?= pubDate(0) ?></pubDate>
    <ttl>600</ttl>
    <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="<?= self_url() ?>" />
    <media:copyright>(c) Nuvomondo Ltd</media:copyright>
    <media:thumbnail url="<?= image(-1) ?>" />
    <media:keywords><?= keywords(-1) ?></media:keywords>
    <media:category scheme="http://www.itunes.com/dtds/podcast-1.0.dtd">Society &amp; Culture</media:category>
    <itunes:author>Stephen J. Dubner and Sooty the Teddy Bear</itunes:author>
    <itunes:explicit>no</itunes:explicit>
    <itunes:image href="<?= image(-1) ?>" />
    <itunes:keywords><?= keywords(-1) ?></itunes:keywords>
    <itunes:subtitle>Really quite an astonishing contribution to humanity and the finer arts</itunes:subtitle>
    <itunes:category text="Society &amp; Culture" />

    <? for ($index = 0; $index < 5; $index++) { ?>
      
      <!-- Item <?= $index ?> <?= $latest_time ?> <?= post_time($index) ?> -->

      <item>
        <title><?= title($index, true) ?></title>
        <link>http://<?= $_SERVER['HTTP_HOST'] ?>/dynamic/<?= guid($index) ?></link>
        <description>My reflections on <?= title($index) ?></description>
        <pubDate><?= pubDate($index) ?></pubDate>
        <language>en-us</language>
        <guid isPermaLink="false">http://<?= $_SERVER['HTTP_HOST'] ?>/<?= guid($index) ?></guid>
        <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">Humphrey B. Bear</dc:creator>
        <media:content url="<?= mp3($index) ?>" type="audio/mpeg" />
        <ttl>600</ttl>
        <itunes:explicit>no</itunes:explicit>
        <itunes:subtitle>My reflections</itunes:subtitle>
        <itunes:author>Humphrey B. Bear</itunes:author>
        <itunes:summary>About <?= title($index) ?></itunes:summary>
        <itunes:keywords><?= keywords($index) ?></itunes:keywords>
        <enclosure url="<?= mp3($index) ?>" type="audio/mpeg" />
      </item>

    <? } ?>

    <copyright>(c) Nuvomondo Ltd</copyright>
    <media:credit role="author">Humphrey B. Bear</media:credit>
    <media:rating>nonadult</media:rating>

  </channel>
</rss>
