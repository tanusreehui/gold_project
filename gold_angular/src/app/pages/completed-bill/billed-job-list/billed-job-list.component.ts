import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {BillService} from '../../../services/bill.service';
import {FinishedJobs} from '../../../models/finishedJobs';
import {templateJitUrl} from '@angular/compiler';

@Component({
  selector: 'app-billed-job-list',
  templateUrl: './billed-job-list.component.html',
  styleUrls: ['./billed-job-list.component.scss']
})
export class BilledJobListComponent implements OnInit {
  billedJobList: FinishedJobs[];
  showReport = false;
  jobReport: any[];
  orderData: any;
  jobNumber: string;
  totalBilledGold: any;
  totalPureGold: any;
  testMath =  Math;

  constructor(private  route: ActivatedRoute, private billService: BillService) { }
  printDivStyle = {
    table: {'border-collapse': 'collapse', 'width' : '100%' },
    label:{ 'width': '100%'},
    th: {border: '1px  solid black' , 'fontSize' : 'small'}
  };

  ngOnInit(): void {
    this.showReport = false;
    this.route.params.subscribe(params => {
      this.billService.getBilledJobList(params.id);
      this.billService.getBilledJobListSubUpdateListener().subscribe((response)=>{
        this.billedJobList  = response;
      });
    });
  }
  getReport(item){
    this.totalBilledGold = 0;
    this.totalPureGold = 0;
    this.billService.getBilledJobReport(item.id).subscribe((response:{ success: number , data: any[], data2: any}) => {
       if(response.data){
         this.showReport = true;
         this.jobReport = response.data;
         this.orderData = response.data2;
         for (let i = 0; i < this.jobReport.length ; i++){
            this.totalBilledGold = this.totalBilledGold + this.jobReport[i].total;
         }
         this.totalPureGold = this.totalBilledGold * 0.92;
         this.jobNumber = item.job_number;
       }
     });
  }

}
