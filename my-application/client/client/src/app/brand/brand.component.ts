import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { finalize } from 'rxjs/operators';
import { TranslateService } from '@ngx-translate/core';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-brand',
  templateUrl: './brand.component.html',
  styleUrls: ['./brand.component.scss']
})
export class BrandComponent implements OnInit {
  public data: Array<any> = null;
  constructor(
    public apiService: ApiService,
    public spinner: NgxSpinnerService,
    public translate: TranslateService,
    public toastr: ToastrService,
  ) { }

  ngOnInit() {
    this.loadData();
  }


  loadData() {
    this.data = null;
    // setTimeout(() => {
    this.spinner.show();
    // }, 100);
    this.apiService.brandGet(null, false, true)
      .pipe(finalize(() => {
        this.spinner.hide();
      }))
      .subscribe((res: Array<any>) => {
        this.data = res;
      }, err => {
        this.data = undefined;
      })
  }

  onDeleteBrand(brand = {}) {
    // console.log(brand);
    let name = this.translate.instant('brand.brand');
    var remove = confirm(this.translate.instant("common.realy_delete", { name: name }));
    if (remove) {

      this.apiService.brandDelete(brand['id'], true, true)
        .subscribe(res => {
          this.data.splice(this.data.indexOf(brand), 1);
          let tmpBrand = this.translate.instant('brand.brand');
          this.toastr.success(this.translate.instant('common.deleted', { name: tmpBrand }));
        }, err => {
          if (err.status == 406) {
            let tmpBrand = this.translate.instant('brand.brand');
            this.toastr.error(this.translate.instant('common.not_found', { name: tmpBrand }));
          }

        });

    }
  }

}
