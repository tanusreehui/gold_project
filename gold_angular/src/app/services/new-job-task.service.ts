import { Injectable } from '@angular/core';
import {GlobalVariable} from "../shared/global";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class NewJobTaskService {

  constructor(private http: HttpClient) { }
  getSavedJobs(): Observable<any[]>{
    return this.http.get<any[]>(GlobalVariable.BASE_API_URL + '/savedJobs');
  }
}
