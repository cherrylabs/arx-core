#!/bin/sh

rm -R public/*

git clone git@github.com:cherrylabs/arx-ui.git public

rm -rf public/.git

rm -R public/src