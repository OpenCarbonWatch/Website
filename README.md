# Website
Resources used to build our main website

## Installation

### Database

We use PostgreSQL on Ubuntu 18.04.

```bash
sudo su postgres
psql -c "CREATE USER ocw_user PASSWORD 'secret_password';"
psql -c "CREATE DATABASE ocw OWNER ocw_user ENCODING 'UTF-8';"
```

### Application

We install the application layer on an Ubuntu 18.04 server.

```bash
git clone https://github.com/OpenCarbonWatch/Website.git /srv/ocw
cd /srv/ocw
cp .env.example .env
composer install
php artisan key:generate
```

Configure the `.env`file (mostly with the connection information towards the database).

Install **yarn** on the server with

```bash
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
apt-get update
apt-get install yarn
```

Install the application

```bash
php artisan migrate
yarn install
yarn run prod
chown -R www-data:www-data ocw
```

### Nginx

```
server {
    listen 80;
    server_name opencarbonwatch.org;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name opencarbonwatch.org;
    client_max_body_size 100M;
    gzip on;
    gzip_types text/plain text/css application/javascript text/html application/xml;
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
    }
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info  ^(.+\.php)(/.+)$;
        fastcgi_index            index.php;
        fastcgi_pass             unix:/var/run/php/php7.2-fpm.sock;
        include                  fastcgi_params;
        fastcgi_param   PATH_INFO       $fastcgi_path_info;
        fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

Then run

```
certbot
```

### Import data

```bash
sudo su postgres
psql -d ocw -c "TRUNCATE organization_types, assessment_organization, assessments, organizations;"
psql -d ocw -c "COPY organization_types FROM '/home/data/organization_types.csv' CSV HEADER;"
psql -d ocw -c "COPY assessments FROM '/home/data/assessments.csv' CSV HEADER;"
psql -d ocw -c "COPY organizations FROM '/home/data/organizations.csv' CSV HEADER;"
psql -d ocw -c "COPY assessment_organization FROM '/home/data/assessment_organization.csv' CSV HEADER;"
```

