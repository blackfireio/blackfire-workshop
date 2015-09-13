#!/usr/bin/env bash
set -e

NO_COLOR="\033[0m"
OK_COLOR="\033[32;01m"
ERROR_COLOR="\033[31;01m"
WARN_COLOR="\033[33;01m"

function echo {
    builtin echo -e $@
}

function echorun {
    echo "  - for ${1}: ${WARN_COLOR}docker run --rm -it -v \$(pwd)/..:/app ${3}tucksaun/blackfire-workshop:${OK_COLOR}${2}${NO_COLOR}"
}

docker build -t tucksaun/blackfire-workshop:base -f base.Dockerfile .
for variant in blackfire xdebug xhprof
do
    docker build -t tucksaun/blackfire-workshop:${variant} -f ${variant}.Dockerfile .
done
docker tag -f tucksaun/blackfire-workshop:blackfire tucksaun/blackfire-workshop:latest
docker pull blackfire/blackfire

echo "${OK_COLOR}Done${NO_COLOR}"

echo "You can now run the containers using the followings :"
echorun "XHProf" "xhprof"
echorun "Xdebug" "xdebug"
echo "* For Blackfire:"
echo "  1. ${WARN_COLOR}docker run -d --name blackfire -e BLACKFIRE_SERVER_ID -e BLACKFIRE_SERVER_TOKEN blackfire/blackfire${NO_COLOR}"
echo "  2. ${WARN_COLOR}docker run --rm -it -v \$(pwd)/..:/app --link blackfire:blackfire tucksaun/blackfire-workshop:${OK_COLOR}blackfire${NO_COLOR}"
