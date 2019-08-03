<?php
##############################################################################
# Initial content
##############################################################################

header("Content-Type: application/rss+xml");
echo <<<END
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" media="screen"
  href="/~d/styles/rss2enclosuresfull.xsl"?><?xml-stylesheet type="text/css"
  media="screen"
  href="feed.css"?>
END;
?>

<?php
##############################################################################
# Channel (main feed data)
##############################################################################
?>

<rss xmlns:media="http://search.yahoo.com/mrss/"
  xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
  version="2.0">

  <channel>

<?php if ($include_feed_title ) { ?>
    <title><?= $feed_title ?></title>
<?php } ?>
<?php if ($itunes_new_feed_url ) { ?>
    <itunes:new-feed-url><?= $itunes_new_feed_url ?></itunes:new-feed-url>
<?php } ?>
    <link>http://player.fm/home</link>
    <description>It's been said this is the most sublime feed any human has ever beared witness to. Who am I to argue?</description>
    <language>en-us</language>
    <lastBuildDate><?= pubDate(0) ?></lastBuildDate>
    <pubDate><?= pubDate(0) ?></pubDate>
    <ttl>600</ttl>
    <atom10:link xmlns:atom10="http://www.w3.org/2005/Atom" rel="self" type="application/rss+xml" href="<?= self_url() ?>" />
    <media:copyright>(c) Nuvomondo Ltd</media:copyright>
<?php if ($feed_media_image) { ?>
    <media:thumbnail url="<?= $feed_media_image ?>" />
<?php } ?>
    <media:keywords><?= keywords(-1) ?></media:keywords>
    <media:category scheme="http://www.itunes.com/dtds/podcast-1.0.dtd">Society &amp; Culture</media:category>
<?php if ($feed_img) { ?>
    <img src="<?= image(-1) ?>">
<?php } ?>
<?php if ($feed_image) { ?>
    <image>
      <url><?= image(-1) ?></url>
    </image>
<?php } ?>
<?php if ($itunes ) { ?>
    <spotify:countryOfOrigin><?= $country_of_origin ?></spotify:countryOfOrigin>
    <itunes:author>Stephen J. Dubner and Sooty the Teddy Bear</itunes:author>
    <itunes:explicit>no</itunes:explicit>
    <itunes:image href="<?= $itunes_image ?>" />
    <itunes:keywords>comedy, drama, tokyo, politics</itunes:keywords>
    <itunes:subtitle>Really quite an astonishing contribution to humanity and the finer arts</itunes:subtitle>
    <itunes:type>episodic</itunes:type>
    <itunes:category text="Society &amp; Culture" />
<?php } ?>

    <?php for ($index = 1; $index <= $post_amount; $index++) { ?>
<?php
##############################################################################
# Item
##############################################################################
?>

      <!-- Item <?= $index ?> -->

      <item>
        <title><?= $title_prefix ?><?= $title = title($index, $titles) ?></title>
        <link><?= $server_prefix ?>/dynamic/<?= guid($index, $episode_guid_path_left_padding) ?></link>
        <description><?= $description_prefix ?>Comparing <?= phrase($index) ?> to <?= phrase($index+1) ?></description>
<?php if ($include_episode_time) { ?>
        <pubDate><?= pubDate($index) ?></pubDate>
<?php } ?>
        <language>en-us</language>
<?php if ($include_guid ) { ?>
        <guid isPermaLink="false"><?= $server_prefix ?>/<?= guid($index, $episode_guid_path_left_padding) ?></guid>
<?php } ?>
        <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">Humphrey B. Bear</dc:creator>
        <media:content url="<?= mp3($media_scheme_prefix, $episode_url_path_left_padding, $title) ?>" type="audio/mpeg" />
        <enclosure url="<?= mp3($media_scheme_prefix, $episode_url_path_left_padding, $title) ?>" type="audio/mpeg" length='3000' />
<?php if ($itunes ) { ?>
        <itunes:explicit><?= $explicit_string ?></itunes:explicit>
        <itunes:subtitle>My reflections</itunes:subtitle>
        <itunes:author>Humphrey B. Bear</itunes:author>
        <itunes:summary>About <?= $title ?></itunes:summary>
        <itunes:keywords><?= keywords($index) ?></itunes:keywords>
        <?= episode_image_tag($episode_image, $index) ?>
<?php } ?>
      </item>
    <?php } ?>

    <copyright>(c) Nuvomondo Ltd</copyright>
    <media:credit role="author">Humphrey B. Bear</media:credit>
    <media:rating>nonadult</media:rating>

  </channel>
</rss>
