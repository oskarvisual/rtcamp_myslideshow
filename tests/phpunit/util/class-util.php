<?php
/**
 * MySlideshow plugin tests
 *
 * @category  Util
 * @package   Unitest
 */

/** A class Util to WordPress PHP Units. */
class Util {

	/** A function that checks if a value is in an array.
	 *
	 * @param string $value value name.
	 * @param array  $array array.
	 *
	 * @return bool if has value or not.
	 */
	public static function has_value( $value, $array ) {
		$has_value = false;

		$callback = function ( $v, $k ) use ( $value, &$has_value ) {
			if ( $value === $v ) {
				$has_value = true;
			}
		};

		array_walk_recursive( $array, $callback );
		return $has_value;
	}

	/** Checking if an array has an object of a certain type.
	 *
	 * @param string $type type name.
	 * @param array  $array array.
	 *
	 * @return bool if has object or not.
	 */
	public static function has_obj( $type, $array ) {
		$has_obj  = false;
		$callback = function ( $v, $k ) use ( $type, &$has_obj ) {

			if ( is_object( $v ) ) {
				if ( get_class( $v ) === $type ) {
					$has_obj = true;
				}
			}
		};
		array_walk_recursive( $array, $callback );
		return $has_obj;
	}

	/**
	 *  Wrapper for wp has_action() - for easy coding
	 *
	 * @param string $action action name.
	 * @param object $obj object.
	 * @param string $function function name.
	 *
	 * @return bool if has action or not.
	 */
	public static function has_action( $action, $obj, $function ) {
		$registered = has_action(
			$action,
			array(
				$obj,
				$function,
			)
		);

		return ( $registered ) ? true : false;
	}

	/** Wrapper for wp has_filter()
	 *
	 * @param string $filter filter name.
	 * @param object $obj object.
	 * @param string $function function name.
	 *
	 * @return bool if has filter or not.
	 */
	public static function has_filter( $filter, $obj, $function ) {
		$registered = has_filter(
			$filter,
			array(
				$obj,
				$function,
			)
		);

		return ( $registered ) ? true : false;
	}

	/**  Use this function to get action when function object hash is not known
	 *
	 * @param string $action action name.
	 *
	 * @return array wp_filter.
	 */
	public static function get_action( $action ) {
		global $wp_filter;

		return ( isset( $wp_filter[ $action ] ) ) ? $wp_filter[ $action ] : null;
	}

	/** Setting the user capabilities
	 *
	 * @param string $cap to add cap.
	 * @param bool   $enable boolean to add or remove cap.
	 */
	public static function set_cap( $cap, $enable ) {
		global $current_user;

		self::set_admin_role( false );

		if ( $enable ) {
			$current_user->add_cap( $cap );
			$current_user->get_role_caps();
		} else {
			$current_user->remove_cap( $cap );
			$current_user->get_role_caps();
		}
	}

	/** Setting the user capabilities
	 *
	 * @param bool $enable to enable plugin.
	 */
	public static function set_activate_plugins_cap( $enable ) {
		self::set_cap( 'activate_plugins', $enable );

		if ( is_multisite() ) {
			self::set_cap( 'manage_network_plugins', $enable );
		}
	}

	/** Set admin role
	 *
	 * @param bool $enable bool to enable role.
	 */
	public static function set_admin_role( $enable ) {
		global $current_user;
		if ( $enable ) {
			$current_user->add_role( 'administrator' );
			$current_user->get_role_caps();
		} else {
			$current_user->remove_role( 'administrator' );
			$current_user->get_role_caps();
		}
	}
}
