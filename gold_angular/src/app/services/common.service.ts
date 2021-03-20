import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class CommonService {
  private readonly currentURL: string;
  private BASE_API_URL: string;
  settingsInfo: any = {};


  constructor(private http: HttpClient) {
    // this.currentURL = window.location.href;
    // this.BASE_API_URL = window.location.origin + '/gold_project/new_gold_api/public/api';
    // // console.log(this.BASE_API_URL);
    // // console.log(window.location);

    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      // console.log(this.settingsInfo);
    });
  }

  getDefaultMV(){
    return this.settingsInfo.mv;
  }

}


