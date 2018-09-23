#!/bin/bash

echo '===================================='
echo 'Instalando projeto'
echo '===================================='

export PATH=~/.npm-global/bin:$PATH
npm i
gulp
