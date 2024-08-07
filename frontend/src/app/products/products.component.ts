import { HttpClient } from '@angular/common/http';
import { Component, inject, OnInit } from '@angular/core';
import { Product, ProductsService } from './products.service';
import { ProductFormComponent } from '../product-form/product-form.component';

@Component({
  selector: 'app-products',
  standalone: true,
  templateUrl: './products.component.html',
  styleUrl: './products.component.css',
  imports : [ProductFormComponent],
  providers:  [ ProductsService ],
})


export class ProductsComponent implements OnInit {

  products:any = [];
  filteredProducts: any[] = [];
  selectedProduct: Product  = { id: null, name: '', price: 0 };
  
  constructor(private productsService: ProductsService) { }

  //Show products list
  ngOnInit() {
    this.productsService.getProducts().subscribe(
      response => {
        this.products = response;  
        this.filteredProducts = this.products;
      },
      error => {
        console.error('Error get products: ', error);
      }
    );
  }

  deleteProduct(id: string) {
    this.productsService.deleteProduct(id).subscribe(
      response => {
        location.reload();        
      },
      error => {
        console.error('Error delete products: ', error);
      }
    );
  }

  editProduct(product: Product): void {
    this.selectedProduct = product;
  }


  filterTable(event: Event) {
    const el = event.target as HTMLInputElement;
    var filterValue = el.value;
    this.filteredProducts = this.products.filter((item: any) =>
      item.id.toString().toLowerCase().includes(filterValue.toLowerCase()) ||
      item.name.toString().toLowerCase().includes(filterValue.toLowerCase()) ||
      item.price.toLowerCase().includes(filterValue.toLowerCase())
    );
  }
}
