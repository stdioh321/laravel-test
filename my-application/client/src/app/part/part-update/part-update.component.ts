import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { async } from '@angular/core/testing';
import { delay } from 'rxjs/operators';
import { NgForm } from '@angular/forms';
import { ApiService } from 'src/app/services/api.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { TranslateService } from '@ngx-translate/core';
import { ToastrService } from 'ngx-toastr';
import { UtilsService } from 'src/app/services/utils.service';

@Component({
  selector: 'app-part-update',
  templateUrl: './part-update.component.html',
  styleUrls: ['./part-update.component.scss']
})
export class PartUpdateComponent implements OnInit {
  public id = null;
  public _data = null;
  public data = null;
  public _dataExtra = null;
  public dataExtra = null;

  public isAdd = true;

  constructor(
    public router: Router,
    public aRoute: ActivatedRoute,
    public apiService: ApiService,
    public spinner: NgxSpinnerService,
    public translate: TranslateService,
    public toastr: ToastrService,
    public utilsService: UtilsService

  ) {
    aRoute.params.forEach(v => {
      this.id = v.id;
    });
    if (this.router.url.indexOf('update') > -1) this.isAdd = false;


  }

  ngOnInit() {
    this.loadAllData();
  }
  async loadData() {
    this.data = null;
    this._data = null;
    return this.apiService.partGet(this.id, false, true)
      .toPromise()
      .then(res=>{
        res['id_item'] = parseInt(res['id_item']) || undefined;
        return res;
      });
  }

  async loadAllData() {
    this._data = null;
    this.data = null;
    this.dataExtra = null;
    this.spinner.show();
    try {
      if (!this.isAdd) {
        this._data = await this.loadData();
        this.data = Object.assign({}, this._data);
      }
      this.dataExtra = await this.loadDataExtra();

    } catch (error) {
      this._data = undefined;
      this.data = undefined;
      this.dataExtra = undefined;
      this.toastr.error(
        this.translate.instant('common.not-load-data')
      );
      setTimeout(() => {
        this.router.navigate(['/parts']);
      }, 0);
    }
    // console.log(this.dataExtra);

    setTimeout(() => {
      this.spinner.hide();
    }, 200);
  }

  loadDataExtra() {
    return this.apiService.itemGet(null, false, true)
      .toPromise();
  }
  onSubmit(form: NgForm) {
    let invalid = document.querySelector('.ng-invalid:not(form)');
    if (form.invalid) {
      if (invalid) invalid['focus']();
      return;
    }
    let val = form.value;

    if (this.isAdd) {
      this.apiService.partPost(val, true, true)
        .subscribe(res => {
          // console.log(res);
          this.toastr.success(
            this.translate.instant('common.added', {
              name:
                this.translate.instant('part.part')
            })
          );
          setTimeout(() => {
            this.router.navigate(['/parts']);
          }, 200);
        }, err => {
          // console.log(err);
          if (err.status == 422) {
            this.utilsService.setValidators(err, form);
          }
          if (invalid) invalid['focus']();

        });
    } else {
      this.apiService.partPut(val, this.id, true, true)
        .subscribe(res => {
          // console.log(res);
          this.toastr.success(
            this.translate.instant('common.updated', {
              name:
                this.translate.instant('part.part')
            })
          );
          // this.router.navigate(['/parts']);
          setTimeout(() => {
            this.router.navigate(['/parts']);
          }, 200);
        }, err => {
          // console.log(err);
          if (err.status == 422) {
            this.utilsService.setValidators(err, form);
          }
        });
      if (invalid) invalid['focus']();
    }
    
  }

}
