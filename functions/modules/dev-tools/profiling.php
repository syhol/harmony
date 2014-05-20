<?php
/**
 * Profiling
 *
 * Profiling time and memory in dev tools
 * 
 * @package Dev_Tools
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Start a time and memory profile by taking a snapshot
 * 
 * @param  mixed $profile_id
 * @return void
 */
function profile_start($profile_id = null)
{
	if (is_null($profile_id)) $profile_id = str_random();
	set_registry('dev-tools.active-profile', $profile_id);
	set_registry('dev-tools.active-profiles.' . $profile_id, array(
		'memory' => memory_get_usage(true),
		'timestamp' => microtime(true)
	));
}

/**
 * Stop the profile and return the results
 * 
 * @param  mixed $profile_id
 * @return array {array('time-diff' => float, 'memory-diff' => float)}
 */
function profile_stop($profile_id = null)
{
	$stop_time = microtime(true);
	$stop_memory = memory_get_usage(true);
	if (is_null($profile_id)) {
		$profile_id = get_registry('dev-tools.active-profile');
	}
	$start_time = get_registry('dev-tools.active-profiles.' . $profile_id . '.timestamp');
	$start_memory = get_registry('dev-tools.active-profiles.' . $profile_id . '.memory');
	profile_remove($profile_id);
	return array(
		'time-diff' => $stop_time - $start_time,
		'memory-diff' => $stop_memory - $start_memory
	);
}

/**
 * Stop the profile and display the results
 * 
 * @param  mixed $profile_id
 * @return void
 */
function profile_dump($profile_id = null)
{
   var_dump(profile_stop($profile_id));
}

/**
 * Stop the profile display the results and die
 * 
 * @param  mixed $profile_id
 * @return void
 */
function profile_dd($profile_id = null)
{
   dd(profile_stop($profile_id));
}

/**
 * Remove a saved profile
 * 
 * @param  mixed $profile_id
 * @return void
 */
function profile_remove($profile_id)
{
	$profiles = get_registry('dev-tools.active-profiles', array());
	if (isset($profiles[$profile_id])) unset($profiles[$profile_id]);

	//Fix the active profile
	$active = get_registry('dev-tools.active-profile');
	if ( ! isset($profiles[$active]) && count($profiles) > 0) {
		$most_recent = 0;
		foreach ($profiles as $id => $profile) {
			if($most_recent <= $profile['timestamp']) {
				$most_recent = $profile['timestamp'];
				set_registry('dev-tools.active-profile', $id);
			}
		}
	}

	set_registry('dev-tools.active-profiles', $profiles);
}