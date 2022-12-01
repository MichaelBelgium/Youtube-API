#!/bin/sh
# Find the API_KEY entry and add the environment variable value set in .env
sed -i "s/API_KEY = \"\"/API_KEY = \"$API_KEY\"/" src/Config.php

exec "$@"