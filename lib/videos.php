<?php
/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $video A video object.
 * @return array
 */

function videos_get_page_content_featured($guid = NULL) {

                $return = array();
                $options = array(
                                'type' => 'object',
                                'subtype' => 'videos',
                                'full_view' => FALSE,
                                'limit' => 10,
                                'metadata_name_value_pairs' => array(
                                         array(
                                                "name" => "featured",
                                                "value" => true
                                      )
                                ),
                        );

                $list = elgg_list_entities($options);
                $return['filter_context'] = 'Featured';
                $return['content'] = $list;

                $return['title'] = elgg_echo('videos:title:featured');

		elgg_push_breadcrumb($crumbs_title, "Featured");

                elgg_register_title_button();

                return $return;
}


function videos_prepare_form_vars($video = null) {
	// input names => defaults
	$values = array(
		'title' => get_input('title', ''), // videolet support
		'video_url' => get_input('video_url', ''),
		'description' => get_input('desc', ''),
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $video,
	);

	if ($video) {
		foreach (array_keys($values) as $field) {
			if (isset($video->$field)) {
				$values[$field] = $video->$field;
			}
		}
	}

	if (elgg_is_sticky_form('videos')) {
		$sticky_values = elgg_get_sticky_values('videos');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('videos');

	return $values;
}

function detectmobile(){

                $detect = new \Detection\MobileDetect;
                $mobile = $detect->isMobile();
                $tablet = $detect->isTablet();

                if($detect->isAndroidOS()){
                        //elgg_extend_view( 'forms/login'   , 'mobile_app/login' );
                        //elgg_extend_view( 'forms/register', 'mobile_app/login' );
                }

                if(($mobile == true) && ($tablet == false)) {
                return true;
                } else {
                return false;
        }
}
