import { Component, Input, OnChanges, SimpleChanges } from '@angular/core';
import { Order, OrdersService } from '../orders/orders.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-order-form',
  standalone: true,
  templateUrl: './order-form.component.html',
  styleUrl: './order-form.component.css',
  imports: [FormsModule],
  providers: [OrdersService],
})
export class OrderFormComponent implements OnChanges {

  @Input() order: Order = { id: null, name: '', description: '', date: new Date() };

  //Load order for edit
  ngOnChanges(changes: SimpleChanges): void {
    if (changes['order'] && changes['order'].currentValue) {
      this.loadOrder(changes['order'].currentValue);
    }
  }
  loadOrder(order: Order): void { }

  constructor(private ordersService: OrdersService) { }
  //Save order
  onSubmit(form_values: Array<string>) {
    this.ordersService.addOrder(form_values).subscribe(
      response => {
        location.reload();
      },
      error => {
        console.error('Error fetching orders:', error);
      }
    );
  }

}
