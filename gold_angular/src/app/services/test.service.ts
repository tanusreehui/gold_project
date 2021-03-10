import { Injectable } from '@angular/core';
import {Customer} from '../models/customer.model';
import {HttpClient} from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
// @ts-ignore
export class TestService {
  constructor(private http: HttpClient) {

    // this.http.get('http://127.0.0.1:8000/api/customers')
    //   .subscribe((response: {success: number, data: Customer[]}) => {
    //     // @ts-ignore
    //     const {data} = response;
    //     this.customerData = data;
    //   });
  }
}
