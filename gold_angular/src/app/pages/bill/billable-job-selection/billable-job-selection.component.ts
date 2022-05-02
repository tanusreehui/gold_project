import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {OrderBillService} from '../../../services/order-bill.service';
import {HttpClient} from '@angular/common/http';
import {formatDate} from '@angular/common';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-billable-job-selection',
  templateUrl: './billable-job-selection.component.html',
  styleUrls: ['./billable-job-selection.component.scss']
})
export class BillableJobSelectionComponent implements OnInit {
  printableBill: {billMaster?: any, billDetails?: any[]};
  billMaster: {billDate?: any, customerId?: number, orderMasterId?: number, agentId?: number, discount?: number} = {};
  billDetails: any[] = [];
  bill: {master?: any, details?: any} = {};
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

    // tslint:disable-next-line:prefer-const only-arrow-functions
    this.billDetails = this.proformaInvoice.job_details.map(function(a) {
      return {
        jobMasterId: a.job_master_id,
        size: a.size,
        grossWeight: a.gross_weight,
        materialId: a.material.id,
        totalGinne: a.guinea_gold,
        lcRate: a.price,
        pureGold: a.fine_gold,
        quantity: a.quantity,
        mv: 0
      };
    });
    this.bill.master = this.billMaster;
    this.bill.details = this.billDetails;
    Swal.fire({
      title: 'Do you want to generate the bill?',
      text: 'Bill  will be generated',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, generate it!',
      cancelButtonText: 'No, cancel it'
    }).then((result) => {
      // tslint:disable-next-line:max-line-length
      this.orderBillService.saveBillMaster({master: this.bill.master, details: this.bill.details}).subscribe((response: {success: boolean, message: string, data: any}) => {
        this.printableBill = response.data;
        this.proformaInvoice = [];
        Swal.fire(
          'Success',
           'Bill Generated',
          'success'
        );

      }, error => {
        Swal.fire(
          'Error',
          'Bill Generation Error',
          'error'
        );
      });
    });
  }
}
