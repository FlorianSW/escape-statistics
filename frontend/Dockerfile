FROM node:14-alpine as code

WORKDIR /code
COPY . .
RUN npm ci && npm run build

FROM nginx:alpine

WORKDIR /usr/share/nginx/html
COPY --from=code /code/dist/frontend/ .
