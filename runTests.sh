#!/bin/bash

mkdir vendor/webcms2/webcms2/tests/temp
mkdir vendor/webcms2/webcms2/tests/log

phpunit --no-globals-backup tests/

if [ "$1" = "" ]; then
    exit 0
fi

rm -r report
phpunit --no-globals-backup --coverage-html ./report tests/

exit 0
