import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {AuthService} from '../../services/auth.service';
import {Observable, Subscription} from 'rxjs';
import {User} from '../../models/user.model';
import {Router} from '@angular/router';
import Swal from 'sweetalert2';
import {HttpClient, HttpHeaders, HttpParams, HttpResponse} from '@angular/common/http';
import {GlobalVariable} from "../../shared/global";


@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnDestroy {
  @Input() deviceXs: boolean;
  userSub: Subscription;
  isAuthenticated = false;
  isOwner = false;
  isManager = false;
  isWorker = false;
  isWorkshopManager = false;
  isSalesManager = false;
  isAccountManager = false;
  isOfficeStaff = false;
  isAgent = false;
  isDeveloper = false;
  isCustomer = false;
  isKarigarh = false;
  router: Router;
  userInfo: User;
  messages: any;
  message: any;
  showupload = false;
  file: File = null;
  imageSrc: any;
  constructor(private authService: AuthService, private http: HttpClient) { }

  ngOnInit(): void {
    // this.authService.getChats();
    this.authService.getChats();
    this.userSub = this.authService.user.subscribe(user => {
      this.userInfo = user;
      if (user){
        this.isAuthenticated = user.isAuthenticated;
        this.isOwner = user.isOwner;
        this.isManager = user.isManager;
        this.isWorker = user.isWorker;
        this.isWorkshopManager = user.isWorkshopManager;
        this.isSalesManager = user.isSalesManager;
        this.isAccountManager = user.isAccountManager;
        this.isOfficeStaff = user.isOfficeStaff;
        this.isAgent = user.isAgent;
        this.isDeveloper = user.isDeveloper;
        this.isCustomer = user.isCustomer;
        this.isKarigarh = user.isKarigarh;
      }else{
        this.isAuthenticated = false;
        this.isOwner = false;
        this.isManager = false;
        this.isWorker = false;
        this.isWorkshopManager = false;
        this.isSalesManager = false;
        this.isAccountManager = false;
        this.isOfficeStaff = false;
        this.isAgent = false;
        this.isDeveloper = false;
        this.isCustomer = false;
        this.isKarigarh = false;
      }
    });
    // this.authService.getMessageSubUpdateListener().subscribe((response)=>{
    // });
    this.authService.getMessageSubUpdateListener().subscribe((response)=>{
      this.messages = response;

    });
  }

  saveMessage(){

    const a ={
      customer_name : this.userInfo.userName,
      messages: this.message
    }
    this.authService.sendChats(a).subscribe((response)=>{
      if(response) {
        this.message = '';
      }
    });
  }

  getChats(){
      this.authService.getMessageSubUpdateListener().subscribe((response)=> {
      });
    this.authService.getChats();
  }

  ngOnDestroy(): void {
    this.userSub.unsubscribe();
  }

  logout() {
    this.authService.logout();
  }

  myStyle(){
    // return {'background-color': '#e83d44'};
    return {
      // 'background-color': 'rgba(255,0,0,' + (10 / 100) + ')',
      'background-color': 'rgba(147,112,219,.3)',
      color : 'white'
    };
  }
  // onUpload(event) {
  //   const user = JSON.parse(localStorage.getItem('user'));
  //   const config = { headers: {
  //       'Content-Type': undefined
  //       , Bearer: user.token
  //     }
  //   };
  //
  //   // console.log(document.getElementById(ID));
  //   const formData = new FormData();
  //   const  img = new Image();
  //   img.src = URL.createObjectURL(event.target.files[0]);
  //   console.log(event.target.files[0]);
  //   // console.log(document.getElementById('test1'));
  //   // return;
  //   // tslint:disable-next-line:only-arrow-functions
  //   img.onload = function() {
  //     formData.append('title', event.target.files[0]);
  //   };
  //   console.log(formData);
  //   // this.http.post(GlobalVariable.BASE_API_URL + '/testPic', 1234).subscribe();
  //   const x = JSON.stringify({info: formData});
  //   this.http.post('http://127.0.0.1/gold_project/new_gold_api/public/api/dev/testPic', formData).subscribe();
  //   // const test = document.getElementById(event);
  //   // console.log(document.getElementById('test1'));
  //
  //   return;
  //   // this.fileUploadService.upload(this.file).subscribe(
  //   //   (event: any) => {
  //   //     if (typeof (event) === 'object') {
  //   //
  //   //       // Short link via api response
  //   //       this.shortLink = event.link;
  //   //
  //   //       this.loading = false; // Flag variable
  //   //     }
  //   //   }
  //   // );
  // }

  onChange(event) {
    this.file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = e => this.imageSrc = reader.result;

    reader.readAsDataURL(this.file);
  }

  onUpload(){
     console.log(this.file);
      this.authService.upload(this.file).subscribe(
        (event: any) => {
          if (typeof (event) === 'object') {
          }
        }
      );
    }

}
