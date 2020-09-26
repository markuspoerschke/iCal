#
# Dockerfile for the project’s website
#

FROM node:13 AS build_frontend

COPY website/ /app/website
WORKDIR /app/website
RUN yarn && yarn build

FROM php:7.4-alpine AS build

ADD https://github.com/CouscousPHP/Couscous/releases/download/1.8.0/couscous.phar /usr/local/bin/couscous
RUN chmod +x /usr/local/bin/couscous

COPY ./ /app
COPY --from=build_frontend /app/website/template/static /app/website/template/static
WORKDIR /app

RUN /usr/local/bin/couscous generate

FROM nginx
COPY --from=build /app/.couscous/generated /usr/share/nginx/html
