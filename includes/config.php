<?php

// convert.php
define("DOWNLOAD_FOLDER", "download/"); //Be sure the chmod the download folder
define("DOWNLOAD_MAX_LENGTH", 0); //max video duration (in seconds) to be able to download, set to 0 to disable
define("LOG", false); //enable logging

// search.php
define("MAX_RESULTS", 10); //maximum results to show 
define("API_KEY", ""); //youtube api key from google