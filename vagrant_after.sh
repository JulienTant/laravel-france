sudo add-apt-repository -y ppa:webupd8team/java
wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
echo "deb http://packages.elastic.co/elasticsearch/1.7/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-1.7.list
echo oracle-java8-installer shared/accepted-oracle-license-v1-1 select true | sudo /usr/bin/debconf-set-selections
sudo apt-get update && sudo apt-get -y install elasticsearch oracle-java8-installer
sudo update-rc.d elasticsearch defaults 95 10
sudo /etc/init.d/elasticsearch start