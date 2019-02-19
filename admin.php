<?php

/**
 * @file
 * Includes admin specific hooks.
 */

// Module ACL definitions.
$this("acl")->addResource('publicationperiod', [
  'access',
]);

$app->on('admin.init', function () {
    $this->helper('admin')->addAssets('publicationperiod:assets/component.js');
    $this->helper('admin')->addAssets('publicationperiod:assets/field-publicationperiod.tag');
});
