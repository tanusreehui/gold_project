import { Injectable } from '@angular/core';
import {Product} from '../models/product.model';
import {HttpClient} from '@angular/common/http';
import { Subject, throwError} from 'rxjs';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {catchError, tap} from 'rxjs/operators';
import {GlobalVariable} from '../shared/global';


export interface ProductResponseData {
  success: number;
  data: object;
}

@Injectable({
  providedIn: 'root'
})

export class ProductService {
  products: Product[] = [];
  productForm: FormGroup;
  productSubject = new Subject<Product[]>();

  getProductUpdateListener(){
    return this.productSubject.asObservable();
  }

  constructor(private http: HttpClient) {
    this.http.get(GlobalVariable.BASE_API_URL + '/products')
      .subscribe((response: {success: number, data: Product[]}) => {
        const {data} = response;
        this.products = data;
        this.productSubject.next([...this.products]);
      });

    this.productForm = new FormGroup({
      id : new FormControl(null),
      product_name : new FormControl(null, [Validators.required, Validators.maxLength(20), Validators.minLength(4)]),
      model_number : new FormControl(null, [Validators.required]),
      price_code_id : new FormControl(null, [Validators.required]),
      price_code_name : new FormControl('', [Validators.required]),
      category_name : new FormControl('', [Validators.required]),
      product_category_id : new FormControl(null, [Validators.required]),
      product_mv: new FormControl(0, [Validators.required])
    });
  }
  getProducts(){
    // when no data it will return null;
    return [...this.products];
  }

  fillFormByUpdatebaleData(product){
    // this.productForm.controls['id'].setValue(product.id);
    console.log(product);
    this.productForm.setValue(product);
    // tslint:disable-next-line:max-line-length
    // this.productForm.patchValue({id:product.id , product_name: product.product_name , model_number: product.model_number ,price_code_id: product.price_code_id , product_category_id: product.product_category_id});
  }

  saveProduct(product){
    return this.http.post<ProductResponseData>(GlobalVariable.BASE_API_URL + '/products', product)
      .pipe(catchError(this.serverError), tap((response: {success: number, data: Product})  => {
        this.products.unshift(response.data);

        this.productSubject.next([...this.products]);
      }));
  }

  updateProduct(product){
    return this.http.patch<ProductResponseData>(GlobalVariable.BASE_API_URL + '/products' , product)
      .pipe(catchError(this.serverError), tap((response: {success: number, data: Product}) => {
        const index = this.products.findIndex(x => x.id === product.id);
        this.products[index] = response.data;
        this.productSubject.next([...this.products]);
      }));
  }


  deleteProduct(id){
    return this.http.delete<{success: number, id: number}>(GlobalVariable.BASE_API_URL + '/products/' + id)
      .pipe(catchError(this.serverError), tap((response: {success: number, id: number}) => {
        if (response.success === 1){
          const index = this.products.findIndex(x => x.id === id);

          if (index !== -1) {
            this.products.splice(index, 1);
          }
        }

        this.productSubject.next([...this.products]); // here two user is used one is user and another user is subject of rxjs
      }));  // this.handleError is a method created by me
  }


  private serverError(err: any) {
    if (err instanceof Response) {
      return throwError('backend server error');
      // if you're using lite-server, use the following line
      // instead of the line above:
      // return Observable.throw(err.text() || 'backend server error');
    }
    if (err.status === 0){
      // tslint:disable-next-line:label-position
      return throwError ({status: err.status, message: 'Backend Server is not Working', statusText: err.statusText});
    }
    if (err.status === 401){
      // tslint:disable-next-line:label-position
      return throwError ({status: err.status, message: 'Your are not authorised', statusText: err.statusText});
    }
    return throwError(err);
  }

}
