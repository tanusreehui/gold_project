import { Injectable } from '@angular/core';
import {GlobalVariable} from "../shared/global";
import {HttpClient} from "@angular/common/http";
import {forkJoin, Observable} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class NewJobTaskService {

  constructor(private http: HttpClient) { }
  getSavedJobs(): Observable<any[]>{
    return this.http.get<any[]>(GlobalVariable.BASE_API_URL + '/savedJobs');
  }
  getFinishedJobs(): Observable<any[]>{
    return this.http.get<any[]>(GlobalVariable.BASE_API_URL + '/finishedJobs');
  }
  getMaterials(): Observable<any[]>{
    return this.http.get<any[]>(GlobalVariable.BASE_API_URL + '/materials');
  }

  getAll(): Observable<any>{
    return forkJoin({
      savedJobs:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/savedJobs'),
      finishedJobs:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/finishedJobs'),
      materials:  this.http.get<any>(GlobalVariable.BASE_API_URL + '/materials')
    });
  }

}
