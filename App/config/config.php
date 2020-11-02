<?php

define("URL", (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?route=');

define("NB_LAST_ARTICLES", 4);

define("ACTIVE_ARTICLE", 1);
define("INACTIVE_ARTICLE", 0);
define("PENDING_ARTICLE", NULL);

define("MAIN_CATEGORY", 1);
define("ACTIVE_CATEGORY", NULL);
define("INACTIVE_CATEGORY", 0);