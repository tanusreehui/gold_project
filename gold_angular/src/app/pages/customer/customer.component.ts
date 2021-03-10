import { Component, OnInit } from '@angular/core';
import {CustomerService} from '../../services/customer.service';
import {HttpClient} from '@angular/common/http';
import {map} from 'rxjs/operators';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {Customer} from '../../models/customer.model';
import {MatSnackBar} from '@angular/material/snack-bar';
import {SncakBarComponent} from '../../common/sncak-bar/sncak-bar.component';
import {Observable} from 'rxjs';
import {AuthResponseData} from '../../services/auth.service';
import Swal from 'sweetalert2';
import {Md5} from 'ts-md5';

// @ts-ignore
@Component({
  selector: 'app-customer',
  templateUrl: './customer.component.html',
  styleUrls: ['./customer.component.scss']
})

export class CustomerComponent implements OnInit {
  customerForm: FormGroup;
  customers: Customer[];
  customer: Customer;
  currentEerror: {status: number, message: string, statusText: string};
  showDeveloperDiv = true;
  // showLoginCredentials = true;

  constructor(public customerService: CustomerService, private http: HttpClient, private _snackBar: MatSnackBar) {
    this.showDeveloperDiv = false;

  }

  onCustomerInsert(){
    this.http.post('https://angular-test-db-67686.firebaseio.com/customers.json',
      {name: 'Sandip Dhara', address: 'Barrackpore Shibtala', phone: '5236458905'})
      .subscribe((response) => {
      });
  }

  ngOnInit(): void {
    // this.showLoginCredentials = true;

     // this.customers = this.customerService.getCustomers();
     this.customerForm = this.customerService.customerForm;
     this.customerService.getCustomerUpdateListener().subscribe((response)=>{
       this.customers = response;

     });
  }

  onSubmit() {

    // if (this.showLoginCredentials === true){
    //   this.customerForm.controls['email'].reset();
    //   this.customerForm.controls['password'].reset();
    // }
    // if (this.customerForm.value.password != null || this.showLoginCredentials === true){
    //   const md5 = new Md5();
    //   const passwordMd5 = md5.appendStr(this.customerForm.value.password).end();
    //   this.customerForm.patchValue({password: passwordMd5});
    // }
    this.customerService.saveCustomer(this.customerForm.value).subscribe((response: {success: number, data: Customer}) => {
      if (response.data){
        Swal.fire(
          'Done!',
          'Customer Added',
          'success'
        );
        this.customerForm.reset();
        // this.customers.unshift(response.data);
      }
    });
  }

  // showCredentials(){
  //   if (this.showLoginCredentials === false){
  //     this.showLoginCredentials = true;
  //   }else{
  //     this.showLoginCredentials = false;
  //     this.customerForm.controls['email'].reset();
  //     this.customerForm.controls['password'].reset();
  //   }
  // }

  myCustomValidation(control: FormControl): {[s: string]: boolean } {
      return {customError: true};
  }

  fillFormForUpdate($event){
    this.customerForm.setValue($event);
  }

  clearForm() {
    this.customerForm.reset();
    this.customerForm.patchValue({user_type_id : 10, customer_category_id : 2});
  }

  // this function will update the customer
  updateCustomer() {
    let updateObserable = new Observable<any>();
    updateObserable = this.customerService.updateCustomer(this.customerForm.value);


    updateObserable.subscribe((response) => {
      if (response.success === 1){
        Swal.fire(
          'Done!',
          'Customer Updated',
          'success'
        );
      }
      this.currentEerror = null;
    }, (error) => {
      this.currentEerror = error;
      this._snackBar.openFromComponent(SncakBarComponent, {
        duration: 4000, data: {message: error.message}
      });
    });
  }
}
