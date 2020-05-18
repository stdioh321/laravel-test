import { Component, OnInit, ViewChild, ElementRef, HostListener } from '@angular/core';
import { NgForm, FormControl, FormGroup, NgModelGroup, NgModel, Validators, FormGroupDirective, FormArray } from '@angular/forms';
import { inOut, opacity } from '../extra/animations';
import { HttpClient, HttpResponse } from '@angular/common/http';

@Component({
  selector: 'app-tmp',
  templateUrl: './tmp.component.html',
  styleUrls: ['./tmp.component.scss'],
  animations: [
    inOut,
    opacity
  ]
})
export class TmpComponent implements OnInit {

  constructor(
    public http: HttpClient
  ) { }



  ngOnInit() {
  }

  loadData() {
    this.http.get('http://localhost:8000/api/tmp', {
      observe: 'response'
    })
      .subscribe((res: HttpResponse<any>) => {
        // console.log(res.headers.get('X-Powered-By'));
        console.log(res);
      }, err => {
        console.log(err);
      });

  }
}
