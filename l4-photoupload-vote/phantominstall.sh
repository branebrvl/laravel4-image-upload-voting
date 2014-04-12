cd /usr/local/share
wget https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-1.9.7-linux-x86_64.tar.bz2
sudo tar jxvf phantomjs-1.9.7-linux-x86_64.tar.bz2
sudo ln -s /usr/local/share/phantomjs-1.9.7-linux-x86_64/ /usr/local/share/phantomjs
sudo ln -s /usr/local/share/phantomjs/bin/phantomjs /usr/local/bin/phantomjs
phantomjs --webdriver=8643 >> /dev/null &

