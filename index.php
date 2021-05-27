<?php

include 'examples.php';

define('EQUALIZE_TOP', 1);
define('EQUALIZE_BOTTOM', 2);
define('EQUALIZE_BOTH', 3);

## HopHop!
## [todo] move them to the composer.json

# Helper Class
# ------------
include 'src/Tools.php'; # Static Helper Lib #

# Traits and Interfaces
# ---------------------
include 'src/TraitFlexWidth.php'; # TRAIT
include 'src/AreaInterface.php'; # INTERFACE

include 'src/Document.php';

# Elements
# --------
include 'src/Elements/Area.php';
include 'src/Elements/Layout.php';
include 'src/Elements/Divider.php';
include 'src/Elements/Text.php';

# Tests:
# ------
include 'tests.php';