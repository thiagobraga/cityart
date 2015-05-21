# Remove previous node modules and bower components folders
rm -rf node_modules/
rm -rf assets/bower/

# Install node.js modules from package.json
npm install --save-dev

# Install bower components
bower install --save --allow-root

# Run grunt
grunt
