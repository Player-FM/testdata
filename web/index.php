<?

##############################################################################
# Requires
##############################################################################

// generic libs
require_once 'utils.php';
require_once 'random.php';
require_once 'words.php';

// app-specific
require_once 'feed_utils.php';

$server_prefix = 'http://' . $_SERVER['HTTP_HOST'] ;
$interval = get('interval', ['default'=>10]);
$latest_time = get('time', ['default'=>time()]); # time of latest post
$feed_title = get('feed_title', ['default' => 'My Delightful Feed']);
$title_prefix = get('title_prefix', ['right_padding_if_present' => ' ']);
$post_amount = get('post_amount', ['default' => 5]);
$titles = array_filter(explode(",", get('titles')));
$itunes_new_feed_url = get('itunes_new_feed_url');
$feed_image = get('feed_image'); // e.g. http://www.unity.fm/rssfeeds/ACourseInMiracles
$feed_img = get('feed_img'); // e.g. http://feeds.feedburner.com/takeawaymoviedate
$episode_guid_path_left_padding = get('episode_guid_path_left_padding', ['default' => 0]);
$episode_url_path_left_padding  = get('episode_url_path_left_padding', ['default' => 0]);
$feed_media_image = get('feed_media_image');
$itunes_image = get('itunes_image', ['default' => $server_prefix . '/media/dog.jpg']);
$media_scheme_prefix = get('media_scheme', ['default' => 'http']);
$include_feed_title = get_boolean('include_feed_title', true);
$include_guid = get_boolean('include_guid', true);
if ($media_scheme_prefix!=null) {
  $media_scheme_prefix = $media_scheme_prefix . ':';
}
$episode_image  = get('episode_image');

$description_prefix = get('description_prefix', ['right_padding_if_present' => ' ']);
$explicit = get_boolean('explicit', false);
$itunes = get_boolean('itunes', true);
$include_episode_time = filter_var(get('include_episode_time', ['default' => 'true']), FILTER_VALIDATE_BOOLEAN);

$explicit_string = $explicit ? 'yes' : 'no';
$latest_time = floor($latest_time/$interval) * $interval;
date_default_timezone_set('UTC');

include 'feed.php'
?>
