import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';
import { HomeComponent } from './home/home.component';
import { OrdersComponent } from './orders/orders.component';

export const routes: Routes = [
  {path: 'products', component: ProductsComponent},
  {path: 'orders', component: OrdersComponent},
  { path: '', component: HomeComponent},
  { path: '**', component: HomeComponent } // Handle unknown routes
];
