#!/bin/sh

# Build from ARX-UI project
rm -R public/*
git clone git@github.com:cherrylabs/arx-ui.git public
rm -rf public/.git