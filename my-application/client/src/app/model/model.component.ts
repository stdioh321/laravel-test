import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { ToastrService } from 'ngx-toastr';
import { ApiService } from '../services/api.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { HomeComponent } from '../home/home.component';
import { Subscription } from 'rxjs';
import { ActivatedRoute, Router, ActivatedRouteSnapshot } from '@angular/router';

@Component({
  selector: 'app-model',
  templateUrl: './model.component.html',
  styleUrls: ['./model.component.scss']
})
export class ModelComponent implements OnInit {
  public data = null;
  // public parent:ParrentCom

  constructor(
    public translate: TranslateService,
    public toastr: ToastrService,
    public apiService: ApiService,
    public spinner: NgxSpinnerService,
    public aRoute: ActivatedRoute,
    public router: Router,

  ) { }

  ngOnInit() {
    this.loadData();
  }

  loadData() {
    this.data = null;
    this.apiService.modelGet(null, true, true)
      .subscribe(res => {
        this.data = res;

      }, err => {
        this.data = undefined;
      });
  }
}
