import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { HeaderComponent } from './pages/header/header.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';


import { MaterialModule } from './core/material.module';



import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';
import { HomeComponent } from './pages/home/home.component';

import { FlexLayoutModule } from '@angular/flex-layout';
import { PictureCarouselComponent } from './pages/home/picture-carousel/picture-carousel.component';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import { AuthComponent } from './pages/auth/auth.component';
import { LoadingSpinnerComponent } from './shared/loading-spinner/loading-spinner.component';
import {AuthInterceptorInterceptor} from './services/auth-interceptor.interceptor';
import { OwnerComponent } from './pages/owner/owner.component';
import {NgxPrintModule} from 'ngx-print';
import {Ng2SearchPipeModule} from 'ng2-search-filter';
import {NgxPaginationModule} from 'ngx-pagination';
import { SncakBarComponent } from './common/sncak-bar/sncak-bar.component';
import { ConfirmationDialogComponent } from './common/confirmation-dialog/confirmation-dialog.component';
import { LoaidngRippleComponent } from './shared/loaidng-ripple/loaidng-ripple.component';
import { LoaidngEllipsisComponent } from './shared/loaidng-ellipsis/loaidng-ellipsis.component';
import { LoaidngHourglassComponent } from './shared/loaidng-hourglass/loaidng-hourglass.component';
import { LoaidngRollerComponent } from './shared/loaidng-roller/loaidng-roller.component';
import { DateAdapter } from '@angular/material/core';
import { DateFormat } from './date-format';
import {NgSelectModule} from '@ng-select/ng-select';
import { ProductComponent } from './pages/product/product.component';
import {ShowHidePasswordModule} from 'ngx-show-hide-password';
import { CustomerComponent } from './pages/customer/customer.component';
import {EditInputComponent} from './pages/product/edit-input/edit-input.component';
import { VendorComponent } from './pages/vendor/vendor.component';
import { PurchaseComponent } from './pages/purchase/purchase.component';
import {PopoverModule} from 'ngx-smart-popover';
import {LogLevel, NgxFancyLoggerModule} from 'ngx-fancy-logger';
import { SaleComponent } from './pages/sale/sale.component';




@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    HomeComponent,
    PictureCarouselComponent,
    AuthComponent,
    LoadingSpinnerComponent,
    OwnerComponent,
    SncakBarComponent,
    ConfirmationDialogComponent,
    LoaidngRippleComponent,
    LoaidngEllipsisComponent,
    LoaidngHourglassComponent,
    LoaidngRollerComponent,
    ProductComponent,
    CustomerComponent,
    EditInputComponent,
    VendorComponent,
    PurchaseComponent,
    SaleComponent
  ],
    imports: [
        BrowserModule,
        AppRoutingModule,
        NgbModule,
        FormsModule,
        BrowserAnimationsModule,
        FontAwesomeModule,
        MaterialModule,
        FlexLayoutModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        NgxPrintModule,
        Ng2SearchPipeModule,
        NgxPaginationModule,
        NgSelectModule,
        ShowHidePasswordModule,
        PopoverModule,
        NgxFancyLoggerModule.forRoot({
          showTime: false,
          logLevel: LogLevel.WARNING,
          levelColor: {
            [LogLevel.ERROR]: 'brown'
          }
        })
    ],
  providers: [{provide: HTTP_INTERCEPTORS, useClass: AuthInterceptorInterceptor, multi: true},
              {provide: DateAdapter, useClass: DateFormat} ],
  bootstrap: [AppComponent]
})
export class AppModule {
  constructor(private dateAdapter: DateAdapter<Date>) {
    dateAdapter.setLocale('en-in'); // DD/MM/YYYY
  }
}
