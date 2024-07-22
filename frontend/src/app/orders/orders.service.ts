import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Order {
  id: Number | null,
  name: String,
  description: String,
  date: Date
}

const API_URL: string = 'https://localhost';

@Injectable({
  providedIn: 'root'
})
export class OrdersService {

  constructor(private http: HttpClient) { }

  getOrders(): Observable<Order[]> {
    return this.http.get<Order[]>(API_URL + '/get/all/orders')
  }

  addOrder(form_values: Array<string>) {
    return this.http.put<Order[]>(API_URL + '/add_update/order', form_values);
  }

  deleteOrder(id: string) {
    return this.http.delete<Order[]>(API_URL + '/delete/order/' + id);
  }

}