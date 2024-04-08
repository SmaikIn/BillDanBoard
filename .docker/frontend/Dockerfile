FROM node:21-bookworm-slim

RUN apt update && apt install -y git

RUN npm install -g http-server

WORKDIR /app

RUN git clone https://github.com/danyalll1/Frontend.git

RUN cp -r ./Frontend/* ./

RUN rm -rf ./Frontend

EXPOSE 80

CMD [ "http-server", "dist" ]
