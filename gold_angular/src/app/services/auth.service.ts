import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse} from '@angular/common/http';
import {catchError, tap} from 'rxjs/operators';
import {BehaviorSubject, Subject, throwError} from 'rxjs';
import {User} from '../models/user.model';
import {Router} from '@angular/router';
// global.ts file is created in shared folder to store all global variables.
import {GlobalVariable} from '../shared/global';

export interface AuthResponseData {
  token: string;
  // token: {headers: object, original: {access_token: string, token_type: string, expires_in: number}, exception: object };
  // tslint:disable-next-line:ban-types
  // token: String;
  user: {id: number, user_name: string,  user_type_id: number};
}

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  user = new BehaviorSubject<User>(null);

  constructor(private http: HttpClient, private router: Router) { }
  isAuthenticated() {
    if (this.user.value) {
      return true;
    } else {
      return false;
    }
  }

  autoLogin(){
    const userData: {
      // userTypeId: number;
      id: number, userName: string, _authKey: string, userTypeId: number} = JSON.parse(localStorage.getItem('user'));
    if (!userData){
      return;
    }
    const loadedUser = new User(userData.id, userData.userName, userData._authKey, userData.userTypeId);
    if (loadedUser.authKey){
      this.user.next(loadedUser);
      //  if (loadedUser.isOwner){
      //   this.router.navigate(['/owner']);
      // }
    }
  }
  login(loginData){
    return this.http.post<AuthResponseData>('http://127.0.0.1:8000/api/login', loginData)
      .pipe(catchError(this.handleError), tap(resData => {
        // tslint:disable-next-line:max-line-length
          const user = new User(resData.user.id,
                  resData.user.user_name,
                  resData.token,
                  resData.user.user_type_id);
          this.user.next(user); // here two user is used one is user and another user is subject of rxjs
          localStorage.setItem('user', JSON.stringify(user));
          // console.log('resdata');
          // console.log(resData.user);
      }));  // this.handleError is a method created by me
  }

  private handleError(errorResponse: HttpErrorResponse){
    console.log('Login Failed');
    console.log(errorResponse);
    return throwError(errorResponse.error.message);
  }

  logout(){
    this.user.next(null);
    localStorage.removeItem('user');
    this.router.navigate(['/auth']);
    location.reload();
  }


}