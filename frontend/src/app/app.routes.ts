import { Routes } from '@angular/router';
import { ProductsComponent } from './products/products.component';

export const routes: Routes = [
  {path: 'products', component: ProductsComponent},
  { path: '', redirectTo: '/', pathMatch: 'full' },
  { path: '**', redirectTo: '/' } // Handle unknown routes
];
