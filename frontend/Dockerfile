FROM node:latest

WORKDIR /app

COPY package*.json ./

RUN rm -rf node_modules && npm ci

COPY . .

EXPOSE 4200

CMD ["npm", "start"]

