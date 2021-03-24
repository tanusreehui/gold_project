import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {AuthService} from '../../services/auth.service';
import {Subscription} from 'rxjs';
import {User} from '../../models/user.model';
import {Router} from '@angular/router';
import Swal from 'sweetalert2';
import {HttpClient} from '@angular/common/http';


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
  upload(){
    Swal.fire({
      title: 'Upload Image',
      input: 'file',
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonText: 'Look up',
      showLoaderOnConfirm: true,
      preConfirm: (File: File) => {
        console.log(File);
        const formData = new FormData();
        formData.append('image', File);
        console.log(formData);
        // return this.http.post('gold_project/gold_angular/src/assets/profile_pictures/', formData).subscribe();
        return this.http.post('http://localhost:4200/test/', formData).subscribe();
        // return fetch(`//api.github.com/users/${login}`)
        //   .then(response => {
        //     // if (!response.ok) {
        //     //   throw new Error(response.statusText)
        //     // }
        //     return response.json();
        //   })
        //   .catch(error => {
        //     Swal.showValidationMessage(
        //       `Request failed: ${error}`
        //     );
        //   });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      // console.log(result);
      // const file: File = result.value;
      // const reader = new FileReader();
      // const formData = new FormData();
      // // console.log(result);
      // formData.append('image', image);
      // return this.http.post('assets/profile_pictures/DSC_1234.jpg', formData);
      // if (result.isConfirmed) {
      //   Swal.fire({
      //     // title: `${result.value.login}'s avatar`,
      //     imageUrl: 'assets/profile_pictures/DSC_0319.jpg'
      //   });
      // }
    });
  }
}
