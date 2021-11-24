import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Subject} from 'rxjs';
import {Customer} from '../models/customer.model';
import {environment} from "../../environments/environment";

@Injectable({
  providedIn: 'root'
})
export class CommonService {
  private BASE_API_URL = environment.BASE_API_URL;
  private readonly currentURL: string;
  settingsInfo: any = {};
  private actual_base_api_url: string;


  constructor(private http: HttpClient) {

    let project_url;
    if (window.location.origin === 'http://localhost:4200'){
      project_url = 'http://127.0.0.1';
      // console.log(x);
    }else{
      project_url = window.location.origin;
    }
    this.actual_base_api_url = project_url + this.BASE_API_URL;

    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      // console.log(this.settingsInfo);
      // this.settingsSub.next([...this.settingsInfo]);

    });
  }
  getAPI(): string{
    return this.actual_base_api_url;
  }

  getDefaultMV(){
    // return [...this.settingsInfo];
    return this.settingsInfo.mv;
  }

}


