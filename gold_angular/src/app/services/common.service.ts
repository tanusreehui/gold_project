import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Subject} from 'rxjs';
import {Customer} from '../models/customer.model';

@Injectable({
  providedIn: 'root'
})
export class CommonService {
  private readonly currentURL: string;
  private BASE_API_URL: string;
  settingsInfo: any = {};
  // settingsInfo: any;
  //
  // private settingsSub = new Subject<any[]>();
  // //
  // getSettingsUpdateListener(){
  //   return this.settingsSub.asObservable();
  // }

  constructor(private http: HttpClient) {
    // this.currentURL = window.location.href;
    // this.BASE_API_URL = window.location.origin + '/gold_project/new_gold_api/public/api';
    // // console.log(this.BASE_API_URL);
    // // console.log(window.location);

    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      // console.log(this.settingsInfo);
      // this.settingsSub.next([...this.settingsInfo]);

    });
  }

  getDefaultMV(){
    // return [...this.settingsInfo];
    return this.settingsInfo.mv;
  }

}


