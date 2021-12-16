import { Component, OnInit } from '@angular/core';
import {environment} from "../../../../environments/environment";
import {ActivatedRoute} from "@angular/router";
import {JobMaster} from "../../../models/jobMaster.model";
import {FormControl} from "@angular/forms";
import {JobService} from "../../../services/job.service";

@Component({
  selector: 'app-job-report',
  templateUrl: './job-report.component.html',
  styleUrls: ['./job-report.component.scss']
})
export class JobReportComponent implements OnInit {
  showDeveloperDiv=true;
  isProduction = environment.production;
  savedJobsList: JobMaster[];
  finishedJobsList: JobMaster[];
  public searchTerm: string;
  filter = new FormControl('');
  page: number;
  pageSize: number;
  p = 1;
  constructor(private route: ActivatedRoute, private jobService: JobService) {
    this.route.data.subscribe((response: any) => {
      console.log(response.jobReport.allJobs);
      this.savedJobsList = response.jobReport.allJobs.savedJobs.data;
      this.finishedJobsList = response.jobReport.allJobs.finishedJobs.data;
    });
  }

  ngOnInit(): void {
  }

  fetchJobSummaryForBill(item: any) {
    this.jobService.fetchJobSummaryForBill(item.id).subscribe(response => {
      console.log(response);
    });
  }
}
