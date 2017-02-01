#!/bin/sh
rm -rf node_modules \
  assets/js/dist \
  assets/css/dist \
  && npm i \
  && gulp
