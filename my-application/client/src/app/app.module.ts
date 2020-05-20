import { BrowserModule } from '@angular/platform-browser';
import { NgModule, APP_INITIALIZER, CUSTOM_ELEMENTS_SCHEMA, Injector } from '@angular/core';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HttpClientModule, HttpClient, HTTP_INTERCEPTORS } from '@angular/common/http';
import { NgxSpinnerModule } from "ngx-spinner";
import { NgxMaskModule, IConfig } from 'ngx-mask';
import { TranslateModule, TranslateLoader, TranslateService } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { SidebarModule } from 'ng-sidebar';
import { MatSortModule } from '@angular/material/sort';
import { MatPaginatorModule } from '@angular/material/paginator';
import { CookieService } from 'ngx-cookie-service';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatInputModule } from '@angular/material/input';

import { polyfill as keyboardEventKeyPolyfill } from 'keyboardevent-key-polyfill';
import { TextInputAutocompleteModule } from 'angular-text-input-autocomplete';
keyboardEventKeyPolyfill();


// export const options: Partial<IConfig> | (() => Partial<IConfig>);

import { NgSelectModule } from '@ng-select/ng-select';
import { ToastrModule } from 'ngx-toastr';


// CUSTOM IMPORTS
import { ItemComponent } from './item/item/item.component';
import { ConfigService } from './config/config.service';
import { ItemUpdateComponent } from './item/item-update/item-update.component';
import { CommonModule, LOCATION_INITIALIZED } from '@angular/common';
import { BrandComponent } from './brand/brand.component';
import { BrandUpdateComponent } from './brand/brand-update/brand-update.component';
import { ErrorsInterceptorService } from './interceptors/errors.interceptor.module';
import { AuthInterceptorService } from './interceptors/auth.interceptor.module';
import { LoadingInterceptorService } from './interceptors/loading.interceptor.module';
import { ModelComponent } from './model/model.component';
import { ModelUpdateComponent } from './model/model-update/model-update.component';
import { HomeComponent } from './home/home.component';
import { LoginComponent } from './login/login.component';
import { AuthGuardService } from './guards/auth-guard.service';
import { RegisterComponent } from './register/register.component';
import { MatNativeDateModule, DateAdapter, MAT_DATE_FORMATS } from '@angular/material/core';
import { AppDateAdapter, APP_DATE_FORMATS } from './shared/app-data-adapter';
import { FormErrorsMessagesComponent } from './shared/form-errors-messages/form-errors-messages.component';
import { AvatarImageDirective } from './shared/avatar-image.directive';
import { AlreadyLoginService } from './guards/already-login.service';
import { TmpComponent } from './tmp/tmp.component';
import { PartComponent } from './part/part.component';
import { PartUpdateComponent } from './part/part-update/part-update.component';
import { DefaultListComponent } from './shared/default-list/default-list.component';

@NgModule({
  declarations: [
    AppComponent,
    ItemComponent,
    ItemUpdateComponent,
    BrandComponent,
    BrandUpdateComponent,
    ModelComponent,
    ModelUpdateComponent,
    HomeComponent,
    LoginComponent,
    RegisterComponent,
    FormErrorsMessagesComponent,
    AvatarImageDirective,
    TmpComponent,
    PartComponent,
    PartUpdateComponent,
    DefaultListComponent
  ],
  imports: [
    CommonModule,
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    NgxSpinnerModule,
    FormsModule,
    ReactiveFormsModule,
    SidebarModule.forRoot(),
    NgxMaskModule.forRoot(),
    NgSelectModule,
    MatSortModule,
    MatPaginatorModule,
    MatDatepickerModule,
    MatInputModule,
    MatNativeDateModule,
    TextInputAutocompleteModule,
    ToastrModule.forRoot(
      {
        closeButton: true,
        enableHtml: true,
        progressBar: true,
        positionClass: 'toast-top-right'

      }
    ),
    TranslateModule.forRoot({
      loader: {

        provide: TranslateLoader,
        useFactory: HttpLoaderFactory,
        deps: [HttpClient]
      }
    })
  ],
  providers: [
    CookieService,
    AuthGuardService,
    AlreadyLoginService,
    {
      provide: APP_INITIALIZER,
      useFactory: startApp,
      deps: [ConfigService],
      multi: true
    },
    {
      provide: APP_INITIALIZER,
      useFactory: appInitializerFactory,
      deps: [TranslateService, Injector],
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: LoadingInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptorService,
      multi: true
    },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: ErrorsInterceptorService,
      multi: true
    },
    { provide: DateAdapter, useClass: AppDateAdapter },
    { provide: MAT_DATE_FORMATS, useValue: APP_DATE_FORMATS }

  ],
  bootstrap: [AppComponent],
  schemas: [
    CUSTOM_ELEMENTS_SCHEMA
  ]
})
export class AppModule { }

export function startApp(cS: ConfigService) {
  return () => {
    return new Promise(resolve => {
      cS.initConfigJson()
        .then(res => {
          resolve(true);
        });
    });
  }
}

export function HttpLoaderFactory(http: HttpClient) {
  return new TranslateHttpLoader(http);

}


export function appInitializerFactory(translate: TranslateService, injector: Injector) {
  return () => new Promise<any>((resolve: any) => {
    const locationInitialized = injector.get(LOCATION_INITIALIZED, Promise.resolve(null));
    locationInitialized.then(() => {
      const langToSet = 'en-us'
      translate.addLangs(['en-us', 'pt-br']);
      translate.setDefaultLang('en-us');
      translate.use(langToSet).subscribe(() => {
        // console.info(`Successfully initialized '${langToSet}' language.'`);
      }, err => {
        // console.error(`Problem with '${langToSet}' language initialization.'`);
      }, () => {
        resolve(null);
      });
    });
  });
}