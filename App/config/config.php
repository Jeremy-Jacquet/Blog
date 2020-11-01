<?php

define("URL", (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?route=');

define("NB_LAST_ARTICLES", 4);