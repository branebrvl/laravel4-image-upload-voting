#!/bin/bash

# This Script is meant to work in tandem with Vagrant file.
# Tasks:
# - create laravel project wiht composer
# - update app key for sake of security
# - add empty README.md
# - set local timezone
# - Install useful packages for Laravel dev
#   + way/generators https://github.com/JeffreyWay/Laravel-4-Generators
#   + itsgoingd/clockwork https://github.com/itsgoingd/clockwork
#   + fzaninotto/faker https://github.com/fzaninotto/Faker
# - set aliases and service # - set clockwork files in app/start/local.php
#   + now you can debug you app by using console logs by typing: l('log this')
# - create laravel local env files and settings 
# - crate mysql database and set laravel db config
# - set apache user and group to vagrant so it can rw to app/storage
# - set up apache vhost for vagrant folder, so you can access the server as: 192.168.33.10.xip.io
# - to use SauceLab connect to test your local instance edit your host file
# 127.0.0.1 192.168.33.10

# Colors
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_RED=$ESC_SEQ"31;01m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_LIGHTGREEN=$ESC_SEQ"92;01m"
COL_YELLOW=$ESC_SEQ"33;01m"
COL_BLUE=$ESC_SEQ"34;01m"
COL_MAGENTA=$ESC_SEQ"35;01m"
COL_CYAN=$ESC_SEQ"36;01m"
COL_PURPLE=$ESC_SEQ"35;01m"
YN_PROMPT=$COL_RESET"["$COL_YELLOW"y,n"$COL_RESET"]?"

if [ -z "$1" ]; then
      ip_address="192.168.33.10"
else
      ip_address="$1"
fi

if [ -z "$2" ]; then
      laravel_root_folder="/vagrant"
else
      laravel_root_folder="$2"
fi
if [ -z "$3" ]; then
      database="laraveldb"
else
      database="$3"
fi
if [ -z "$4" ]; then
     passworddb="root"
else
     passworddb="$4"
fi

# Test if Composer is installed
composer --version > /dev/null 2>&1
COMPOSER_IS_INSTALLED=$?

if [ $COMPOSER_IS_INSTALLED -gt 0 ]; then
   echo "ERROR: Laravel install requires composer"
   exit 1
fi

apache2 -v > /dev/null 2>&1
APACHE_IS_INSTALLED=$?

# Is laravel installed
if [ ! -f "$laravel_root_folder/composer.json" ]; then
  cd $laravel_root_folder
  mkdir tmp
  # Intial Setup
  echo -e "\n$COL_PURPLE Configuring New Laravel 4.1 Application in dir $laravel_root_folder ...\n$COL_RESET"

  # Create new laravel Project
  echo -e "\n$COL_PURPLE Performing Composer create-project, this may take some time, grab a coffee...\n$COL_RESET"
  # sudo composer create-project laravel/laravel --prefer-dist
  # git clone https://github.com/laravel/laravel.git tmp && mv tmp/.git . && rm -rf tmp && git reset --hard && rm -rf .git
  pwd
  git clone https://github.com/laravel/laravel.git tmp && rm -rf tmp/.git readme.md && mv tmp/{.,}* ./ 
  rm -rf $laravel_root_folder/tmp

    echo -e "\n $COL_PURPLE Installing less and livereload project...\n $COL_RESET"
    cd $laravel_root_folder
    mv gruntwatchlesslivereload/{.,}* public/ 
    rm -rf $laravel_root_folder/gruntwatchlesslivereload 
    # cd $laravel_root_folder/public
    # npm install
    # bower install   
    cd $laravel_root_folder
    echo -e "\n $COL_PURPLE LiveReload monitors changes in the file system. As soon as you save a file, it is preprocessed as needed, and the browser is refreshed.\n $COL_RESET"
    echo -e "\n $COL_PURPLE Please be sure to enable the LiveReload plugin in your broswer\n $COL_RESET"

  # create application todo file
  echo "$laravel_root_folder README:" > README.md

  # set local timezone
  sed -i "s/'timezone' => 'UTC',/'timezone' => 'America\/Los_Angeles',/g" app/config/app.php

  # Install and Configure way/generators, itsgoingd/clockwork, fzaninotto/faker packages
  echo -e "\n"
  echo -e "-- Adding $COL_GREEN Way/Generators, itsgoingd/clockwork$COL_RESET and$COL_GREEN Faker$COL_RESET Libraries to $COL_YELLOW$laravel_root_folder$COL_RESET"
  sed -i '8 a\
    "require-dev": { \
      "way/generators": "dev-master", \
      "itsgoingd/clockwork": "dev-master", \
      "fzaninotto/faker": "dev-master", \
      "mockery/mockery": "dev-master", \
      "behat/behat": "2.5.*@stable", \
      "behat/mink": "1.5@stable", \
      "behat/mink-extension": "*", \
      "behat/mink-selenium2-driver": "*", \
      "behat/mink-goutte-driver": "*" \
    },
  ' composer.json
  sed -i "109 a\ \t\t'Way\\\Generators\\\GeneratorsServiceProvider'," app/config/app.php
  sed -i "110 a\ \t\t'Clockwork\\\Support\\\Laravel\\\ClockworkServiceProvider'," app/config/app.php
  echo -e "\n$COL_PURPLE Performing Composer Update with new dependencies...\n$COL_RESET"
  sudo composer update
  echo -e "\n"

  # update application key (currently not done by laravel.phar)
  php artisan key:generate

  # publish console assets
  php artisan asset:publish

  # Update app/bootstrap/start.php with env function
  sed -i -e'27,31d' bootstrap/start.php
  sed -i "26 a\ \$env = \$app->detectEnvironment(function() { return getenv('LARAVEL4_ENV') ?: 'prod'; });" bootstrap/start.php

  # Set up local database and service providers for way/generators and clockwork

  cat <<'EOF' > app/config/local/app.php
  <?php return [

    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Append environment service providers
    |--------------------------------------------------------------------------
    */

    'providers' => append_config([
      'Clockwork\Support\Laravel\ClockworkServiceProvider',
      'Way\Generators\GeneratorsServiceProvider',
    ]),

    /*
    |--------------------------------------------------------------------------
    |  Append environment aliases
    |--------------------------------------------------------------------------
    */

    'aliases' => append_config([
      'Clockwork' => 'Clockwork\Support\Laravel\Facade',
    ]),

  ];
EOF

  cat <<'EOF' > app/start/local.php
  <?php
  function l($val)
  {
    return Clockwork::info($val);
  }

  function start($name, $description)
  {
    return Clockwork::startEvent($name, $description);
  }

  function stop($name)
  {
    return Clockwork::endEvent($name);
  }
EOF

  sed -i "s/'debug' => true,/'debug' => false,/g" app/config/app.php

  echo -e "-- Updating database configuration file\n"
  sed -i "s/'host'      => 'localhost',/'host'      => getenv('L4_DB_HOST'),/g" app/config/database.php
  sed -i "s/'database'  => 'database',/'database'  => getenv('L4_DB_DATABASE'),/g" app/config/database.php
  sed -i "s/'username'  => 'root',/'username'  => getenv('L4_DB_USERNAME'),/g" app/config/database.php
  sed -i "s/'password'  => '',/'password'  => getenv('L4_DB_PASSWORD'),/g" app/config/database.php

cat <<EOF > .env.local.php
  <?php return [
          'L4_DB_HOST'      => 'localhost',     
          'L4_DB_DATABASE'  => '$database',
          'L4_DB_USERNAME'  => 'root', 
          'L4_DB_PASSWORD'  => '$passworddb', 
  ];
EOF

else
    echo ">>> Installing Composer Packages:"
    sudo composer install
fi
# end of 'is laravel installed' if statement


# Create mysql database
echo "-- Creating MySQL database"
mysql -uroot -p$passworddb -e "CREATE DATABASE \`$database\`"
# add a user that can connect from anywhere
mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '' WITH GRANT OPTION; FLUSH PRIVILEGES;"
sudo /etc/init.d/mysql restart

# Create new apache vhost
if [ $APACHE_IS_INSTALLED -eq 0 ]; then
    # Remove apache vhost from default and create a new one
    sudo rm /etc/apache2/sites-enabled/$ip_address.xip.io.conf > /dev/null 2>&1
    sudo rm /etc/apache2/sites-available/$ip_address.xip.io.conf > /dev/null 2>&1
    sudo vhost -s $1.xip.io -d "$laravel_root_folder/public"
    sudo sed -i 's/.*DocumentRoot.*/SetEnv LARAVEL4_ENV local\n&/' /etc/apache2/sites-available/$ip_address.xip.io.conf
    sudo service apache2 reload
fi

# Migrate and seed db
cd $laravel_root_folder
php artisan migrate --env=local
php artisan db:seed --env=local

    # Move livereload and less files to public folder, initiate npm and bower install and run grunt watch
    # watch logs will be stored in the tmp folder

    echo -e "\n $COL_PURPLE Setup Complete!\n $COL_RESET"
    echo -e "\n $COL_PURPLE You can see you app if you navigate your browser to $ip_address.xip.io\n $COL_RESET"
