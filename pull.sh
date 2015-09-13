#!/usr/bin/env bash
set -e

NO_COLOR="\033[0m"
OK_COLOR="\033[32;01m"
ERROR_COLOR="\033[31;01m"
WARN_COLOR="\033[33;01m"

function echo {
    set -f
    builtin echo -e "$@"
    set +f
}

function echorun {
    echo "* For ${1}: ${WARN_COLOR}docker run --rm -it -v \$(pwd):/app tucksaun/blackfire-workshop:${OK_COLOR}${2}${NO_COLOR}"
}

for variant in xdebug xhprof blackfire
do
    docker pull tucksaun/blackfire-workshop:${variant}
done
docker pull blackfire/blackfire

echo "${OK_COLOR}Done${NO_COLOR}"

echo "You can now run the containers using the followings :"
echorun "XHProf" "xhprof"
echorun "Xdebug" "xdebug"
echo "* For Blackfire:"
echo "  1. ${WARN_COLOR}docker run -d --name blackfire -e BLACKFIRE_SERVER_ID -e BLACKFIRE_SERVER_TOKEN blackfire/blackfire${NO_COLOR}"
echo "  2. ${WARN_COLOR}docker run --rm -it -v \$(pwd):/app --link blackfire:blackfire tucksaun/blackfire-workshop:${OK_COLOR}blackfire${NO_COLOR}"
