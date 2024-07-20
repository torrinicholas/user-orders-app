import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Product {
  id: Number,
  name: String,
  price: Number
}

const API_URL: string = 'https://localhost/';

@Injectable({
  providedIn: 'root'
})
export class ProductsService {

  constructor(private http: HttpClient) { }

  getProducts(): Observable<Product[]> {
    return this.http.get<Product[]>(API_URL + 'get/all/product')
  }

  getString() {
    return "ciao bello";
  }
  // Add more methods as needed
}