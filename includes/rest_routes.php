<?php

function favourite_button_rest_add_post($request){
}

add_action('rest_api_init', function () {
  register_rest_route( 'mytwentyseventeentheme/v1', 'latest-posts/(?P<category_id>\d+)',array(
                'methods'  => 'POST',
                'callback' => 'get_latest_posts_by_category',
                'validate_callback' => function($param, $request, $key) {
                    return is_user_logged_in();
                }
      ));
});
