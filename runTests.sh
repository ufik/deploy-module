#!/bin/bash

if [ ! -d 'vendor/webcms2/webcms2/tests/temp' ]; then

mkdir vendor/webcms2/webcms2/tests/temp
mkdir vendor/webcms2/webcms2/tests/log

fi

if [ "$1" = "" ]; then
    exit 0
fi

rm -r report
phpunit --coverage-clover=coverage.clover tests/
wget https://scrutinizer-ci.com/ocular.phar
/usr/bin/php ocular.phar code-coverage:upload --format=php-clover coverage.clover

exit 0
