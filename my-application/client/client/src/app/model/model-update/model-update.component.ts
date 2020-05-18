import { Component, OnInit, ViewChild } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';
import { ApiService } from 'src/app/services/api.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { NgForm, FormControl } from '@angular/forms';
import { inOut } from 'src/app/extra/animations';
import { UtilsService } from 'src/app/services/utils.service';

@Component({
  selector: 'app-model-update',
  templateUrl: './model-update.component.html',
  styleUrls: ['./model-update.component.scss'],
  animations: [
    inOut
  ]
})
export class ModelUpdateComponent implements OnInit {
  @ViewChild('f', { static: false }) f: NgForm;


  public data = null;
  public dataExtra = null;
  public isAddRoute = false;
  public id = null;
  public tags = [
    'blue',
    'red',
    'yellow',
    'green',
    'pink',
    'gray',
    'black',
    'white'
  ];
  constructor(
    public router: Router,
    public aRoute: ActivatedRoute,
    public toastr: ToastrService,
    public translate: TranslateService,
    public apiService: ApiService,
    public spinner: NgxSpinnerService,
    public utilsService: UtilsService

  ) { }

  async ngOnInit() {
    this.aRoute.params.forEach(param => {
      this.id = param.id;
    });
    if (this.router.url.indexOf('add') > -1) this.isAddRoute = true;

    await this.loadAllData();

  }
  async loadAllData() {
    this.spinner.show();
    try {

      this.dataExtra = await this.loadDataExtra();
      if (!this.isAddRoute) {
        this.data = await this.loadData();
        this.data = Array.isArray(this.data) ? this.data[0] : this.data;
        this.data.id_brand = parseInt(this.data.id_brand);
      }
    } catch (error) {
      this.data = undefined;
      this.dataExtra = undefined;
      this.toastr.error(this.translate.instant('common.not-load-data'));
      setTimeout(() => {
        this.router.navigate(['/models']);
      }, 200);
    }
    this.spinner.hide();
  }
  loadData() {
    return this.apiService.modelGet(this.id, false, true)
      .toPromise();
  }
  loadDataExtra() {
    return this.apiService.brandGet(null, false, true)
      .toPromise();
  }

  onSubmit(f: NgForm) {
    if (f.invalid) {
      let invalid = document.querySelector('.ng-invalid');
      if (invalid) invalid['focus']();
      return;
    }
    let val = f.value;
    let name = this.translate.instant('model.model');
    if (this.isAddRoute) {
      this.apiService.modelPost(val, true, true)
        .subscribe(res => {
          setTimeout(() => {
            this.router.navigate(['/models']);
          }, 200);
          this.toastr.success(
            this.translate.instant('common.added', { name: name })
          );
        }, err => {
          if (err.status == 422) {

            let errors = err.error.errors;
            let tmpName = errors['name'];

            this.toastr.error(
              this.translate.instant('common.fields_validation_fail')
            );

            if (this.utilsService.hasInArray('already been taken', tmpName)) {
              let tmpName = this.f.controls['name'].value;
              this.f.controls['name'].setValidators([this.f.controls['name'].validator, (fC: FormControl) => {
                if (tmpName == fC.value) return { 'conflit': "Name already used" };
                return null;
              }]);
              this.f.controls['name'].updateValueAndValidity();
              this.toastr.error(
                this.translate.instant('common.already_used', { name: this.translate.instant('common.name') })
              );
            }

          }
        });
    } else {
      this.apiService.modelPut(val, this.id, true, true)
        .subscribe(res => {
          setTimeout(() => {
            this.router.navigate(['/models']);
          }, 200);
          this.toastr.success(
            this.translate.instant('common.updated', { name: name })
          );
        }, err => {
          if (err.status == 422) {

            let errors = err.error.errors;
            let tmpName = errors['name'];

            this.toastr.error(
              this.translate.instant('common.fields_validation_fail')
            );

            if (this.utilsService.hasInArray('already been taken', tmpName)) {
              let tmpName = this.f.controls['name'].value;
              this.f.controls['name'].setValidators([this.f.controls['name'].validator, (fC: FormControl) => {
                if (tmpName == fC.value) return { 'conflit': "Name already used" };
                return null;
              }]);
              this.f.controls['name'].updateValueAndValidity();
              this.toastr.error(
                this.translate.instant('common.already_used', { name: this.translate.instant('common.name') })
              );
            }

          }
        });
    }
  }
  addTag(name) {
    return name;
  }
}
