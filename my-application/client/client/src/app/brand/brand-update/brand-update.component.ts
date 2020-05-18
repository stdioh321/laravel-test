import { Component, OnInit, ViewChild } from '@angular/core';
import { ApiService } from 'src/app/services/api.service';
import { Router, ActivatedRoute } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { NgForm, FormControl } from '@angular/forms';
import { inOut } from 'src/app/extra/animations';
import { finalize, timeout } from 'rxjs/operators';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';
@Component({
  selector: 'app-brand-update',
  templateUrl: './brand-update.component.html',
  styleUrls: ['./brand-update.component.scss'],
  animations: [
    inOut
  ]
})
export class BrandUpdateComponent implements OnInit {
  @ViewChild('f', { static: true }) f: NgForm;

  public id = null;
  public data = null;
  public isAddRoute = false;

  constructor(
    public apiService: ApiService,
    public router: Router,
    public aRoute: ActivatedRoute,
    public spinner: NgxSpinnerService,
    public toastr: ToastrService,
    public translate: TranslateService,
  ) { }

  async ngOnInit() {
    this.aRoute.params.forEach(param => {
      this.id = param.id;
    });
    if (this.router.url.indexOf('add') > -1) this.isAddRoute = true;


    await this.loadAllData();


  }
  async loadAllData() {
    // this.spinner.show();
    try {
      this.data = await this.loadData();
    } catch (error) {
      this.data = undefined;
    }
    // this.spinner.hide();
  }
  loadData() {
    return this.apiService.brandGet(this.id, true, true)
      .toPromise()
      .then(res => {
        return res;
      })
      .catch(err => {
        this.router.navigate(['/brands']);
        this.toastr.error(this.translate.instant('common.not-load-data'));
        return err;

      });
  }

  onSubmit(f: NgForm) {
    if (f.invalid) {
      let invalid = document.querySelector('ng-invalid');
      if (invalid) invalid['focus']();
      return;
    }
    var val = f.value;
    let name = this.translate.instant('brand.brand');
    if (this.isAddRoute) {
      // this.spinner.show();
      this.apiService.brandPost(val, true, true)
        .subscribe(res => {
          this.toastr.success(this.translate.instant('common.added', { name: name }));
          setTimeout(() => {
            this.router.navigate(['/brands']);
          }, 100);
        }, err => {
          if (err.status == 409) {
            this.toastr.error(this.translate.instant('brand.name-used'));
            let name = this.f.controls['name'];
            let currName = this.f.controls['name'].value;
            name.setValidators([name.validator, (fC: FormControl) => {
              if (currName == fC.value) return { 'conflit': 'Name already used' };
              return null;
            }]);
            name.updateValueAndValidity();
          } else if (err.status == 400) {
            this.toastr.error(this.translate.instant('common.field-validation-error'));
          }
        });
    } else {


      this.apiService.brandPut(val, this.id, true, true)
        .subscribe(res => {
          this.toastr.success(this.translate.instant('common.updated', { name: name }));
          setTimeout(() => {
            this.router.navigate(['/brands']);
          }, 100);
        }, err => {
          if (err.status == 409) {
            this.toastr.error(this.translate.instant('brand.name-used'));
            let name = this.f.controls['name'];
            let currName = this.f.controls['name'].value;
            name.setValidators([name.validator, (fC: FormControl) => {
              if (currName == fC.value) return { 'conflit': 'Name already used' };
              return null;
            }]);
            name.updateValueAndValidity();
          } else if (err.status == 400) {
            this.toastr.error(this.translate.instant('common.field-validation-error'));
          }
        });
    }
  }
}
