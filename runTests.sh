#!/bin/bash

mkdir vendor/webcms2/webcms2/tests/temp
mkdir vendor/webcms2/webcms2/tests/log

phpunit --no-globals-backup --bootstrap vendor/webcms2/webcms2/tests/bootstrap.php tests/Entity