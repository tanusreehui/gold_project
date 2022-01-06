import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {OrderBillService} from "../../../services/order-bill.service";
import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-billable-job-selection',
  templateUrl: './billable-job-selection.component.html',
  styleUrls: ['./billable-job-selection.component.scss']
})
export class BillableJobSelectionComponent implements OnInit {
  jobList: any = [];
  orderMasterId: number;
  proformaInvoice: any = [];
  settingsInfo: any;
  showDiscountEdit: boolean;
  totalGunieaGold: number;
  fineGold: number;
  quantity: number;
  totalLC: number;
  constructor(private route: ActivatedRoute, private http: HttpClient, private orderBillService: OrderBillService) {
    this.route.params.subscribe((params: any) => {
      this.orderMasterId = params.id;
    });

    this.route.data.subscribe((response: any) => {
      this.jobList = response.billJobMasterResolver.billableJobs.data;
    });
    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      this.showDiscountEdit = this.settingsInfo.showDiscountEdit;
    });
  }

  ngOnInit(): void {
  }

  onCheckChange(event: any) {
    console.log(event.target.checked);
  }

  showBill() {
    const selectedJobs = this.jobList.filter((el) => el.isSelected).map((el) => el.jobId);
    this.orderBillService.fetchProformaInvoice(this.orderMasterId, selectedJobs).subscribe((response: any) => {
      this.proformaInvoice = response.data;
      this.totalGunieaGold = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.guinea_gold;
      }, 0);
      this.fineGold = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.fine_gold;
      }, 0);
      this.quantity = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.quantity;
      }, 0);
      this.totalLC = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + (currentValue.quantity * currentValue.price);
      }, 0);

    });
  }
  getSelectedJobCount(){
    const count = this.jobList.filter((obj) => obj.isSelected === true).length;
    return count;
  }
  getTotalLC(){

  }
}
