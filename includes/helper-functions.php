<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;



/**
 * Get an array of post ids from user favourites
 * @param  integer $userId   The user ID. Will user get_current_user_id if left empty
 * @param  string  $postType filter by post type
 * @return array            Array of Post IDs
 */
function get_user_favourite_list($userId = false, $postType = 'product'){
	$userId = ($userId != false) ? $userId : get_current_user_id();
	global $wpdb;
	$table = $wpdb->prefix . 'favourite_list';
	$pTable = $wpdb->prefix . 'posts';
	if($postType == false){
		$params = $userId;
		$sql = "
			SELECT post_id from $table AS f
			INNER JOIN $wpdb->posts AS p
				ON p.ID = f.post_id
			WHERE f.user_id = %d
		";
	} else{
		$params = array($userId, $postType);
		$sql = "
			SELECT post_id from $table AS f
			INNER JOIN $wpdb->posts AS p
				ON p.ID = f.post_id
			WHERE f.user_id = %d
			AND p.post_type = %s
		";
	}

	$postIds = $wpdb->get_col( $wpdb->prepare($sql, $params) );
	return $postIds;
}

/**
 * Check if a post is in a users favourite list
 * @param  integer  $postId Post ID to check
 * @param  integer $userId User ID to check for
 * @return boolean         True if in list, false if not
 */
function is_post_favourite($postId, $userId = false){
	$userId = ($userId != false) ? $userId : get_current_user_id();
	global $wpdb;
	$table = $wpdb->prefix . 'favourite_list';

	$sql = "
		SELECT COUNT(*) FROM $table
		WHERE post_id = %d
		AND user_id = %d
	";

	$isFavourite = $wpdb->get_var( $wpdb->prepare($sql, $postId, $userId) );
	return $isFavourite != 0;
}

/**
 * Add a post to a user favourite list
 * @param  integer  $postId ID of the post to add
 * @param  integer $userId ID of the user
 * @return boolean          true if added, false if not
 */
function do_favourite_post($postId, $userId = false){
	$userId = ($userId != false) ? $userId : get_current_user_id();
	if(!$userId || is_post_favourite($postId, $userId)){
		return false;
	}
	global $wpdb;
	$table = $wpdb->prefix . 'favourite_list';
	$insert = $wpdb->insert(
		$table,
		array(
			'user_id' => $userId,
			'post_id' => $postId
		),
		array(
			'%d',
			'%d'
		)
	);

	return $insert != false;
}

/**
 * Delete a row with a favourite
 * @param  integer  $postId ID of post
 * @param  integer $userId ID of user
 * @return boolen         true deleted, false if didnt delete any
 */
function delete_favourite_post($postId, $userId = false){
	$userId = ($userId != false) ? $userId : get_current_user_id();
	if(!$userId ){
		return false;
	}
	global $wpdb;
	$table = $wpdb->prefix . 'favourite_list';
	$delete = $wpdb->delete(
		$table,
		array(
			'user_id' => $userId,
			'post_id' => $postId
		),
		array(
			'%d',
			'%d'
		)
	);

	return $delete != false;
}
