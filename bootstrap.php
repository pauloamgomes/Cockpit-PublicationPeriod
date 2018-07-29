<?php

/**
 * @file
 * Cockpit Addon Bootstrap file.
 */

$this->module('publicationperiod')->extend([
  'validate' => function ($field) {
    $start = isset($field['start']) ? $field['start'] : '';
    $end = isset($field['end']) ? $field['end'] : '';
    $now = time();

    if (empty($start) && empty($end)) {
      return TRUE;
    }
    elseif (!empty($start) && empty($end)) {
      if ($now > strtotime($start)) {
        return TRUE;
      }
    }
    elseif (empty($start) && !empty($end)) {
      if ($now < strtotime($end)) {
        return TRUE;
      }
    }
    else {
      if ($now > strtotime($start) && $now < strtotime($end)) {
        return TRUE;
      }
    }
    return FALSE;
  },

]);

// Incldude admin.
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/admin.php';
}

// Include actions.
if (COCKPIT_API_REQUEST) {
  include_once __DIR__ . '/actions.php';
}
