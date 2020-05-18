import { Component, OnInit, ViewChild } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { ConfigService } from 'src/app/config/config.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { finalize } from 'rxjs/operators';
import { NgForm, NgModel, FormControl } from '@angular/forms';
import { trigger, transition, style, animate } from '@angular/animations';
import { inOut } from 'src/app/extra/animations';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';
import { ApiService } from 'src/app/services/api.service';


@Component({
  selector: 'app-item-update',
  templateUrl: './item-update.component.html',
  styleUrls: ['./item-update.component.scss'],
  animations: [
    inOut
  ]
})
export class ItemUpdateComponent implements OnInit {
  @ViewChild('f', { static: false }) f: NgForm;


  public id = null;
  public isAddRoute = false;
  public data = null;
  public dataExtra = { brands: null, models: null };
  public msgError = null;
  public colorsList = ["Aquamarine", "Azure", "Black", "Blue", "Brown", "Charcoal", "Coral", "Crimson", "Cyan", "Fuchsia", "Gray", "Green", "Hot pink", "Ivory", "Khaki", "Lime", "Magenta", "Maroon", "Navy blue", "Olden", "Olive", "Orange", "Pea green", "Plum", "Purple", "Red", "Silver", "Teal", "Wheat", "White", "Yellow"];
  // public brand: NgModel;
  public models: Array<any> = [];
  constructor(
    public router: Router,
    public aRoute: ActivatedRoute,
    public http: HttpClient,
    public cS: ConfigService,
    public spinner: NgxSpinnerService,
    public toastr: ToastrService,
    public apiService: ApiService,
    public translate: TranslateService,
  ) { }

  async ngOnInit() {


    this.aRoute.params.forEach(item => {
      this.id = item.id;
    });
    if (this.router.url.indexOf('add') > -1) this.isAddRoute = true;
    // if (!this.id) this.router.navigate(['/items']);

    await this.lAllData();

  }

  ngAfterViewInit() {
    // console.log('ngAfterViewInit');
    setTimeout(() => {
      console.log(this.f);
    }, 0);
  }


  async lAllData() {
    this.spinner.show();
    try {
      this.data = null;
      this.dataExtra.brands = null;
      this.dataExtra.models = null;


      this.dataExtra = await this.lDataExtra();
      if (!this.isAddRoute) {
        this.data = await this.lData();
        this.models = this.dataExtra.models.filter(item => {
          if (item.id_brand == this.data['id_brand']) return true;
        });
      }


    } catch (error) {
      if (!this.isAddRoute)
        this.data = undefined;
      this.dataExtra.brands = undefined;
      this.dataExtra.models = undefined;
      // console.log('ERRORR', error);

    }
    this.spinner.hide();
  }
  lData() {
    return this.apiService.itemGet(this.id, false, true)
      .toPromise()
      .then(res => {
        return res;
      })
      .catch(err => {
        if (err.status == 406 || err.status == 404) { this.router.navigate(['/items']) };
        return err;

      });
  }
  lDataExtra() {
    return this.apiService.brandGet(null, null, true)
      .toPromise()
      .then((brands: Array<any>) => {
        return this.apiService.modelGet(null, null, true)
          .toPromise()
          .then((models: Array<any>) => {
            let tmpBrands = brands.filter(item1 => {
              if (models.find(item2 => {
                return item1.id == item2.id_brand;
              })) {
                return true;
              }
            });
            tmpBrands = tmpBrands.sort((a, b) => {
              return a['name'] < b['name'] ? -1 : 1;
            });
            return { brands: tmpBrands, models: models };
          });
      });
  }

  onSubmit(f: NgForm) {
    this.msgError = null;
    let val = f.value;
    if (f.invalid) {
      let invalidInput = document.querySelector('form .ng-invalid');
      if (invalidInput) invalidInput['focus']();
      return;
    }
    // this.spinner.show();
    if (this.isAddRoute) {
      this.apiService.itemPost(val, true, true)
        .subscribe(res => {
          let tmpItem = this.translate.instant('item.item');
          this.toastr.success(this.translate.instant('common.added', { name: tmpItem }));

          setTimeout(() => {
            this.router.navigate(['/items']);
          }, 200)
        }, err => {
          if (err.status == 409) {
            if (err.error && err.error.errors && err.error.errors.name) {
              let currName = this.f.controls['name'].value;
              this.msgError = this.translate.instant('item-update.name-used');
              this.f.controls['name'].setValidators([
                this.f.controls['name'].validator,
                (fC: FormControl) => {
                  if (currName == fC.value) {
                    return { 'conflit': 'This name is already used' }
                  }
                  return null;
                }
              ]);
              this.f.controls['name'].updateValueAndValidity();
              ;
            }
          } else if (err.status == 400) {
            this.toastr.error(this.translate.instant('item-update.field-validation-error'));
          }
        });
    } else {

      this.apiService.itemPut(val, this.id, true, true)
        .subscribe(res => {
          let tmpItem = this.translate.instant('item.item');
          this.toastr.success(this.translate.instant('common.updated', { name: tmpItem }));

          setTimeout(() => {
            this.router.navigate(['/items']);
          }, 200)
        }, err => {
          if (err.status == 409) {
            if (err.error && err.error.errors && err.error.errors.name) {
              let currName = this.f.controls['name'].value;
              this.msgError = this.translate.instant('item-update.name-used');
              this.f.controls['name'].setValidators([
                this.f.controls['name'].validator,
                (fC: FormControl) => {
                  if (currName == fC.value) {
                    return { 'conflit': 'This name is already used' }
                  }
                  return null;
                }
              ]);
              this.f.controls['name'].updateValueAndValidity();
              ;
            }
          } else if (err.status == 400) {
            this.toastr.error(this.translate.instant('item-update.field-validation-error'));
          }
        });
    }

  }


  onPriceChange(e: NgModel) {
    let val: string = e.value;
    val = val.replace(/\D/ig, '');
    // val = parseInt(val).toFixed(2);
    val = val.replace(/(\d+)(\d{2})$/ig, '$1.$2');
    e.control.setValue(val);
  }
  onBrandChange(brand: NgModel) {

    this.models = [];
    this.models = this.dataExtra.models.filter(item => {
      if (brand.value == item.id_brand) return true;
    });
    this.f && this.f.controls['id_model'] && this.f.controls['id_model'].setValue(null);


  }
  getModels(id_brand = null) {
    let models = this.dataExtra.models ? this.dataExtra.models : [];
    return models.filter(item => { return id_brand == item.id_brand });
  }

}
