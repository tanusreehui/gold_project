import { Component, OnInit } from '@angular/core';
import {environment} from "../../../../environments/environment";
import {ActivatedRoute} from "@angular/router";
import {JobMaster} from "../../../models/jobMaster.model";
import {FormControl} from "@angular/forms";
import {JobService} from "../../../services/job.service";

export interface Record {
  material_name: string;
  user_name: string;
  task_name: string;
  material_quantity: number;
  bill_percentage: number;
  bill_quantity: number
}

export interface JobTask {
  records: Record[];
  actual_total: number;
  bill_total: number;
}

@Component({
  selector: 'app-job-report',
  templateUrl: './job-report.component.html',
  styleUrls: ['./job-report.component.scss']
})
export class JobReportComponent implements OnInit {
  showDeveloperDiv=true;
  isProduction = environment.production;
  savedJobsList: JobMaster[];
  finishedJobList: JobMaster[];
  public searchTerm: string;
  filter = new FormControl('');
  page: number;
  pageSize = 10;
  p = 1;

  jobSummaryForBill: { gold_send: JobTask, gold_return: JobTask, pan_send: JobTask, pan_return: JobTask, nitric_return: JobTask, dal_send: JobTask, dal_return: JobTask, bronze_send: JobTask,job_master: JobMaster, bill_gold_total:number};
  showDetail = true;
  isFinishedJobs = true;

  constructor(private route: ActivatedRoute, private jobService: JobService) {
    this.route.data.subscribe((response: any) => {
      console.log(response.jobReport.allJobs);
      this.savedJobsList = response.jobReport.allJobs.savedJobs.data;
      this.finishedJobList = response.jobReport.allJobs.finishedJobs.data;
    });
  }

  ngOnInit(): void {
  }

  fetchJobSummaryForBill(item: any) {
    this.jobService.fetchJobSummaryForBill(item.id).subscribe(response => {
      this.jobSummaryForBill = response.data;
      console.log(this.jobSummaryForBill);
    });
  }
}
