import { Component, OnInit } from '@angular/core';
import {StockService} from '../../services/stock.service';
import {Stock} from '../../models/stock.model';
import {BillService} from '../../services/bill.service';
import {BillMaster} from '../../models/billMaster.model';
import {BillDetail} from '../../models/billDetail.model';
import {StorageMap} from '@ngx-pwa/local-storage';
import {CustomerService} from '../../services/customer.service';
import {Customer} from '../../models/customer.model';
import toWords from 'number-to-words/src/toWords';
import Swal from 'sweetalert2';
import {DatePipe, formatDate} from '@angular/common';
import {AgentService} from '../../services/agent.service';
import {Agent} from '../../models/agent.model';
import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-stock-bill',
  templateUrl: './stock-bill.component.html',
  styleUrls: ['./stock-bill.component.scss']
})
export class StockBillComponent implements OnInit {
  stockList: Stock[];
  billMasterData: BillMaster;
  // billDetailsData: BillDetail[]  = [];
  billDetailsData: BillDetail[] = [];
  total92Gold: number;
  totalGold: number;
  totalQuantity: number;
  totalCost: number;
  originalCost: number;
  searchTag: string;
  // agentName: string;
  stockBillContainer: any;
  billView = true ;
  billCreated = false;
  customerData: Customer[];
  selectedCustomerData: Customer = null ;
  selectedAgentData: Agent;
  minDate = new Date(2010, 11, 2);
  maxDate = new Date(2021, 3, 2);
  bill_date: string;
  pipe = new DatePipe('en-US');
  agentData: Agent[]  ;
  tempStockList: Stock[];
  date = new Date();

  mv: number;
  discount: number;
  discountPercentage: number;

  page: number;
  pageSize: number;
  p = 1;
  settingsInfo: any;
  showDiscountEdit: boolean;

  // now = Date.now();

  constructor(private customerService: CustomerService, private  stockService: StockService, private  billService: BillService, private  storage: StorageMap, private agentService: AgentService, private http: HttpClient) {
    this.agentData = this.agentService.getAgentList();
    this.customerData = this.customerService.getCustomers();
    // this.selectedCustomerData = this.customerData[0];
    this.selectedAgentData = this.agentData[0];
    this.stockList = this.stockService.getStockList();
    this.date = new Date();

    this.http.get('assets/settings.json').subscribe((data: any) => {
      this.settingsInfo = data;
      this.showDiscountEdit = this.settingsInfo.showDiscountEdit;
    });

    // this.selectedCustomerData.bill_date = this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
    // if(this.billDetailsData != null){
    //   for (let i = 0; i < this.billDetailsData.length; i++ ) {
    //     const index = this.stockList.findIndex(x => x.id === this.billDetailsData[i].id);
    //     if(index === -1){
    //       this.stockList[index].isSet = false;
    //     }
    //     else{
    //       this.stockList[index].isSet = true;
    //     }
    //   }
    // }
    // else{
    //   for (let i = 0; i < this.stockList.length; i++ ) {
    //     this.stockList[i].isSet = false;
    //   }
    // }


    // if (this.stockList){
    //   this.stockList.forEach(function(value) {
    //     value.isSet = false;
    //     const x = value.tag.split('-');
    //     // tslint:disable-next-line:radix
    //     value.tag = (parseInt(x[1]).toString(16) + '-' + parseInt(x[2]).toString(16) + '-' + parseInt(x[3]));
    //   });
    // }
    this.tempStockList = this.stockList.filter(x => x.agent_id === 2);
    // this.tempStockList = this.stockList;
    // for (let i = 0; i < this.billDetailsData.length; i++ ) {
    //   const index = this.tempStockList.findIndex(x => x.id === this.billDetailsData[i].id);
    //   if(index === -1){
    //     this.tempStockList[index].isSet = false;
    //   }
    //   else{
    //     this.tempStockList[index].isSet = true;
    //   }
    // }

    this.page = 1;
    this.pageSize = 10;
    this.storage.get('stockBillContainer').subscribe((stockBillContainer: any) => {
      if (stockBillContainer){
        if (stockBillContainer.stockBillDetailsData) {
          this.billDetailsData = stockBillContainer.stockBillDetailsData;
        }
        if (stockBillContainer.stockBillCustomer){
          this.selectedCustomerData  = stockBillContainer.stockBillCustomer;
        }

        for (let i = 0; i < this.billDetailsData.length; i++ ){
          const index = this.stockList.findIndex(x => x.id === this.billDetailsData[i].id);
          // this.stockList[index].isSet = true;
          // this.stockList[i].total = Number(this.stockList[i].gold);
          // this.stockList[i].cost = this.stockList[i].amount;

          const pure_gold = parseFloat(((this.billDetailsData[i].total * 92) / 100).toFixed(3));
          this.total92Gold = this.total92Gold + Number(this.billDetailsData[i].total);
          this.totalGold = this.totalGold + Number(pure_gold);
          this.totalQuantity = this.totalQuantity + Number(this.billDetailsData[i].quantity);
          this.totalCost = this.totalCost + this.billDetailsData[i].amount;
        }
      }
    });
  }
  printDivStyle = {
    table: {'border-collapse': 'collapse', 'width' : '100%' },
    label:{'width': '100%'},
    th: {border: '1px  solid black' , 'fontSize' : 'small'}
  };


  ngOnInit(): void {
    this.total92Gold = 0;
    this.totalGold = 0;
    this.totalQuantity = 0;
    this.totalCost = 0;
    this.originalCost = 0;
    this.discount = 0;
    this.billCreated = false;



    // this.bill_date = '20/11/2020';
    // this.bill_date = '2020-11-20';


    this.billMasterData = {
      billNumber : null,
      customerId : 0,
      agent_id: 0,
      discount: 0,
      billDate: '0',
    };

    this.stockService.getStockUpdateListener().subscribe((response) => {
      this.stockList = response;
      // this.stockList.forEach(function(value) {
      //   value.isSet = false;
      //   const x = value.tag.split('-');
      //   // tslint:disable-next-line:radix
      //   value.tag = (parseInt(x[1]).toString(16) + '-' + parseInt(x[2]).toString(16) + '-' + parseInt(x[3]));
      // });
      this.tempStockList = this.stockList.filter(x => x.agent_id === 2);


      this.storage.get('stockBillContainer').subscribe((stockBillContainer: any) => {
        if (stockBillContainer) {
          this.total92Gold = 0;
          this.totalGold = 0;
          this.totalQuantity = 0;
          this.totalCost = 0;
          this.originalCost = 0;
          if  (stockBillContainer.stockBillDetailsData != null) {
            this.billDetailsData = stockBillContainer.stockBillDetailsData;
            for (let i = 0; i < this.billDetailsData.length; i++ ){
              const index = this.stockList.findIndex(x => x.id === this.billDetailsData[i].id);
              this.stockList[index].isSet = true;
              const pure_gold = parseFloat((((this.billDetailsData[i].total) * 92) / 100).toFixed(3));
              this.total92Gold = this.total92Gold + Number(this.billDetailsData[i].total);
              this.totalGold = this.totalGold + Number(pure_gold);
              this.totalQuantity = this.totalQuantity + Number(this.billDetailsData[i].quantity);
              // this.totalCost = this.totalCost + this.billDetailsData[i].amount;
              this.originalCost = this.originalCost + this.billDetailsData[i].amount;
            }
          }

          if (stockBillContainer.stockBillCustomer){
            this.selectedCustomerData =  stockBillContainer.stockBillCustomer;

          }else{
            this.selectedCustomerData = this.customerData[0];

          }


        }
      }, (error) => {
      });
      // localStorage.removeItem('stockBillContainer');

    });

    this.customerData = this.customerService.getCustomers();
    // this.agentData = this.agentService.getAgentList();
    this.customerService.getCustomerUpdateListener()
      .subscribe((customers: Customer[]) => {
        this.customerData = customers;
        this.selectedCustomerData = this.customerData[0];
        // this.selectedCustomerData.bill_date = '2010-11-02';
        this.selectedCustomerData.bill_date = this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
      });

    this.agentService.getAgentUpdateListener()
      .subscribe((response) => {
        this.agentData = response;
        this.selectedAgentData = this.agentData[0];
        if(this.agentData){
          this.getStockListByAgentName(this.agentData[0]);
        }
      });
    this.agentData = this.agentService.getAgentList();




    // this.stockList = this.stockService.getStockList();
    // this.storage.get('stockBillContainer').subscribe((stockBillContainer: any) => {
    //   if (stockBillContainer) {
    //     this.billDetailsData = stockBillContainer.stockBillDetailsData;
    //     // this.billDetailsData.forEach(function(value) {
    //     //
    //     // });
    //   }
    // }, (error) => {
    // });
  }

  convert(value){
    return toWords(value);
  }

  getDiscount(){

    this.discount = (this.originalCost * this.discountPercentage)/100 ;

    this.totalCost = this.originalCost - this.discount;
  }

  stockSelectionForBill(item) {
    const index = this.billDetailsData.findIndex(x => x.id === item.id);
    if (index === -1){

      item.total = item.gold + this.selectedCustomerData.mv * Number(item.quantity);
      item.cost = item.amount;
      item.mv = this.selectedCustomerData.mv;
      item.price =  item.amount / item.quantity;

      item.pure_gold = parseFloat(((item.total * 92) / 100).toFixed(3));


      this.total92Gold = this.total92Gold + Number(item.total);
      this.totalGold = this.totalGold + Number(item.pure_gold);
      this.totalQuantity = this.totalQuantity + Number(item.quantity);
      // this.totalCost = this.totalCost + item.amount;
      this.originalCost = this.originalCost + item.amount;








      this.billDetailsData.push(item);

      item.isSet = true;
    }

    // this.billDetailsData.push(item);


    // item.total = item.gold;
    // item.cost = item.amount;

    //
    // item.pure_gold = parseFloat(((item.total * 92) / 100).toFixed(3));
    //
    // this.total92Gold = this.total92Gold + Number(item.total);
    // this.totalGold = this.totalGold + Number(item.pure_gold);
    //
    // // this.billDetailsData.push(item);

    this.stockBillContainer = {
        stockBillDetailsData: this.billDetailsData,
        stockBillCustomer: this.selectedCustomerData,
      };
    this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    });
  }

  clearStorage(){

    // this.billDetailsData = [];
    // localStorage.removeItem('stockBillContainer');
    // for (let i = 0 ; i < this.stockList.length ; i ++){
    //   this.stockList[i].isSet = false;
    // }
    // this.selectedCustomerData = this.customerData[0];
    // this.selectedCustomerData.bill_date = this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
    //
    // this.stockBillContainer = {
    //   stockBillDetailsData: null,
    //   stockBillCustomer: null,
    // };
    // this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    // });
    // this.billDetailsData = [];
    // this.selectedCustomerData = null;


    this.billDetailsData = [];
    this.stockBillContainer = null;
    for(let i = 0 ; i < this.tempStockList.length ; i ++){
        this.tempStockList[i].isSet = false;
      }
    this.storage.delete('stockBillContainer').subscribe();

  }



  removeFromStockBillEntry(item){
    const index = this.billDetailsData.findIndex(x => x.id === item.id);
    const stockListIndex = this.stockList.findIndex(x => x.id === item.id);
    this.total92Gold = this.total92Gold - Number(item.total);
    this.totalGold = this.totalGold - Number(item.pure_gold);
    this.totalQuantity = this.totalQuantity - Number(item.quantity);
    // this.totalCost = this.totalCost - item.amount;
    this.originalCost = this.originalCost - item.amount;

    this.billDetailsData.splice(index, 1);
    this.stockList[stockListIndex].isSet = false;
    this.stockBillContainer = {
        stockBillDetailsData: this.billDetailsData,
        stockBillCustomer: this.selectedCustomerData,
      };
    this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    });
  }

  stockBillGenerate(){
    Swal.fire({
      title: 'Do you want to generate bill ?',
      text: 'Bill  will be generated',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, save it!',
      cancelButtonText: 'No, cancel it'
    }).then((result) => {
      this.billMasterData = {
        billNumber : null,
        customerId : this.selectedCustomerData.id,
        agent_id: this.billDetailsData[0].agent_id,
        discount: this.discount,
        billDate: this.selectedCustomerData.bill_date,
      };

      this.billService.saveBillMaster(this.billMasterData, this.billDetailsData).subscribe((response) => {
        if (response.data){
          Swal.fire({
            title: 'Saved',
            text: 'Bill  has been generated',
            icon: 'success',
          });
          this.billMasterData.bill_number = response.data.bill_number;
          for(let i = 0; i < this.billDetailsData.length; i++){
            const index = this.tempStockList.findIndex(x => x.id === this.billDetailsData[i].id);
            this.tempStockList.splice(index,1);
          }

          // this.billDetailsData = [];
          this.stockBillContainer = null;
          this.storage.delete('stockBillContainer').subscribe();
          this.stockService.getUpdatedStockList();
          this.billCreated = true;
        }
      });
    });
    // this.billService.testBillSave(this.billDetailsData).subscribe();
  }

  backBtn(){
    this.billView = true;
    this.billCreated = false;

    this.tempStockList = this.stockList.filter(x => x.agent_id === this.selectedAgentData.id);
    // this.defaultAgentSelection();
    if (this.billMasterData.bill_number){
    //   window.location.href = '/stockBill';
      this.billDetailsData = [];
      this.billMasterData = {};
      // customer is not initalising
      this.selectedCustomerData = this.customerData[0];

      this.selectedCustomerData.bill_date = this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
      this.storage.delete('stockBillContainer').subscribe();
    }

  }
  customerSelected(data){
    data.bill_date = this.selectedCustomerData.bill_date;
    this.selectedCustomerData = data;
    this.stockBillContainer = {
      stockBillDetailsData: this.billDetailsData,
      stockBillCustomer: this.selectedCustomerData,
    };
    this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    });
    // this.storage.get('stockBillContainer').subscribe((stockBillContainer: any) => {
    // });


  }

  getStockListByAgentName(item){

    // this.stockList('false').fill();
    // this.selectedAgentData = item;
    this.tempStockList = this.stockList.filter(x => x.agent_id === item.id);
    // this.tempStockList = this.stockList.filter(x => x.agent_id === item);
    if (this.billDetailsData.length > 0){
      for(let i = 0; i < this.tempStockList.length; i++ ) {
        const index = this.billDetailsData.findIndex(x => x.id === this.tempStockList[i].id);
        if(index === -1){
          this.tempStockList[i].isSet = false;
        }
        else{
          this.tempStockList[i].isSet = true;
        }

      }
    }


  }

  selectDate(){

    // const date =  item.getFullYear() + '-' + parseInt(String(item.getMonth() + 1)) + '-' + item.getDate();
    const date =  this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
    this.selectedCustomerData.bill_date = date;
    this.stockBillContainer = {
      stockBillDetailsData: this.billDetailsData,
      stockBillCustomer: this.selectedCustomerData,
    };
    this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    });
    // }
  // testLoop(){
  //   this.billDetailsData.forEach(function(value){
  //     const index = this.tempStockList.findIndex(x => x.id === value.id);
    //   });
  }
  defaultAgentSelection(){
    // return this.agentData[0] ;
  }
  ViewBill(){
    this.billView = false;
    const date =  this.date.getFullYear() + '-' + (this.date.getMonth() + 1) + '-' + this.date.getDate();
    this.selectedCustomerData.bill_date = date;
    this.stockBillContainer = {
      stockBillDetailsData: this.billDetailsData,
      stockBillCustomer: this.selectedCustomerData,
    };
    this.storage.set('stockBillContainer', this.stockBillContainer).subscribe(() => {
    });
    this.discountPercentage = this.stockBillContainer.stockBillCustomer.discount;
    this.totalCost =0;
    this.discount =0;
    this.originalCost = 0;
    for(let i = 0; i < this.stockBillContainer.stockBillDetailsData.length; i++){
      // this.totalCost = this.totalCost + this.stockBillContainer.stockBillDetailsData[i].amount;
      this.originalCost = this.originalCost + this.stockBillContainer.stockBillDetailsData[i].amount;
    }
    this.discount = (this.originalCost * this.discountPercentage)/100 ;

    // this.totalCost = this.totalCost - this.discount;
    this.totalCost = this.originalCost - this.discount;

  }
}
