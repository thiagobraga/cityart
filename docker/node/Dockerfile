FROM node:8.12.0-alpine

WORKDIR /var/www
EXPOSE 3001
USER node
RUN mkdir ~/.npm-global \
  && npm config set prefix '~/.npm-global' \
  && export PATH=~/.npm-global/bin:$PATH \
  && npm i -g gulp@next

CMD ["sh", "/var/www/docker/node/run.sh"]
