<?
##############################################################################
# Functions
##############################################################################

function post_time($index) {
  global $interval, $latest_time;
  $time = $latest_time - ($index-1) * $interval;
  return $time - $time % $interval;
}

function time_string($index) {
  $post_time = post_time($index);
  #$rounded = $post_time - $post_time % 10;
  return date("H:i:s",$rounded) . " on " . date("jS", $rounded) . " of " . date("M", $rounded) . ", " . date("Y", $rounded);
}

function guid($index, $episode_guid_path_left_padding) {
  //return base64_encode(post_time($index));
  $episode_guid_path_prefix = str_repeat('x', $episode_guid_path_left_padding);
  $era = (post_time($index) < 0) ? "pre" : ""; # otherwise, time -10 will equate to +10
  return $episode_guid_path_prefix . $era . toBase(post_time($index));
}

function sample($array) {
  $index = Random::num(0, count($array)-1);
  return $array[$index];
  #return $index;
}

function title($index, $titles) {
  if (count($titles) == 1 && $titles[0]=='empty') {
    return '';
  } if (count($titles) > 0) {
    return $titles[($index-1) % count($titles)];
  } else {
    return ucfirst(phrase($index, true));
  }
}

function phrase($index) {
  global $adjectives, $animals, $countries;
  Random::seed(post_time($index));
  #mt_srand(post_time($index));
  #Random::seed(post_time($index));
  return sprintf("%s %s in %s", sample($adjectives), sample($animals), sample($countries));
}

function mp3($media_scheme_prefix, $episode_url_path_left_padding, $title) {
  $query = preg_replace('/\s+/', '+', $title);
  $episode_url_path_prefix = str_repeat('x', $episode_url_path_left_padding);
  return $media_scheme_prefix . "//" . $episode_url_path_prefix . "tts-api.com/tts.mp3?q=" . $query;
}

function image($index) {
  return 'http://player.fm/assets/logos/playerwide-lightx40.png'; // hard-coded for now
}

# we can give an episode_image param like "episode_image=fire$index.png" to replace with the index
function episode_image_tag($episode_image, $index) {
  if ($episode_image) {
    $url = preg_replace('/\$index/', $index, $episode_image);
    return "<itunes:image href='$url' />\n";
  } else {
    return '';
  }
}

function keywords($index) {
  return "wow,much,cake,many,crum,yum"; #hardcoded
}

// http://css-tricks.com/snippets/php/get-current-page-url/
function self_url() {
  $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
  $url .= ( $_SERVER["SERVER_PORT"] !== "80" ) ? ":".$_SERVER["SERVER_PORT"] : "";
  $url .= $_SERVER["REQUEST_URI"];
  return urlencode($url);
}

function pubDate($index) {
  return date('D, d M Y H:i:s O', post_time($index));
}

?>
