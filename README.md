# Atlas of Demography
​
​
## Prerequisites
​
Install system dependencies in this case for Ubuntu 22.04
​
```
sudo apt install nginx certbot php8.2-fpm
```
​
​
## Configure PHP-FPM pool
​
Create a socket file `touch /etc/php/8.2/fpm/pool.d/open-social-map.conf`
​
```
[open_social_map]
user = ubuntu
group = ubuntu
listen = /var/run/php8.2-fpm-open-social-map.sock
listen.owner = www-data
listen.group = www-data
php_admin_value[disable_functions] = exec,passthru,shell_exec,system
php_admin_flag[allow_url_fopen] = off
; Choose how the process manager will control the number of child processes.
pm = dynamic
pm.max_children = 75
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.process_idle_timeout = 10s
```
​
## Start and enable PHP-FPM service
​
```
sudo systemctl start php8.2-fpm.service
sudo systemctl status php8.2-fpm.service
sudo systemctl enable php8.2-fpm.service
```
​
​
## Configure NGINX to listen on PHP-FPM socket
​
Add the following content to `sudo vim /etc/nginx/sites-enabled/default`
​
```
server {
  # listen 443 ssl http2;
  # listen [::]:443 ssl http2;
​
  server_name dev.sozialatlas-flensburg.de;
  root /opt/git/sozialatlas-flensburg;
  index index.html index.htm index.php;
​
  location / {
    try_files $uri $uri/ /index.php$is_args$args;
  }
​
  location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass unix:/var/run/php8.2-fpm-open-social-map.sock;
    fastcgi_index index.php;
    include fastcgi.conf;
  }
​
  listen 80;
}
```
​
​
## Retrieve SSL certificate `letsencrypt.com`
​
Make sure to uncomment the lines for using `http2` when successful
​
```
sudo certbot -d dev.sozialatlas-flensburg.de
```
​
​
## Test webserver configuration
​
```
sudo nginx -t
```
​
If there were no erros restart server
​
```
sudo systemctl restart nginx.service
```
​
In case your webserver didn't start up lock up log files
​
```
sudo less +F /var/log/syslog
```
​
​
## Clone application file from github
​
```
git clone https://github.com/roaldchristesen/sozialatlas-flensburg.git
cd /opt/git/open-monuments-map/
```
​
​
## Test if you get a http status code 200
​
```
curl -X GET https://dev.sozialatlas-flensburg.de -I
```