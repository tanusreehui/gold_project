import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class CommonService {
  private readonly currentURL: string;
  private BASE_API_URL: string;

  constructor() {
    this.currentURL = window.location.href;
    this.BASE_API_URL = window.location.origin + '/gold_project/new_gold_api/public/api';
    // console.log(this.BASE_API_URL);
    // console.log(window.location);
  }
}
