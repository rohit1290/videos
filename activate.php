<?php

if(elgg_get_plugin_setting('video_width_river', 'videos') == null){
  elgg_set_plugin_setting('video_width_river', '70', 'videos');
}
if(elgg_get_plugin_setting('video_width_summary', 'videos') == null){
  elgg_set_plugin_setting('video_width_summary', '130', 'videos');
}
if(elgg_get_plugin_setting('video_width_full', 'videos') == null){
  elgg_set_plugin_setting('video_width_full', '450', 'videos');
}
if(elgg_get_plugin_setting('video_width_full_mob', 'videos') == null){
  elgg_set_plugin_setting('video_width_full_mob', '280', 'videos');
}

 