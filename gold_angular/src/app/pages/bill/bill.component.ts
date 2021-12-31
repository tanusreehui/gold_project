import { Component, OnInit } from '@angular/core';
import {BillService} from '../../services/bill.service';
import {FinishedJobs} from '../../models/finishedJobs';
import {OrderDetail} from '../../models/orderDetail.model';
import {JobService} from '../../services/job.service';
import {FormControl} from '@angular/forms';
import {environment} from '../../../environments/environment';
import {ActivatedRoute} from '@angular/router';

@Component({
  selector: 'app-bill',
  templateUrl: './bill.component.html',
  styleUrls: ['./bill.component.scss']
})
export class BillComponent implements OnInit {
  public searchTerm: string;
  finshedJobs: FinishedJobs[] = [];
  orderDetails: OrderDetail[];
  isProduction = environment.production;

  filter = new FormControl('');
  page = 1;
  pageSize = 15;
  p = 1;
  showDeveloperDiv: true;
  billableCustomers: any;

  constructor(private route: ActivatedRoute, private  billService: BillService , private  jobService: JobService) {
    this.route.data.subscribe((response: any) => {
      this.billableCustomers = response.bill.billableCustomers.data;
    });
  }

  ngOnInit(): void {
    this.billService.getFinishedJobsSubUpdateListener().subscribe((finishedJobs) => {
       this.finshedJobs = finishedJobs;
    });
    this.finshedJobs = this.billService.getFinishedJobs();

  }
}
