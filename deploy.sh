#!/bin/bash

# Cleanup any leftovers
rm -fR ./temp

# Create deployment source
echo -e "\e[32mSTEP 1:\e[39m Copying plugin source..."
mkdir -p ./temp/src
cp -rf ./src/* temp/src

# Ensure proper composer dependencies
echo -e "\e[32mSTEP 2:\e[39m Installing composer dependencies..."
rm -fR ./temp/src/GXModules/Mollie/Mollie/vendor
composer install --no-dev --working-dir=$PWD/temp/src/GXModules/Mollie/Mollie -q

# Remove unnecessary files from final release archive
echo -e "\e[32mSTEP 3:\e[39m Removing unnecessary files from final release archive..."
rm -fR ./temp/src/GXModules/Mollie/Mollie/vendor/mollie/integration-core/.idea
rm -fR ./temp/src/GXModules/Mollie/Mollie/vendor/mollie/integration-core/generic_tests
rm -fR ./temp/src/GXModules/Mollie/Mollie/vendor/mollie/integration-core/tests
rm -rf ./temp/src/GXModules/Mollie/Mollie/vendor/mollie/integration-core/.git
rm -rf ./temp/src/GXModules/Mollie/Mollie/vendor/mollie/integration-core/.gitignore

version="$1"
if [ "$version" = "" ]; then
    echo "Please enter new plugin version (leave empty to use root folder as destination) [ENTER]:"
    read version
fi

filename="mollie_gambio_$version.zip"

# Create plugin archive
echo -e "\e[32mSTEP 4:\e[39m Creating new archive..."
cd temp
zip -q -r "$filename" *
cd ..

if [ "$version" != "" ]; then

    if [ ! -d "./PluginInstallation/$version" ]; then
        mkdir -p "./PluginInstallation/$version"
    else
        rm -rf "./PluginInstallation/$version/$filename"
    fi

    mv "temp/$filename" "./PluginInstallation/$version/$filename"
    rm -R temp
    touch "./PluginInstallation/$version/Release notes $version.txt"
    echo -e "\e[32mDONE!\n\e[93mNew release created under: $PWD/PluginInstallation/$version"
else
    mv "temp/$filename" ./mollie_gambio.zip
    rm -R temp
    echo -e "\e[32mDONE!\n\e[93mNew plugin archive created: $PWD/mollie_gambio.zip"
fi
