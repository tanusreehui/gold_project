import { Component, OnInit } from '@angular/core';
import {ProductService} from '../../services/product.service';
import {Product} from '../../models/product.model';
import {FormControl, FormGroup} from '@angular/forms';
import {PriceCodeService} from '../../services/price-code.service';
import {PriceCode} from '../../models/priceCode.model';
import {ProductCategoryService} from '../../services/product-category.service';
import {ProductCategory} from '../../models/productCategory.model';

import {Observable} from 'rxjs';
import {SncakBarComponent} from '../../common/sncak-bar/sncak-bar.component';
import {MatSnackBar} from '@angular/material/snack-bar';

import {ConfirmationDialogService} from '../../common/confirmation-dialog/confirmation-dialog.service';


@Component({
  selector: 'app-product',
  templateUrl: './product.component.html',
  styleUrls: ['./product.component.scss']
})
export class ProductComponent implements OnInit {

  public searchTerm: string;
  public currentError: any;
  products: Product[] = [];
  priceCodes: PriceCode[] = [];
  productCategories: ProductCategory[] = [];
  productForm: FormGroup;
  page: number;
  pageSize = 15;
  filter = new FormControl('');
  p = 1;
  // tslint:disable-next-line:max-line-length
  constructor(private productService: ProductService, private priceCodeService: PriceCodeService, private productCategoryService: ProductCategoryService, private  snackBar: MatSnackBar, private confirmationDialogService: ConfirmationDialogService) {
    this.priceCodes = this.priceCodeService.getPriceCodes();
    this.productCategories = this.productCategoryService.getProductCategory();
  }

  ngOnInit(): void {
    this.productForm = this.productService.productForm;
    this.products = this.productService.getProducts();
    this.productService.getProductUpdateListener().subscribe((responseProducts: Product[]) => {
      this.products = responseProducts;
    });

    this.priceCodeService.getPriceCodeUpdateListener().subscribe((responsePriceCodes: PriceCode[]) => {
      this.priceCodes = responsePriceCodes;
    });

    this.productCategoryService.getProductCategoryUpdateListener().subscribe((responseProductCategory: ProductCategory[]) => {
      this.productCategories = responseProductCategory;
    });
  }

  clearProductForm(){
    this.productForm.reset();
  }

  populateFormByCurrentProduct(product: Product){
    this.productService.fillFormByUpdatebaleData(product);
  }

  onSubmit(){
    this.productService.saveProduct(this.productForm.value).subscribe((response) => {
      if (response.success === 1){
        this.snackBar.openFromComponent(SncakBarComponent, {
          duration: 4000, data: {message: 'Product Saved!'}
        });
        this.productForm.reset();
      }
    }, (error) => {
      console.log('error occured ');
      console.log(error);
      this.snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: error.message}
      });
    });
  }

  updateProduct(){
    let updateObserable: Observable<any>;
    updateObserable = this.productService.updateProduct(this.productForm.value);
    updateObserable.subscribe((response) => {
      if (response.success === 1){
        this.snackBar.openFromComponent(SncakBarComponent, {
          duration: 4000, data: {message: 'Product Updated!'}
        });
      }
    }, (error) => {
      console.log('error occured ');
      console.log(error);
      this.snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: error.message}
      });
    });
  }

  public deleteCurrentProduct(product: Product) {
    this.confirmationDialogService.confirm('Please confirm..', 'Do you really want to delete product ?')
      .then((confirmed) => {
        // deleting record if confirmed
        if (confirmed){
          this.productService.deleteProduct(product.id).subscribe((response) => {
            if (response.success === 1){
              this.snackBar.openFromComponent(SncakBarComponent, {
                duration: 4000, data: {message: 'Product Deleted'}
              });
            }
            this.currentError = null;
          }, (error) => {
            console.log('error occured ');
            console.log(error);
            this.currentError = error;
            this.snackBar.openFromComponent(SncakBarComponent, {
              duration: 4000, data: {message: error.message}
            });
          });
        }

      })
      .catch(() => {
        console.log('User dismissed the dialog (e.g., by using ESC, clicking the cross icon, or clicking outside the dialog)');
      });
  }
}
