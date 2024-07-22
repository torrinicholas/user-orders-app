import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { OrdersService } from '../orders/orders.service';
import { AddProductToOrderComponent } from '../add-product-to-order/add-product-to-order.component';

@Component({
  selector: 'app-view-products-by-order',
  standalone: true,
  templateUrl: './view-products-by-order.component.html',
  styleUrl: './view-products-by-order.component.css',
  imports: [AddProductToOrderComponent],
})
export class ViewProductsComponent implements OnInit {
  orderId!: string;
  products: any = [];  

  constructor(private route: ActivatedRoute, private ordersService: OrdersService) { }

  ngOnInit(): void {
    this.orderId = this.route.snapshot.paramMap.get('id')!;

    this.ordersService.getProducts(this.orderId).subscribe(
      response => {        
        this.products = response;
      },
      error => {
        console.error('Error get products: ', error);
      }
    );
  }

  deleteProduct(id: string) {
    this.ordersService.deleteProduct(this.orderId, id).subscribe(
      response => {
        location.reload();
      },
      error => {
        console.error('Error delete orders: ', error);
      }
    );
  }

}
