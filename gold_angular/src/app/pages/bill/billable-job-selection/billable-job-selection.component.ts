import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-billable-job-selection',
  templateUrl: './billable-job-selection.component.html',
  styleUrls: ['./billable-job-selection.component.scss']
})
export class BillableJobSelectionComponent implements OnInit {
  jobList: any = [];
  constructor(private route: ActivatedRoute) {
    this.route.data.subscribe((response: any) => {
      this.jobList = response.billJobMasterResolver.billableJobs.data;
    });
  }

  ngOnInit(): void {
  }

}
