import { Component,Input,OnChanges, SimpleChanges } from '@angular/core';
import { Product, ProductsService } from '../products/products.service';
import { FormsModule } from '@angular/forms';
import { ReturnStatement } from '@angular/compiler';

@Component({
  selector: 'app-product-form',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './product-form.component.html',
  styleUrl: './product-form.component.css',
  providers: [ProductsService],
})
export class ProductFormComponent implements OnChanges {

  @Input() product: Product  = { id: null, name: '', price: 0 };

  constructor(private productsService: ProductsService) { }

   //Load product for edit
  ngOnChanges(changes: SimpleChanges): void {
    if (changes['product'] && changes['product'].currentValue) {
      this.loadProduct(changes['product'].currentValue);
    }
  }
  loadProduct(product: Product): void {}

  //Save product
  onSubmit(form_values: Array<string>) {
    console.log(form_values);
    this.productsService.addProduct(form_values).subscribe(
      response => {
        location.reload();
      },
      error => {
        console.error('Error fetching products:', error);
      }
    );
  }
}
