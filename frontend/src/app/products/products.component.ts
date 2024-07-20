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

  constructor(private productsService: ProductsService) { }


  ngOnInit() {
    this.productsService.getProducts().subscribe(
      response => {
        this.products = response;        
        console.log(this.products);
      },
      error => {
        console.error('Error fetching products:', error);
      }
    );
  }



}
