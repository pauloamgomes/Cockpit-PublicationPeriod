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
      ];

      // If driver is mongodb we need to use $where condition.
      if ($app->storage->type === 'mongodb') {
        $options['filter']['$and'][] = ['$where' => getWhereCondition($field['name'])];
      }
      // Otherwise for sqlite we can rely on the $fn callback.
      else {
        $options['filter']['$and'][$field['name']] = ['$fn' => 'checkPublicationPeriod'];
      }

      break;
    }
  }
});

function getWhereCondition($field_name) {
  return <<<JS
function() {
  field = this.{$field_name};
  start = field.start || null;
  end = field.end || null;
  currentDate = new Date();
  now = currentDate.getTime();

  if (start) {
    t = start.split(/[- :]/);
    date = new Date(t[0], t[1]-1, t[2], t[3], t[4], "00");
    startTime = date.getTime();
  }

  if (end) {
    t = end.split(/[- :]/);
    date = new Date(t[0], t[1]-1, t[2], t[3], t[4], "00");
    endTime = date.getTime();
  }

  if (!start && !end) {
    return true;
  } else if (start !== '' && !end) {
    if (now > startTime) {
      return true;
    }
  } else if (!start && end) {
    if (now < endTime) {
      return true;
    }
  } else {
    if (now > startTime && now < endTime) {
      return true;
    }
  }
  return false;
}
JS;
}
