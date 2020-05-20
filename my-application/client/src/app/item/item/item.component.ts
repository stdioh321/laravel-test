import { Component, OnInit, ViewChild } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ConfigService } from 'src/app/config/config.service';
import { finalize, delay } from "rxjs/operators"
import { NgxSpinnerService } from 'ngx-spinner';
import { TranslateService, TranslatePipe } from '@ngx-translate/core';
import { ApiService } from 'src/app/services/api.service';
import { ToastrService } from 'ngx-toastr';
import { Dessert } from 'src/app/models/item.model';
import { Sort, MatSort } from '@angular/material/sort';
import { isString } from 'util';
import { PageEvent, MatPaginator } from '@angular/material/paginator';


@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})

export class ItemComponent implements OnInit {
  @ViewChild('mP', { static: true }) mP: MatPaginator;

  public data = null;
  public data$ = null;
  public sortedData: Array<any> = [];
  public size = 0;
  public pageSize = 10;
  public pageIndex = 0;




  constructor(
    public http: HttpClient,
    public cS: ConfigService,
    public spinner: NgxSpinnerService,
    public apiService: ApiService,
    public translate: TranslateService,
    public toastr: ToastrService,
  ) {

  }

  ngOnInit() {

    this.loadData();

  }
  goFirst() {
    this.mP && this.mP.firstPage();
  }

  loadData(page = 0) {
    this.data = null;
    this.sortedData = null;

    // return this.apiService.itemGet(null, true, true)
    return this.apiService.itemGetPaginate(this.pageSize, page + 1, true, true)
      .subscribe((res: Array<any>) => {
        this.data = res['data'];
        this.pageIndex = page;
        this.size = res['total'];
        this.sortedData = this.data.slice();
        // this.sortData({ active: '', direction: '' }, this.data);

      }, err => {
        this.data = undefined;
        this.sortedData = undefined;
        // this.toastr.error(this.translate.instant('error-loading-data'));
      });
  }

  onItemDelete(item = {}) {
    let remove = confirm(this.translate.instant('item.realy_delete'));
    if (remove) {

      this.apiService.itemDelete(item['id'], true, true)
        .subscribe(res => {
          this.data.splice(this.data.indexOf(item), 1);
          let tmpItem = this.translate.instant('item.item');
          this.toastr.success(this.translate.instant('common.deleted', { name: tmpItem }));

        }, err => {
          if (err && err.status == 406) {
            let tmpItem = this.translate.instant('item.item');
            this.toastr.error(this.translate.instant('common.not_found', { name: tmpItem }));
          }

        });
    }
  }
  sortData(s: Sort, arrOriginal = []) {
    let data: Array<Dessert> = arrOriginal.slice();
    if (!s.active || s.direction == "") {
      this.sortedData = data;
      return;
    }
    // console.log(s);

    let isAsc = s.direction === 'asc';
    this.sortedData.sort((a, b) => {
      let tmpA = isString(a[s.active]) ? (a[s.active] + "").toLowerCase() : a[s.active];
      let tmpB = isString(b[s.active]) ? (b[s.active] + "").toLowerCase() : b[s.active];
      tmpA = tmpA === null || tmpA === undefined ? '' : tmpA;
      tmpB = tmpB === null || tmpB === undefined ? '' : tmpB;

      return (tmpA == tmpB ? 0 : ((tmpA < tmpB ? -1 : 1))) * (isAsc ? 1 : -1);
    });
  }

  onPageChange(e: PageEvent) {
    console.log(e);

    let pI = e.pageIndex;
    if (this.pageSize != e.pageSize) {
      pI = 1;
    }
    this.pageSize = e.pageSize;
    this.loadData(pI);

  }
}
