import { Component, OnInit } from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {BillService} from '../../../services/bill.service';
import {OrderDetail} from '../../../models/orderDetail.model';
import {JobMaster} from '../../../models/jobMaster.model';
import {BillMaster} from '../../../models/billMaster.model';
import {BillDetail} from '../../../models/billDetail.model';
import {toNumbers} from '@angular/compiler-cli/src/diagnostics/typescript_version';
import {toInteger} from '@ng-bootstrap/ng-bootstrap/util/util';
import {FinishedJobs} from '../../../models/finishedJobs';
// import {Location} from '@angular/common';
import toWords from 'number-to-words/src/toWords.js';
import {StockService} from '../../../services/stock.service';
import {AgentService} from '../../../services/agent.service';
import {JobService} from '../../../services/job.service';
import Swal from "sweetalert2";
import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-bill-job-master-details',
  templateUrl: './bill-job-master-details.component.html',
  styleUrls: ['./bill-job-master-details.component.scss']
})
export class BillJobMasterDetailsComponent implements OnInit {

  finishedJobData: JobMaster[];
  // billJobData: JobMaster[] = [];
  billMasterData: BillMaster;
  // billMasterData : Array<{order_master_id: number, order_number: string}> = [];
  billDetailsData: BillDetail[] = [];
  showBill = false;
  billCreated = false;
  total92Gold: number;
  totalGold: number;
  totalQuantity: number;
  totalCost: number;
  discount: number;
  discountPercentage: number;
  originalCost: number;
  mv: number;
  x: FinishedJobs[];
  settingsInfo: any;
  showDiscountEdit: boolean;
  // public user = JSON.parse(localStorage.getItem('user'));

  constructor(private  route: ActivatedRoute, private billService: BillService , private stockService: StockService , private agentService: AgentService , private  jobService: JobService , private http: HttpClient) {
    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      this.showDiscountEdit = this.settingsInfo.showDiscountEdit;
    });
  }

  printDivStyle = {
    printBillDiv: {marginRight : '3px', marginLeft : '3px', marginTop : '5px'},
    table: {'border-collapse': 'collapse', width : '100%'},
    label: {width: '100%'},
    th: {border: '1px  solid black'}
  };

  ngOnInit(): void {
    this.total92Gold = 0;
    this.totalGold = 0;
    this.totalQuantity = 0;
    this.totalCost = 0;
    this.originalCost = 0;
    this.discountPercentage = 0;
    this.discount = 0;
    this.showBill = false;
    this.billCreated = false;
    this.mv = 0;
    this.route.params.subscribe(params => {
      this.billService.getFinishedJobData(params.id);
    });

    this.billService.getfinishedJobDataSubUpdateListener()
      .subscribe((details: JobMaster[]) => {
        this.finishedJobData = details;
        this.mv = (this.finishedJobData[0].cust_mv + this.finishedJobData[0].product_mv) ;
        console.log('finishedJobData', this.finishedJobData);
      });
  }

  convert(value){
    return toWords(value);
  }

  selectionForBill(data) {
    const index = this.billDetailsData.findIndex(x => x.id === data.id);
    if (index >= 0) {
      this.total92Gold = this.total92Gold - Number(data.total);
      this.totalGold = this.totalGold - Number(data.pure_gold);
      this.totalQuantity = this.totalQuantity - Number(data.quantity);
      // this.totalCost = this.totalCost - Number(data.cost);
      this.originalCost = this.originalCost - Number(data.cost);
      this.billDetailsData.splice(index, 1);
    } else {
      this.billService.getTotalGoldQuantity(data.id).subscribe((response: {success: number, data: any}) => {
        // data.total = parseFloat(response.data.data.toFixed(3));
        // const tempTotal = parseFloat(response.data.data.toFixed(3)) + this.user.mv;
        data.total = parseFloat(response.data.data.toFixed(3));
        data.pure_gold = parseFloat(((data.total * 92) / 100).toFixed(3));
        data.cost = data.price * data.quantity;
        this.total92Gold = this.total92Gold + Number(data.total);
        this.totalGold = this.totalGold + Number(data.pure_gold);
        this.totalQuantity = this.totalQuantity + Number(data.quantity);
        // this.totalCost = this.totalCost + Number(data.cost);
        this.originalCost = this.originalCost + Number(data.cost);
        data.mv = this.mv;
        this.billDetailsData.push(data);
      });

    }
    console.log('billDetailsData', this.billDetailsData);
  }

  viewBill(){
    this.showBill = true;
    const x = new Date();
    if (this.billDetailsData[0]) {
      this.billMasterData = {
        order_master_id: this.billDetailsData[0].order_master_id,
        orderNumber: this.billDetailsData[0].orderNumber,
        personName: this.billDetailsData[0].billing_name,
        address1: this.billDetailsData[0].address1,
        mobile1: this.billDetailsData[0].mobile1,
        pin: this.billDetailsData[0].pin,
        area: this.billDetailsData[0].area,
        city: this.billDetailsData[0].city,
        state: this.billDetailsData[0].state,
        po: this.billDetailsData[0].po,
        orderDate: this.billDetailsData[0].date_of_order,
        karigarhId: this.billDetailsData[0].karigarh_id,
        customerId: this.billDetailsData[0].customer_id,
        agent_id: this.billDetailsData[0].agent_id,
        billDate: x.getFullYear() + '-' + parseInt(String(x.getMonth() + 1)) + '-' + x.getDate(),
        // discount: (this.billDetailsData[0].discount / 100) * this.originalCost
        discount: (this.billDetailsData[0].discount_percentage / 100) * this.originalCost
      };
      // this.discount = (this.billDetailsData[0].discount / 100) * this.originalCost;
      this.discount = (this.billDetailsData[0].discount_percentage / 100) * this.originalCost;
      // this.discountPercentage = this.billDetailsData[0].discount;
      this.discountPercentage = this.billDetailsData[0].discount_percentage;
      this.totalCost = this.originalCost - this.discount;
    }
  }

  getDiscount(){
    // this.discountPercentage = this.billDetailsData[0].discount;
    // this.billDetailsData[0].discount = this.discountPercentage;
    this.billDetailsData[0].discount_percentage = this.discountPercentage;
    // this.discount = (this.billDetailsData[0].discount / 100) * this.originalCost;
    this.discount = (this.billDetailsData[0].discount_percentage / 100) * this.originalCost;
    console.log(this.discount);
    this.totalCost = this.originalCost - this.discount;
    this.billMasterData.discount = this.discount;
  }

  generateBill() {
    Swal.fire({
      title: 'Do you want to generate the bill?',
      text: 'Bill  will be generated',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, generate it!',
      cancelButtonText: 'No, cancel it'
    }).then((result) => {
      if (result.value){
        const x = new Date();

        // if (this.billDetailsData[0]) {
        //   this.billMasterData = {
        //     order_master_id: this.billDetailsData[0].order_master_id,
        //     orderNumber: this.billDetailsData[0].orderNumber,
        //     personName: this.billDetailsData[0].user_name,
        //     address1: this.billDetailsData[0].address1,
        //     mobile1: this.billDetailsData[0].mobile1,
        //     pin: this.billDetailsData[0].pin,
        //     area: this.billDetailsData[0].area,
        //     city: this.billDetailsData[0].city,
        //     state: this.billDetailsData[0].state,
        //     po: this.billDetailsData[0].po,
        //     orderDate: this.billDetailsData[0].date_of_order,
        //     karigarhId: this.billDetailsData[0].karigarh_id,
        //     customerId: this.billDetailsData[0].customer_id,
        //     agent_id: this.billDetailsData[0].agent_id,
        //     billDate: x.getFullYear() + '-' + parseInt(String(x.getMonth() + 1)) + '-' + x.getDate(),
        //     discount: (this.billDetailsData[0].discount / 100) * this.totalCost
        //   };
        // }
        this.billService.saveBillMaster(this.billMasterData, this.billDetailsData).subscribe((response) => {
          this.billMasterData = {
            order_master_id: this.billDetailsData[0].order_master_id,
            orderNumber: this.billDetailsData[0].order_number,
            personName: this.billDetailsData[0].billing_name,
            address1: this.billDetailsData[0].address1,
            mobile1: this.billDetailsData[0].mobile1,
            pin: this.billDetailsData[0].pin,
            area: this.billDetailsData[0].area,
            city: this.billDetailsData[0].city,
            state: this.billDetailsData[0].state,
            po: this.billDetailsData[0].po,
            orderDate: this.billDetailsData[0].date_of_order,
            karigarhId: this.billDetailsData[0].karigarh_id,
            customerId: this.billDetailsData[0].customer_id,
            billDate: x.getFullYear() + '-' + parseInt(String(x.getMonth() + 1)) + '-' + x.getDate(),
            // discount: this.billDetailsData[0].discount,
            discount: this.discount,
            billNumber: response.data.bill_number
          };
          this.discount = this.billMasterData.discount;
          // this.discountPercentage = this.billDetailsData[0].discount;
          this.totalCost = this.originalCost - this.discount;

          this.billService.getFinishedJobsCustomers();
          this.billService.getCompletedBillCustomers();
          this.agentService.getLatestDueByAgentListList();
          this.jobService.getFinishedJobList();
          this.jobService.getUpdatedFinishedJob();

          // this.stockService.getUpdatedStockRecord();
          this.showBill = true;
          this.billCreated = true;
          Swal.fire(
            'Generated',
            'Bill is generated',
            'success'
          );
        });
      }
      else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Bill is not generated',
          'error'
        );
      }

    });
  }


}
