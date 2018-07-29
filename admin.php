<?php

/**
 * @file
 * Includes admin specific hooks.
 */

$app->on('admin.init', function () {
    $this->helper('admin')->addAssets('publicationperiod:assets/component.js');
    $this->helper('admin')->addAssets('publicationperiod:assets/field-publicationperiod.tag');
});
