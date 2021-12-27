#
# Dockerfile for the project’s website
#

FROM node:14 AS build

COPY website/ /app/website
WORKDIR /app/website
RUN yarn && yarn build

FROM nginx
COPY --from=build /app/website/build /usr/share/nginx/html
COPY ./website/default.nginx /etc/nginx/conf.d/default.conf
