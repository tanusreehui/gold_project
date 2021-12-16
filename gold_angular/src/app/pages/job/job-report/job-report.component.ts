import { Component, OnInit } from '@angular/core';
import {environment} from "../../../../environments/environment";
import {ActivatedRoute} from "@angular/router";
import {JobMaster} from "../../../models/jobMaster.model";

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
  constructor(private route: ActivatedRoute) {
    this.route.data.subscribe((response: any) => {
      console.log(response.jobReport.allJobs);
      this.savedJobsList = response.jobReport.allJobs.savedJobs.data;
      this.finishedJobsList = response.jobReport.allJobs.finishedJobs.data;
    });
  }

  ngOnInit(): void {
  }

}
