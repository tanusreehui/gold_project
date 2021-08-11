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
import {CommonService} from '../../services/common.service';
import {CustomerCategoryService} from '../../services/customer-category.service';
import {CustomerCategory} from '../../models/customerCategory.model';

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
  settingsInfo: any;
  customerCategoryList: CustomerCategory[];

  currentEerror: {status: number, message: string, statusText: string};
  showDeveloperDiv = true;
  // showLoginCredentials = true;

  constructor(public customerService: CustomerService, private commonService: CommonService, private http: HttpClient, private _snackBar: MatSnackBar, private customerCategoryService: CustomerCategoryService) {
    this.showDeveloperDiv = false;
    this.customerForm = this.customerService.customerForm;

    // for getting settings data (Ex- mv etc) from json file
    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      this.customerForm.patchValue({mv : this.settingsInfo.mv});
    });
    this.customerCategoryList = this.customerCategoryService.getCustomerCategory();

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
     // this.customerForm = this.customerService.customerForm;


     // this.commonService.getSettingsUpdateListener().subscribe((response) => {
     //   console.log('test customer component');
     //   console.log(response);
     // });
     // this.customerForm.patchValue({mv : this.settingsInfo.mv});
     // console.log(this.commonService.getDefaultMV());
     this.customerService.getCustomerUpdateListener().subscribe((response) => {
       this.customers = response;
     });
     this.customerCategoryService.getCustomerCategoryUpdateListener().subscribe((response) => {
       this.customerCategoryList = response;
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
        if (response.success === 1) {
          Swal.fire(
            'Done!',
            'Customer Added',
            'success'
          );
          this.customerForm.reset();
          // this.customerForm = this.customerService.customerForm;
          this.customerForm.patchValue({state: 'West Bengal', mv: this.settingsInfo.mv});
          // this.customers.unshift(response.data);
      }
        else{
          Swal.fire(
            'Error',
            'Customer name already exists, please choose a different name',
            'error'
          );
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
      if (response.success === 0){
        Swal.fire(
          'Error',
          'Customer Name already exists',
          'error'
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
