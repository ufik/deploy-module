#!/bin/bash

mkdir vendor/webcms2/webcms2/tests/temp
mkdir vendor/webcms2/webcms2/tests/log

phpunit --no-globals-backup tests/Entity

rm -r report
phpunit --no-globals-backup --coverage-html ./report tests/Entity/ApplicationTest
