import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {OrderBillService} from '../../../services/order-bill.service';
import {HttpClient} from '@angular/common/http';
import {formatDate} from '@angular/common';

@Component({
  selector: 'app-billable-job-selection',
  templateUrl: './billable-job-selection.component.html',
  styleUrls: ['./billable-job-selection.component.scss']
})
export class BillableJobSelectionComponent implements OnInit {
  billMaster: {billDate?: any, customerId?: number, orderMasterId?: number, agentId?: number, discount?: number} = {};
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
    this.orderBillService.fetchSettings().subscribe((data: any) => {
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
      // tslint:disable-next-line:only-arrow-functions
      this.totalGunieaGold = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.guinea_gold;
      }, 0);
      // tslint:disable-next-line:only-arrow-functions
      this.fineGold = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.fine_gold;
      }, 0);
      // tslint:disable-next-line:only-arrow-functions
      this.quantity = this.proformaInvoice.job_details.reduce(function(accumulator, currentValue) {
        return accumulator + currentValue.quantity;
      }, 0);
      // tslint:disable-next-line:only-arrow-functions
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

  createBill() {
    const billDate = new Date();
    this.billMaster.billDate = formatDate(billDate, 'yyyy-MM-dd', 'en');
    this.billMaster.customerId = this.proformaInvoice.customer.id;
    this.billMaster.orderMasterId = this.proformaInvoice.order_master.id;
    this.billMaster.agentId = this.proformaInvoice.order_master.agent_id;
    this.billMaster.discount = this.proformaInvoice.order_master.discount_percentage;
  }
}
