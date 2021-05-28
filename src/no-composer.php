<?php

/**
 * Include this file if you can't do a `composer install`
 * or if you can't add this folder to the `AsciiHero\\` psr4 autoload.
 *
 * :)
 */

# Helper Class
# ------------
include __DIR__ . '/Tools.php'; # Static Helper Lib #

# Traits and Interfaces
# ---------------------
include __DIR__ . '/TraitFlexWidth.php'; # TRAIT
include __DIR__ . '/TraitDimensions.php'; # TRAIT
include __DIR__ . '/TraitBoundingBoxStandard.php'; # TRAIT
include __DIR__ . '/Traits/UsePadding.php'; # TRAIT

include __DIR__ . '/AreaInterface.php'; # INTERFACE

include __DIR__ . '/Document.php';

# Elements
# --------
include __DIR__ . '/Elements/Area.php';
include __DIR__ . '/Elements/Layout.php';
include __DIR__ . '/Elements/Divider.php';
include __DIR__ . '/Elements/Text.php';
include __DIR__ . '/Elements/Table.php';
include __DIR__ . '/Elements/Rectangle.php';
include __DIR__ . '/Elements/Stack.php';
include __DIR__ . '/Elements/TextShape.php';
include __DIR__ . '/Elements/Plain.php';