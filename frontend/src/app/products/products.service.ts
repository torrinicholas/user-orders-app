import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Product {
  id: Number | null,
  name: String,
  price: Number
}

const API_URL: string = 'https://localhost';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  constructor(private http: HttpClient) { }

  getProducts(): Observable<Product[]> {
    return this.http.get<Product[]>(API_URL + '/get/all/product')
  }

  addProduct(form_values: Array<string>) {
    return this.http.put<Product[]>(API_URL + '/add_update/product', form_values);
  }

  deleteProduct(id: string) {
    return this.http.delete<Product[]>(API_URL + '/delete/product/' + id);
  }

}