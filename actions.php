<?php

/**
 * @file
 * Implements publication period related actions on cockpit collections.
 */

$app->on('collections.find.after', function ($name, &$data) use ($app) {
  // Get the collection.
  $collection = $app->module('collections')->collection($name);
  // Iterate over the collection and check that we have the publication field.
  foreach ($collection['fields'] as $field) {
    if ($field['type'] == 'publicationperiod') {
      $name = $field['name'];
      // Field is present, check collection data entries.
      foreach ($data as $idx => $entry) {
        if (isset($entry[$name]) && !$app->module('publicationperiod')->validate($entry[$name])) {
          unset($data[$idx]);
        }
      }
      break;
    }
  }

});
