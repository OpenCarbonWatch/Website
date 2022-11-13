# Website

Resources used to build our main website

## Installation of the database server

### Database

We use PostgreSQL on Ubuntu 18.04.

```bash
sudo su postgres
psql -c "CREATE USER ocw_user PASSWORD 'secret_password';"
psql -c "CREATE DATABASE ocw OWNER ocw_user ENCODING 'UTF-8';"
```

### Import data

```bash
sudo su postgres
psql -d ocw -c "TRUNCATE activities, cities, legal_types, assessment_organization, assessments, organizations;"
psql -d ocw -c "DROP INDEX IF EXISTS idx_organizations_name;"
psql -d ocw -c "COPY activities FROM '/home/data/activities.csv' CSV HEADER;"
psql -d ocw -c "COPY cities FROM '/home/data/cities.csv' CSV HEADER;"
psql -d ocw -c "COPY legal_types FROM '/home/data/legal_types.csv' CSV HEADER;"
psql -d ocw -c "COPY assessments FROM '/home/data/assessments.csv' CSV HEADER;"
psql -d ocw -c "COPY organizations FROM '/home/data/organizations.csv' CSV HEADER;"
psql -d ocw -c "COPY assessment_organization FROM '/home/data/assessment_organization.csv' CSV HEADER;"
psql -d ocw -c "CREATE INDEX idx_organizations_name ON organizations USING gin (name gin_trgm_ops);"
```

## Installation of the application server

We install the application layer on an Ubuntu 22.04 server.

### Packages

Start by installing the underlying software packages, including PHP, Composer, Node.JS and Yarn.

```bash
sudo apt update
sudo apt -y upgrade
sudo apt install -y php8.1 php8.1-{cli,curl,fpm,common,pgsql,intl,xml,mbstring,zip,soap,gd,gmp}
sudo apt -y install composer
wget -qO- https://deb.nodesource.com/setup_16.x | sudo -E bash
sudo apt-get install -y nodejs
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt update
sudo apt install -y yarn
```

### Application

```bash
sudo git clone https://github.com/OpenCarbonWatch/Website.git /srv/ocw
cd /srv/ocw
sudo cp .env.example .env
sudo composer install
sudo php artisan key:generate
```

Configure the `.env`file (mostly with the connection information towards the database).

Install the application

```bash
sudo php artisan migrate
sudo yarn install
sudo yarn run prod
sudo chown -R www-data:www-data ocw
```

### Nginx

Uninstall Apache and install Nginx
```bash
sudo systemctl disable --now apache2
sudo apt remove -y apache2
sudo apt install -y nginx
sudo systemctl start nginx
```

Create a configuration file `/etc/nginx/sites-available/ocw` with the following content

```
server {
        if ($host = opencarbonwatch.org) {
                return 301 https://$host$request_uri;
        }
        listen 80;
        server_name opencarbonwatch.org;
        return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name opencarbonwatch.org;
    client_max_body_size 100M;
    gzip on;
    gzip_types text/plain text/css application/javascript application/xml;
    root /srv/ocw/public;
    index index.php index.html index.htm index.nginx-debian.html;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    # Cache header
    location ~* \.(?:css|js|svg|ico)$ {
      expires 1y;
      access_log off;
      add_header Cache-Control "public";
      add_header X-Robots-Tag "noindex, nofollow, nosnippet, noarchive";
    }
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info  ^(.+\.php)(/.+)$;
        fastcgi_index            index.php;
        fastcgi_pass             unix:/var/run/php/php8.1-fpm.sock;
        include                  fastcgi_params;
        fastcgi_param   PATH_INFO       $fastcgi_path_info;
        fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param   PHP_VALUE "memory_limit = 2G";
        add_header X-Robots-Tag "noindex, nofollow, nosnippet, noarchive";
    }
    access_log /var/log/nginx/ocw_access.log;
}
```

Then run
```bash
sudo ln -s /etc/nginx/sites-available/ocw /etc/nginx/sites-enabled/
sudo rm /etc/nginx/sites-enabled/default
sudo systemctl restart nginx
sudo apt -y install certbot python3-certbot-nginx
sudo certbot
```
