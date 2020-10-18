FROM node:12.19.0-alpine

WORKDIR /var/www
EXPOSE 3001
USER node
RUN mkdir ~/.npm-global \
  && npm config set prefix '~/.npm-global' \
  && export PATH=~/.npm-global/bin:$PATH \
  && npm i -g gulp

CMD ["sh", "/var/www/docker/node/run.sh"]
