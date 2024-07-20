import { Component } from '@angular/core';
import { Product, ProductsService } from '../products/products.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-product-form',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './product-form.component.html',
  styleUrl: './product-form.component.css',
  providers: [ProductsService],
})
export class ProductFormComponent {

  constructor(private productsService: ProductsService) { }

  onSubmit(form_values: Array<string>) {
    this.productsService.addProduct(form_values).subscribe(
      response => {
        console.log("beneeee" + response);
      },
      error => {
        console.error('Error fetching products:', error);
      }
    );
  }
}
