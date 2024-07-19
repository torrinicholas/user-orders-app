FROM node:20

WORKDIR /app

COPY package*.json ./

RUN npm install

RUN npm install bootstrap@5.3.3

COPY . .

EXPOSE 4200

# Comando di avvio
CMD ["npm", "start"]
