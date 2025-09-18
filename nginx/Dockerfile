FROM nginx:stable

RUN apt-get update && apt-get install -y \
    nano \
    curl \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*


WORKDIR /var/www/html

RUN chmod 777 -R /var/www/html

