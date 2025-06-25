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

    /**
     * Set a proxy for yt-dlp or youtube-dl
     *
     * Note: set to null to disable
     */
    const PROXY = null;

    /**
     * The location of the cookies file, no need to change. Create a cookies.txt file in the root of the project with Mozilla/Netscape formatted cookies.
     * If it doesn't exist, no cookies will be used.
     *
     * Can be a solution for "Sign in to confirm you’re not a bot."
     *
     * @see
     * - https://github.com/yt-dlp/yt-dlp/wiki/FAQ#how-do-i-pass-cookies-to-yt-dlp
     * - https://github.com/ytdl-org/youtube-dl/tree/master?tab=readme-ov-file#how-do-i-pass-cookies-to-youtube-dl
     */
    const COOKIE_FILE = "cookies.txt";

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