<?php

/**
 * @file
 * Implements publication period related actions on cockpit collections.
 */

/**
 * Validates the publication period field against current date.
 *
 * @param  array $field
 *   The publication period composed by start and end keys.
 *
 * @return bool
 *   True if field match criteria.
 */
function checkPublicationPeriod(array $field) {
  $start = $field['start'] ?? '';
  $end = $field['end'] ?? '';
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
}

$app->on('collections.find.before', function ($name, &$options) use ($app) {

  // Get the collection.
  $collection = $this->module('collections')->collection($name);

  foreach ($collection['fields'] as $field) {

    if ($field['type'] == 'publicationperiod') {
      $options['filter']['$and'] = [
         ["{$field['name']}" => ['$exists' => TRUE]],
         ["{$field['name']}.start" => ['$exists' => TRUE]],
         ["{$field['name']}.end" => ['$exists' => TRUE]],
         ["{$field['name']}" => ['$fn' => 'checkPublicationPeriod']],
      ];

      break;
    }
  }
});
