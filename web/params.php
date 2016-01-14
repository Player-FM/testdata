<?
$interval = get('interval', ['default'=>10]);
$latest_time = get('time', ['default'=>time()]); # time of latest post
$title_prefix = get('title_prefix', ['right_padding_if_present' => ' ']);
$titles = get('titles');
$feed_image = get('feed_image'); // e.g. http://www.unity.fm/rssfeeds/ACourseInMiracles
$feed_img = get('feed_img'); // e.g. http://feeds.feedburner.com/takeawaymoviedate
$description_prefix = get('description_prefix', ['right_padding_if_present' => ' ']);
$explicit = filter_var(get('explicit', ['default' => 'false']), FILTER_VALIDATE_BOOLEAN);
$itunes = filter_var(get('itunes', ['default' => 'true']), FILTER_VALIDATE_BOOLEAN);
$include_episode_time = filter_var(get('include_episode_time', ['default' => 'true']), FILTER_VALIDATE_BOOLEAN);
?>
