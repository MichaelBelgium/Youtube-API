<?php

namespace MichaelBelgium\YoutubeConverter;

class Config
{
    //================ convert options ================

    /**
     * The folder where downloaded songs will be placed in
     * 
     * Note: make sure the webserver has permissions to write in this folder
     */
    const DOWNLOAD_FOLDER = "download/";

    /**
     * The maximum allowed video length to download (in seconds).
     * 
     * Set to 0 to disable
     */
    const DOWNLOAD_MAX_LENGTH = 0;

    /**
     * Enable logging
     * 
     * Note: this also enables the page /logs with an overview of all songs that have been converted
     */
    const LOG = false;

    //================ search options ================

    /**
     * The maximum search results to show
     */
    const MAX_RESULTS = 10;

    /**
     * Youtube api key
     * 
     * Note: required for searching on youtube
     */
    const API_KEY = "";
}