import { HttpClient } from '@angular/common/http';
import { Component, inject, OnInit } from '@angular/core';
import { Order, OrdersService } from './orders.service';
import { OrderFormComponent } from '../order-form/order-form.component';

@Component({
  selector: 'app-orders',
  standalone: true,
  imports: [OrderFormComponent],
  templateUrl: './orders.component.html',
  styleUrl: './orders.component.css'
})
export class OrdersComponent {
  orders: any = [];
  filteredOrders: any[] = [];
  selectedOrder: Order = { id: null, name: '', description: '', date: new Date() };
  sortColumn: string = '';
  sortOrder: 'asc' | 'desc' = 'asc';
  
  constructor(private ordersService: OrdersService) { }

  //Show orders list
  ngOnInit() {
    this.ordersService.getOrders().subscribe(
      response => {
        this.orders = response;
        this.filteredOrders = response;
      },
      error => {
        console.error('Error get orders: ', error);
      }
    );
  }

  deleteOrder(id: string) {
    this.ordersService.deleteOrder(id).subscribe(
      response => {
        location.reload();
      },
      error => {
        console.error('Error delete orders: ', error);
      }
    );
  }

  editOrder(order: Order): void {
    this.selectedOrder = order;
  }

  filterTable(event: Event) {
    const el = event.target as HTMLInputElement;
    var filterValue = el.value;
    this.filteredOrders = this.orders.filter((item: any) =>
      item.id.toString().toLowerCase().includes(filterValue.toLowerCase()) ||
      item.name.toString().toLowerCase().includes(filterValue.toLowerCase()) ||
      item.description.toLowerCase().includes(filterValue.toLowerCase()) ||
      item.date.toLowerCase().includes(filterValue.toLowerCase())
    );
  }

  sortTable(column: string) {
    if (this.sortColumn === column) {
      this.sortOrder = this.sortOrder === 'asc' ? 'desc' : 'asc';
    } else {
      this.sortColumn = column;
      this.sortOrder = 'asc';
    }

    this.filteredOrders.sort((a, b) => {
      let comparison = 0;
      if (a[column] > b[column]) {
        comparison = 1;
      } else if (a[column] < b[column]) {
        comparison = -1;
      }

      return this.sortOrder === 'asc' ? comparison : -comparison;
    });
  }

}
