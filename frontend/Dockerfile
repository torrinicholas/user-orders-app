FROM node:20

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 4200

# Comando di avvio
CMD ["npm", "start"]
