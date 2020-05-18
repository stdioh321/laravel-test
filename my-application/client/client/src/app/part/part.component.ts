import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-part',
  templateUrl: './part.component.html',
  styleUrls: ['./part.component.scss']
})
export class PartComponent implements OnInit {

  public data: Array<any> = null;

  constructor(
    public apiService: ApiService,
    public translate: TranslateService
  ) { }

  ngOnInit() {
    this.loadData();
  }

  loadData() {
    this.data = null;
    this.apiService.partGet(null, true, true)
      .subscribe((res: Array<any>) => {
        this.data = res;
      }, err => {
        this.data = undefined;
      });
  }

  onDeletePart(part) {
    let remove = confirm(
      this.translate.instant("common.realy_delete", {
        name:
          this.translate.instant('part.part')
      })
    );

    if (remove) {
      this.apiService.partDelete(part.id, true, true)
        .subscribe(res => {
          console.log(res);
          this.data.splice(this.data.indexOf(part), 1);
        }, err => {
          console.log(err);
        })

    }
  }
}
