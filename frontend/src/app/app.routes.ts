import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { HomeComponent } from './home/home.component';
import { OrdersComponent } from './orders/orders.component';
import { ViewProductsComponent } from './view-products-by-order/view-products-by-order.component';

export const routes: Routes = [
  {path: 'products', component: ProductsComponent},
  {path: 'orders', component: OrdersComponent},
  { path: 'view/products/:id', component: ViewProductsComponent },
  { path: '', component: HomeComponent},
  { path: '**', component: HomeComponent } // Handle unknown routes
];
