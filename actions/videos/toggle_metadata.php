<?php

        elgg_gatekeeper();

        $guid = (int) get_input("guid");
        $metadata = get_input("metadata");

	$video = get_entity($guid);

        if(!empty($guid) && !empty($metadata)){
                if(($entity = get_entity($guid)) && $entity->canEdit()){
                        if($entity->getSubtype === "videos"){
			   if(elgg_is_admin_logged_in()){
                                $old = $entity->$metadata;

                                if(empty($entity->$metadata)){
                                        $entity->$metadata = true;
                                } else {
                                        unset($entity->$metadata);
                                }

                                if($old != $entity->$metadata){
                                        elgg_ok_response('', elgg_echo("videos:action:toggle_metadata:success"));
                                } else {
                                        elgg_error_response(elgg_echo("videos:action:toggle_metadata:error"));
                                }
                        } else {
                                elgg_error_response(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "Videos")));
                        }
                } else {
                        //elgg_error_response(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
                        elgg_error_response(elgg_echo("professional:onlyowncontent", array($guid)));
                }
        } else {
                elgg_error_response(elgg_echo("InvalidParameterException:MissingParameter"));
        }
}
        return elgg_redirect_response(REFERER);

