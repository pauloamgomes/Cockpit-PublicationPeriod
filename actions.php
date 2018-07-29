<?php

/**
 * @file
 * Implements publication period related actions on cockpit collections.
 */

$app->on('collections.find.after', function ($name, &$data) use ($app) {
  // Get the collection.
  $collection = $app->module('collections')->collection($name);
  $publicationField = FALSE;
  // Iterate over the collection and check that we have the field.
  foreach ($collection['fields'] as $field) {
    if ($field['type'] == 'publicationperiod') {
      $name = $field['name'];
      foreach ($data as $idx => $entry) {
        if (isset($entry[$name]) && !$app->module('publicationperiod')->validate($entry[$name])) {
          unset($data[$idx]);
        }
      }
      break;
    }
  }

});
