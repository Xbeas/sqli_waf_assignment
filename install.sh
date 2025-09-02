## install.sh (Simple Version)
```bash
#!/bin/bash
echo "Installing SQL Injection WAF Demo..."

# Install packages
sudo apt update
sudo apt install -y apache2 nginx mysql-server php php-mysql libapache2-mod-security2

# Setup database
sudo mysql -e "CREATE DATABASE vulnerable_app; USE vulnerable_app; SOURCE database/setup.sql;"

# Copy configs
sudo mv apache-config/ports.conf /etc/apache2/
sudo cp apache-config/*.conf /etc/apache2/sites-available/
sudo cp nginx-config/sqli-proxy.conf /etc/nginx/sites-available/
sudo cp modsecurity-config/custom-rules.conf /etc/modsecurity/

# Deploy app
sudo cp -r app/* /var/www/html/
sudo chown -R www-data:www-data /var/www/html/

# Enable sites
sudo a2ensite vulnerable-backend protected-backend
sudo a2enmod security2 php8.1
sudo ln -s /etc/nginx/sites-available/sqli-proxy.conf /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default

# Restart services
sudo systemctl restart apache2 nginx mysql

echo "✅ Installation complete!"
echo "Access: http://$(curl -s ifconfig.me)/"