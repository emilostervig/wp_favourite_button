<?php

add_action('rest_api_init', function () {
  	register_rest_route( 'wp-favourite-list/v1', 'favourite-post/(?P<post_id>\d+)',
  		array(
	        'methods'  => 'POST',
	        'callback' => 'favourite_button_rest_add_post',
			'args' => array(
				'token' => array(
					'validate_callback' => function($value) {
						return wp_verify_nonce($value, $this->plugin_name);
					},
					'required' => true,
				)
			),
			'permission_callback' => function(){
				return is_user_logged_in();
			}
  		)
	);
});




function favourite_button_rest_add_post($request){
	$postId = $request['post_id'];

	if(is_post_favourite($postId)){
		$action = 'remove';
		$response = delete_favourite_post($postId, get_current_user_id());
	} else{
		$action = 'add';
		$response = do_favourite_post($postId, get_current_user_id());
	}

	$response = new WP_REST_Response(
		array(
			'action' => $action,
			'result' => $response
		),
		200
	);

	return $response;
}
