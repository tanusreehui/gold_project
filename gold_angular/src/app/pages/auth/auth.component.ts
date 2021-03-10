import { Component, OnInit } from '@angular/core';
import {NgForm} from '@angular/forms';
import {AuthResponseData, AuthService} from '../../services/auth.service';
import {StorageMap} from '@ngx-pwa/local-storage';
import {Md5} from 'ts-md5';
import {Observable} from 'rxjs';
import {Router} from '@angular/router';

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.scss']
})
export class AuthComponent implements OnInit {
  isLoginMode = true;
  isLoading = false;

  constructor(private authService: AuthService, private storage: StorageMap, private router: Router) { }

  ngOnInit(): void {
  }
  onSwitchMode(){
    this.isLoginMode = !this.isLoginMode;
  }
  onSubmit(form: NgForm){
    this.isLoading = true;
    let authObserable = new Observable<AuthResponseData>();
    // converting password to MD5
    const md5 = new Md5();
    const passwordMd5 = md5.appendStr(form.value.password).end();
    // const formPassword = form.value.password;
    authObserable = this.authService.login({email: form.value.email, password: passwordMd5});
    authObserable.subscribe(response => {
      // this.isLoading = false;
      this.isLoading = true;
      // tslint:disable-next-line:triple-equals
      if (response.user.user_type_id === 1){
        this.router.navigate(['/owner']);
      }else if (response.user.user_type_id === 8){
        this.router.navigate(['/owner']);
      }else{
        this.router.navigate(['/owner']);
      }

    }, (error) => {
      console.log('error occured ');
      console.log(error);
      this.isLoading = false;
    });

    // form.resetForm();
  }
}
