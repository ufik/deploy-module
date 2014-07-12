#!/bin/bash

if [ ! -d 'vendor/webcms2/webcms2/tests/temp' ]; then

mkdir vendor/webcms2/webcms2/tests/temp
mkdir vendor/webcms2/webcms2/tests/log

fi

if [ "$1" = "" ]; then
    exit 0
fi

rm -r report
phpunit --no-globals-backup --coverage-html ./report tests/

exit 0
