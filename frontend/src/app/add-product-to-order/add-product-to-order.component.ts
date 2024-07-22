import { Component, Input, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ProductsService } from '../products/products.service';
import { OrdersService } from '../orders/orders.service';
import { response } from 'express';

@Component({
  selector: 'app-add-product-to-order',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './add-product-to-order.component.html',
  styleUrl: './add-product-to-order.component.css'
})
export class AddProductToOrderComponent implements OnInit {
  products: any[] = [];
  @Input() orderId!: string;

  constructor(private productsService: ProductsService, private ordersService: OrdersService) { }

  ngOnInit(): void {
    this.productsService.getProducts().subscribe(response => {
      this.products = response;
    });
  }

  onSubmit(form_values: Array<string>) {    
    this.ordersService.addProduct(this.orderId, form_values).subscribe(
      response => {
        location.reload();
      },
      error => {
        console.error('Error fetching products:', error);
      }
    );
  }

}