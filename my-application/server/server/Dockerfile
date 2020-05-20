FROM bitnami/laravel:latest


ADD . /app

EXPOSE 8000
WORKDIR /app

# ENTRYPOINT bash
# ENTRYPOINT /bin/bash php artisan serve --port=$PORT --host=0.0.0.0 
USER root
CMD php artisan serve --port=$PORT --host=0.0.0.0

# CMD php artisan serve --port=$PORT --host=0.0.0.0 

# docker rm -f $(docker ps -q) &&  docker rmi tmp && docker build . -t tmp && docker run -d -p8989:8000 -t tmp