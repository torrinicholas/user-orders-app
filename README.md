### Project Overview
The project uses Docker Symfony 7 and MySQL for the backend, while Angular 18 and Bootstrap 5 are used for the frontend.

### Prerequisites
Ensure Docker and Docker Compose are installed.

### Set up

1. Open a terminal.
2. Navigate to the project directory.
3. Run the command:
   ```bash
   docker compose up -d


### Access the Web App
Once the containers are running, open your web browser and go to:
**https://localhost/**

When the screen with the message "This is the entry point of API, click here to access the front end." appears, click on "here" to access the web app.

## EndPoint
### Order

- **[PUT]** `/add_update/order` - `{ "name": (string), "description": (string), "date": (string), "order_id": (int, optional) }`
- **[GET]** `/get/order/{id}
- **[GET]** `/get/all/orders` 
- **[DELETE]** `/delete/order/{id}` 
- **[GET]** `/get/products/by/order/{id}` 
- **[PUT]** `/add/product/to/order/{id}` - `{ "id_product": (int) }`
- **[POST]** `/delete/product/to/order/{id}` - `{ "id_product": (int) }`

### Product

- **[PUT]** `/add_update/product` - `{ "name": (string), "price": (float), "product_id": (int, opzionale) }`
- **[GET]** `/get/product/{id}`
- **[GET]** `/get/all/product` 
- **[DELETE]** `/delete/product/{id}`
---
