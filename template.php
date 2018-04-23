<?php

function associative_explode($input, $delimiters='&\/', $separators='=') {
	$x = $delimiters;
	$y = $separators;
	//                  ↓key↓    ↓sep↓   ↓value↓
	preg_match_all("/ ([^$x$y]+) [$y]* ([^$x$y]*) /ix", $input, $p);
	$output = (!empty($p[1]) && !empty($p[2]))? array_combine($p[1], $p[2]): array();
	return $output;
}

function ofw_ipmahr_preprocess_node(&$variables) {
	if (!empty($variables['content']['field_overview']) && !empty($variables['content']['field_overview']['#items']['0']['value'])) {
		$overview_keys = array('type', 'tag', 'classes');
		$overview_vals = explode('_', $variables['content']['field_overview']['#items']['0']['value']);
		$overview_vals[2] = ($overview_vals[0] == 'sidebar')? ('alignl dent4'): ('');
		$variables['overview'] = array_combine($overview_keys, $overview_vals);
	}
	else {
		$variables['overview'] = FALSE;
	}
	if (!empty($variables['content']['field_underview']) && !empty($variables['content']['field_underview']['#items']['0']['value'])) {
		$underview_keys = array('type', 'tag', 'classes');
		$underview_vals = explode('_', $variables['content']['field_underview']['#items']['0']['value']);
		$underview_vals[2] = ($underview_vals[0] == 'sidebar')? ('alignr dent4'): ('');
		$variables['underview'] = array_combine($underview_keys, $underview_vals);
	}
	else {
		$variables['underview'] = FALSE;
	}
	
	if (!empty($variables['overview']) || !empty($variables['underview'])) {
		$menuitem = menu_link_get_preferred();
		if ($menuitem['module'] == 'nodesymlinks' && $menuitem['has_children'] == 0) {
			$menuitem_parent = menu_link_load($menuitem['plid']);
			if (strpos($menuitem['href'], $menuitem_parent['href']) === 0) {
				$menuitem = $menuitem_parent;
			}
		}
		$teaser_exceptions = array($menuitem['href'], $menuitem['href'].'/mid/[0-9]+');
		$variables['teaser_list'] = ofw_ipmahr_overview_teaser_list($menuitem, $teaser_exceptions);
	}
	else {
		$variables['teaser_list'] = FALSE;
	}
}

function ofw_ipmahr_date_all_day_label() {
  return '';
}

function ofw_ipmahr_menu_subtree($needle, $haystack = NULL) {
	if ($haystack === NULL) {
		$haystack = menu_tree_all_data('main-menu');
	}
	foreach ($haystack as $element) {
		if (is_array($element) && !empty($element['link']) && $element['link']['mlid'] == $needle) {
			$name = $element['link']['link_title'] . ' ' . $element['link']['mlid'];
			$return = array($name => $element);
			return $return;
		}
		elseif (is_array($element) && !empty($element['below'])) {
			$return = ofw_ipmahr_menu_subtree($needle, $element['below']);
			if ($return !== FALSE && is_array($return)) {
				return $return;
			}
		}
	}
	return FALSE;
}

function ofw_ipmahr_overview_teaser_list($menuitem, $exceptions = array()) {
		$return_array = array();
		$menutree = menu_tree_output(ofw_ipmahr_menu_subtree($menuitem['mlid'], menu_tree_all_data($menuitem['menu_name'])));
		foreach ($menutree[$menuitem['mlid']]['#below'] as $key => $val) {
			$excluded = FALSE;
			foreach ($exceptions as $exception) {
				$excluded = (preg_match('/^'.str_replace('/', '\/', $exception).'$/i', $val['#href']))? (TRUE): ($excluded);
			}
			if (!empty($val['#href']) && !$excluded && $val['#href'] != $menuitem['href']) {
				$val_ids = explode('/', $val['#href']);
				if ($val_ids[0] == 'node') {
					$val_element = node_load($val_ids[1]);
					if ($val_element->nid) {
						$val_teaser = node_view($val_element, 'teaser');
						if ($val_teaser) {
							$val_teaser['body']['#object']->title = $val['#title'];
							$return_array[$key] = $val_teaser;
						}
					}
				}
				elseif ($val_ids[0] == 'taxonomy' && $val_ids[1] == 'term') {
					$val_element = taxonomy_term_load($val_ids[2]);
					if ($val_element->tid) {
						$val_teaser = taxonomy_term_view($val_element, 'teaser');
						if ($val_teaser) {
							$val_teaser['field_body']['#object']->name = $val['#title'];
							$return_array[$key] = $val_teaser;
						}
					}
				}
				elseif ($val['#original_link']['page_callback'] == 'views_page') {
					//$return_array[$key] = $val;
				}
			}
		}
		if (!empty($return_array)) {
			return $return_array;
		}
		else {
			return FALSE;
		}
}

function ofw_ipmahr_render_all($render_list, $reversed = FALSE, $respect_printed = FALSE) {
	$render = ($respect_printed)? ('drupal_render'): ('render');
	$return_string = FALSE;
	if (!empty($render_list)) {
		$return_string = '';
		foreach ($render_list as $item) {
			$return_string = ($reversed)? ($render($item).$return_string): ($return_string.$render($item));
		}
	}
	return $return_string;
}

function ofw_ipmahr_set_message($message = NULL, $access = 'Administer nodes', $type = 'status', $repeat = TRUE) {
	if (user_access($access)) {
		drupal_set_message($message, $type, $repeat);
	}
}

function ofw_ipmahr_set_message_r($message = NULL, $access = 'Administer nodes', $type = 'status', $repeat = TRUE) {
	if (user_access($access) || (is_int($access) && user_has_role($access))) {
		drupal_set_message('<pre>' . print_r($message, TRUE) . ' </pre>', $type, $repeat);
	}
}

function ofw_ipmahr_login_prompt($exempt_roles = array('3' => 'member', '6' => 'staff member', '4' => 'administrator'), $header = 'h4', $body = 'span') {
	if (preg_match('/^(\w|-)+$/', $header) && preg_match('/^(\w|-)+$/', $body)) {
		$return_string = '';
		if (!user_is_logged_in()) {
			$return_string .= '<div class="alignc login-prompt anonymous-user">';
			$return_string .= '<' . $header . '>You are not logged in</' . $header . '>';
			$return_string .= '<' . $body . '>To see more, try</' . $body . '><br>';
			$return_string .= '<b><a href="/user?destination=' . request_uri() . '">Logging in</a></b>';
			$return_string .= '</div>';
		}
		else {
			$user_roles_array = ofw_ipmahr_get_user_roles(NULL, 'array');
			$user_roles_string = implode(' ', $user_roles_array);
			$needs_prompt = TRUE;
			foreach ($exempt_roles as $exempt_id => $exempt_name) {
				$exempt_name = str_replace(' ', '-', $exempt_name);
				if (array_key_exists($exempt_id, $user_roles_array) || in_array($exempt_name, $user_roles_array)) {
					$needs_prompt = FALSE;
					break;
				}
			}
			if ($needs_prompt) {
				$current_role = end($user_roles_array);
				$current_role = ($current_role == 'authenticated user')? ('non-member'): ($current_role);
				$current_role = (preg_match('/^(a|e|i|o|u)/i', $current_role))? ('an ' . $current_role): ('a ' . $current_role);
				$return_string .= '<div class="alignc login-prompt ' . $user_roles_string . '">';
				$return_string .= '<' . $header . '>You are logged in as ' . $current_role . ' </' . $header . '>';
				$return_string .= '<' . $body . '>To see more, try</' . $body . '><br>';
				$return_string .= '<b><a href="/member/application?destination=' . request_uri() . '">Upgrading your account</a></b>';
				$return_string .= '</div>';
			}
		}
		return $return_string;
	}
	return FALSE;
}

function ofw_ipmahr_get_user_roles($user_object = NULL, $format = 'object', $sortby = 'weight', $delimiter = ' ', $include_default = FALSE) {
	$user_object = ($user_object)? ($user_object): ($GLOBALS['user']);
	if ($user_object->roles) {
		//load each role as an object into a new array
		$user_roles = array();
		foreach ($user_object->roles as $role_id => $role_name) {
			if ($role_id > 2 || $include_default) {
				$user_roles[$role_id] = user_role_load($role_id);
			}
		}
		//sort the $user_roles array by weight, name, or rid
		if (strtolower($sortby) == 'weight') {
			uasort(
				$user_roles,
				function ($a, $b) {
					return ($a->weight === $b->weight)? ($a->rid > $b->rid): ($a->weight > $b->weight);
				}
			);
		}
		elseif (strtolower($sortby) == 'name') {
			uasort(
				$user_roles,
				function ($a, $b) {
					return ($a->name === $b->name)? ($a->rid > $b->rid): ($a->name > $b->name);
				}
			);
		}
		else {
			uasort(
				$user_roles,
				function ($a, $b) {
					return $a->rid > $b->rid;
				}
			);
		}
		//return the $user_roles with object, array, or string format
		if (strtolower($format) == 'object') {
			return $user_roles;
		}
		elseif (strtolower($format) == 'array') {
			$user_roles_array = array();
			foreach ($user_roles as $role_object) {
				$user_roles_array[$role_object->rid] = str_replace(' ', '-', $role_object->name);
			}
			return $user_roles_array;
		}
		elseif (strtolower($format) == 'string') {
			$user_roles_string = '';
			foreach ($user_roles as $role_object) {
				$user_roles_string .= ($user_roles_string)? ($delimiter . str_replace(' ', '-', $role_object->name)): (str_replace(' ', '-', $role_object->name));
			}
			return $user_roles_string;
		}
	}
	return 'FALSE';
}

function render_in($object, $element = 'div', $attributes = array()) {
	if (preg_match('/^\w+$/', $element)) {
		$wrapper = '<' . $element;
		foreach ($attributes as $key => $value) {
			if (preg_match('/^(\w|-)+$/', $key) && !preg_match('(<|>|")', $value)) {
				$wrapper .= ' ' . $key . '="' . $value . '"';
			}
		}
		$wrapper .= '>';
		$wrapper .= render($object);
		$wrapper .= '</' . $element . '>';
		return $wrapper;
	}
	else {
		return FALSE;
	}
}

function drupal_render_in($object, $element = 'div', $attributes = array()) {
	if (preg_match('/^\w+$/', $element)) {
		$wrapper = '<' . $element;
		foreach ($attributes as $key => $value) {
			if (preg_match('/^(\w|-)+$/', $key) && !preg_match('(<|>|")', $value)) {
				$wrapper .= ' ' . $key . '="' . $value . '"';
			}
		}
		$wrapper .= '>';
		$wrapper .= drupal_render($object);
		$wrapper .= '</' . $element . '>';
		return $wrapper;
	}
	else {
		return FALSE;
	}
}

function ofw_ipmahr_get_user_content($uid, $mode = 'nodes') {
	if (!$uid || !preg_match('/^\d+$/', $uid)) {
		$uid = $GLOBALS['user']->uid;
	}
	$user_content = array();
	if (strpos($mode, 'nodes') !== FALSE || strpos($mode, 'all') !== FALSE) {
		$user_nodes = db_select('node', 'node')->fields('node')->condition('uid', $uid, '=')->execute()->fetchCol();
		$user_content = array_merge($user_content, $user_nodes);
	}
	if (strpos($mode, 'orders') !== FALSE || strpos($mode, 'all') !== FALSE) {
		$user_orders = db_select('uc_orders', 'uc_orders')->fields('uc_orders')->condition('uid', $uid, '=')->execute()->fetchCol();
		$user_content = array_merge($user_content, $user_orders);
	}
	return (strpos($mode, 'total') !== FALSE)? (count($user_content)): ($user_content);
}