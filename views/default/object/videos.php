<?php
/**
 * Elgg video view
 *	Licence : GNU2
 *	Copyright :
 */

$detect = new \Detection\MobileDetect;
$mobile = $detect->isMobile();

$full = elgg_extract('full_view', $vars, FALSE);
$video = elgg_extract('entity', $vars, FALSE);

if (!$video instanceof \ElggObject) {
	return;
}

$owner = $video->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $video->getContainerEntity();
$categories = elgg_view('output/categories', $vars);


$video_url = $video->video_url;
$video_id = $video->youtube_id;

$video_url = str_replace("feature=player_embedded&amp;", "", $video_url);
$video_url = str_replace("feature=player_detailpage&amp;", "", $video_url);

$description = elgg_view('output/longtext', array('value' => $video->description, 'class' => 'pbl'));
$owner_link = elgg_view('output/url', array(
	'href' => "videos/owner/{$owner->username}",
	'text' => $owner->name,
));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $video->tags));
$date = elgg_view_friendly_time($video->time_created);

$comments_count = $video->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $video->getURL() . '#comments',
		'text' => $text,
	));
} else {
	$comments_link = '';
}

$subtitle = "$author_text $categories $comments_link";

if (elgg_is_active_plugin('elggx_fivestar')) {
    $subtitle .= elgg_view('elggx_fivestar/voting', array('entity'=> $vars['entity'], 'min' => true));
}


if ($full && !elgg_in_context('gallery')) {
	$header = elgg_view_title(($video->title ? $video->title : ""));

	$params = array(
		'entity' => $video,
		'title' => false,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	$video_info = elgg_view_image_block($owner_icon, $list_body);

	echo <<<HTML
$header
$video_info
HTML;
?>

<div class="video elgg-content mts">
	<div style="margin-left:10px;">
	<?php
        if($mobile) {
					$full_width_mob = (int)elgg_get_plugin_setting('video_width_full_mob', 'videos');
        	echo videoembed_create_embed_object($video_url, $video->guid, $full_width_mob);
        }else{
					$full_width = (int)elgg_get_plugin_setting('video_width_full', 'videos');
        	echo videoembed_create_embed_object($video_url, $video->guid, $full_width);
        }
	?>
	<br>
	<?php echo '<span itemprop="description">'. $description . '</span>'; ?>
	</div>
</div>
<?php
} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
	<div class="videos-gallery-item">
	<h3>$video->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
	// brief view
	$excerpt = elgg_get_excerpt($video->description == null ? "" : $video->description);
	if ($excerpt) {
		$excerpt = "$excerpt";
	}
	$summary_width = (int)elgg_get_plugin_setting('video_width_summary', 'videos');
	$video_icon = videoembed_create_embed_object($video_url, $video->guid, $summary_width);

	$content = "$excerpt";

	$params = array(
		'entity' => $video,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content,
	);

	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	if ($mobile == true || (elgg_get_context() == 'widgets')){
		$full_width_mob = (int)elgg_get_plugin_setting('video_width_full_mob', 'videos');
		$video_icon = videoembed_create_embed_object($video_url, $video->guid, $full_width_mob);
		echo elgg_view_image_block($video_icon,"");
		echo elgg_view_image_block($list_body,"");
	}else {
		echo elgg_view_image_block($video_icon, $list_body);
	}
}
