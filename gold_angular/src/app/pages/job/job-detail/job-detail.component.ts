import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {JobTaskService} from '../../../services/job-task.service';
import {AuthService} from '../../../services/auth.service';
import {JobService} from '../../../services/job.service';
import {JobMaster} from '../../../models/jobMaster.model';
import {FormGroup} from '@angular/forms';
import {OrderService} from '../../../services/order.service';
import {Material} from '../../../models/material.model';
import {Karigarh} from '../../../models/karigarh.model';
import {User} from '../../../models/user.model';
import {JobDetail} from '../../../models/jobDetail.model';
import {environment} from "../../../../environments/environment";

@Component({
  selector: 'app-job-detail',
  templateUrl: './job-detail.component.html',
  styleUrls: ['./job-detail.component.scss']
})
export class JobDetailComponent implements OnInit {
  showDeveloperDiv = false;
  isProduction = environment.production;
  sub: object;
  id: number;
  job_number: string;
  jobTaskForm: FormGroup;
  savedJobsData: JobMaster[];
  currentJobData: JobMaster;
  materialList: Material[];
  karigarhData: Karigarh[] = [];
  userData: User = null;
  karigarhName: string = null;
  totalData: JobDetail[];
  showTransactionDiv = false;
  jobTransactionData: JobDetail[];
  btnControl: boolean = null;
  tempTotalData = [0, 0 , 0 , 0 , 0 , 0, 0, 0];
  FGWt: number;

  // we have to change this values dynamically
  finishBadgeValue = 0;
  goldSendBadge = 0;
  goldRetBadge = 0;
  dalSendBadge = 0;
  dalRetBadge = 0;
  panSendBadge = 0;
  panRetBadge = 0;
  BronzeSendBadge = 0;
  nitricRetBadge = 0;


  // tslint:disable-next-line:max-line-length
  constructor(private route: ActivatedRoute
              , private  jobTaskService: JobTaskService
              , private  jobService: JobService
              , private  orderService: OrderService) {

    this.route.data.subscribe((response: any) => {
     // console.log("Response is: ", response.jobDetail);
      // console.log('Printing from Saved Jobs: ',response.jobDetail.jobTask.savedJobs.data);
      // console.log('Second Call : ',response.jobDetail[1].karigarhs.data);
      // console.log('Third Call : ',response.jobDetail[2].agents.data);
      // console.log('orderMaterials : ',response.jobDetail[2].orderMaterials.data);
      // console.log('orderMasters : ',response.jobDetail[2].orderMasters.data);
      // // console.log('completedBill : ',response.jobDetail[3].completedBill.data);
      this.savedJobsData = response.jobDetail.jobTask.savedJobs.data;
      this.karigarhData = response.jobDetail.job.karigarhs.data;
      this.materialList = response.jobDetail.jobTask.materials.data;
      this.jobTaskForm = this.jobTaskService.jobTaskForm;
      console.log('check ', response.jobDetail.currentJob.data);
      this.currentJobData = response.jobDetail.currentJob.data;
      this.jobTaskForm.patchValue({id: this.currentJobData.id});
      this.job_number = this.currentJobData.job_number;
      this.jobTaskForm.patchValue({size: this.currentJobData.size});
      const index1 = this.karigarhData.findIndex(x => x.id === this.currentJobData.karigarh_id);
      this.karigarhName = this.karigarhData[index1].user_name;

      this.userData = JSON.parse(localStorage.getItem('user'));

      this.userData = JSON.parse(localStorage.getItem('user'));
      this.route.params.subscribe(params => {
        this.showTransactionDiv = false;
        // tslint:disable-next-line:radix
        this.id = parseInt(params.id);
        // tslint:disable-next-line:no-shadowed-variable
        this.jobTaskService.getCurrentJobData(this.id).subscribe((response: {success: number , data: JobMaster}) => {
          // this.currentJobData = response.data;
          // this.jobTaskForm.patchValue({id: this.currentJobData.id});
          // this.job_number = this.currentJobData.job_number;
          // this.jobTaskForm.patchValue({size: this.currentJobData.size});
          // const index1 = this.karigarhData.findIndex(x => x.id === this.currentJobData.karigarh_id);
          // this.karigarhName = this.karigarhData[index1].user_name;
          //
          // this.userData = JSON.parse(localStorage.getItem('user'));
          // console.log(this.userData);
          // tslint:disable-next-line:no-shadowed-variable
          this.orderService.getMaterialUpdateListener().subscribe((response) => {
            this.materialList = response;
            const index = this.materialList.findIndex(x => x.id === this.currentJobData.material_id);
            const materialData = this.materialList[index];
            this.jobTaskForm.patchValue({material_name: materialData.material_name});
          });
        });


        this.jobTaskService.getBadgeValue().subscribe((response) => {
          this.finishBadgeValue = response.finshBadgeValue || 0;
          this.goldSendBadge = response.goldSendBadge;
          this.goldRetBadge = response.goldRetBadge;
          this.dalSendBadge = response.dalSendBadge;
          this.dalRetBadge = response.dalRetBadge;
          this.panSendBadge = response.panSendBadge;
          this.panRetBadge = response.panRetBadge;
          this.BronzeSendBadge = response.bronzeSendBadge;
          this.nitricRetBadge = response.nitricRetBadge;
        });
        this.jobTaskService.getBatchCount(params.id);

        this.jobTaskService.testObserble().subscribe((response) => {
          this.btnControl = response;
          //this can also be done
          // if(this.btnControl === true){
          //   this.oneJobData.status_id = 100;
          // }
        });
        //
        // this.billService.getTotalGoldQuantity(this.id).subscribe((response) => {
        //   this.FGWt = response.data.data;
        // });

        this.jobTaskForm.patchValue({id: params.id});


        this.jobTaskService.getUpdatedSavedJobs();
        this.jobTaskService.getUpdatedFinishedJobs();
        this.karigarhData = this.jobService.getAllKarigarhs();
        this.jobService.getKarigarhUpdateListener().subscribe((response) => {
          this.karigarhData = response;
        });
        this.jobTaskService.getSavedJobsUpdateListener().subscribe((response) => {
          this.savedJobsData = response;
          const index = this.savedJobsData.findIndex(x => x.id === this.id);
          // if (index === -1){
          //   this.jobTaskService.getFinishedJobsUpdateListener().subscribe((response) => {
          //     this.savedJobsData = response;
          //     const index = this.savedJobsData.findIndex(x => x.id === this.id);
          //     this.oneJobData = this.savedJobsData[index];
          //     this.jobTaskForm.patchValue({id: this.oneJobData.id});
          //     this.jobTaskForm.value.id = this.oneJobData.id;
          //     this.job_number = this.oneJobData.job_number;
          //     const index1 = this.karigarhData.findIndex(x => x.id === this.oneJobData.karigarh_id);
          //     this.karigarhName = this.karigarhData[index1].person_name;
          //   });
          // }
          // else{
          //   this.oneJobData = this.savedJobsData[index];
          //   this.jobTaskForm.patchValue({id: this.oneJobData.id});
          //   this.job_number = this.oneJobData.job_number;
          // }
          // if (this.karigarhData && this.oneJobData){
          //   const index = this.karigarhData.findIndex(x => x.id === this.oneJobData.karigarh_id);
          //   this.karigarhName = this.karigarhData[index].person_name;
          // }
        });
        // this.userData = JSON.parse(localStorage.getItem('user'));
        // this.orderService.getMaterialUpdateListener().subscribe((response) => {
        //   this.materialList = response;
        //   const index = this.materialList.findIndex(x => x.id === this.oneJobData.material_id);
        //   const materialData = this.materialList[index];
        //   this.jobTaskForm.patchValue({material_name: materialData.material_name , size: this.oneJobData.size});
        // });
        // this.karigarhData = this.jobService.getAllKarigarhs();
        // this.jobService.getKarigarhUpdateListener().subscribe((response) => {
        //   this.karigarhData = response;
        //
        //   const index = this.karigarhData.findIndex(x => x.id === this.oneJobData.karigarh_id);
        //   this.karigarhName = this.karigarhData[index].person_name;
        //
        // });
        // if (this.oneJobData){
        //   // const index = this.karigarhData.findIndex(x => x.id === this.oneJobData.karigarh_id);
        //   // this.karigarhName = this.karigarhData[index].person_name;
        // }
        this.jobTaskService.getTotalData();
        this.jobTaskService.getTotal().subscribe((response) => {
          this.totalData = response.data;
          for (let i = 1; i <= 8; i ++){
            const index = this.totalData.findIndex(x => x.id === i);
            if (index >= 0)
            {
              this.tempTotalData[i - 1] = this.totalData[index].total;
            }
            else{
              this.tempTotalData[i - 1] = 0;
            }
          }
        });
        this.jobTaskService.getTotalDataUpdateListener().subscribe((response) => {
          this.totalData = response;
          for (let i = 1; i <= 8; i ++){
            const index = this.totalData.findIndex(x => x.id === i);
            if (index >= 0)
            {
              this.tempTotalData[i - 1] = this.totalData[index].total;
            }
            else{
              this.tempTotalData[i - 1] = 0;
            }
          }
        });
        this.jobTaskService.getJobTransactionDataUpdateListener().subscribe((response) => {
          this.jobTransactionData = response;
        });
        this.jobTaskService.getAllTransactions(this.id).subscribe((response) => {
          this.jobTransactionData = response.data;
        });


      });
    });

    this.jobTaskService.testObserble().subscribe((response) => {
      this.btnControl = response;
    });
    // this.karigarhData = this.jobService.getAllKarigarhs();
    this.FGWt = 0;
    // this. jobTaskService.getBadgeValue().subscribe((response) => {
    //   let index = response.findIndex(x => x.id === this.id);
    //   if (index === -1){
    //     this.goldSendBadge = 1;
    //   }
    //   else{
    //     this.goldSendBadge = response[index].GS;
    //   }
    // });




    // this.FGWt = this.billService.FGWt;


  }

  printDivStyle = {
    table: {'border-collapse': 'collapse', width : '40%', border: '1px solid black'},
    label: {width: '80%'},
    h1 : {color: 'black'},
    // h2 : {border: 'solid 1px'},
    h2 : {border: '1px solid black'},
    td: {border: '1px solid black', margin: '0px', padding: '5px', width : '30%'},
    // th: {border: '1px solid red'}
  };


  ngOnInit(): void {
    this.showTransactionDiv = true;





    // this.billService.getTotalGoldQuantityDataSubUpdateListener().subscribe((response) => {
    //   this.FGWt = response;
    // });






  }
}
