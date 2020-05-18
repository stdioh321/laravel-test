import { Component, OnInit, Input } from '@angular/core';
import { FormControl } from '@angular/forms';
import { TranslateService } from '@ngx-translate/core';
import { inOut, stretch } from 'src/app/extra/animations';

@Component({
  selector: 'form-errors-messages',
  templateUrl: './form-errors-messages.component.html',
  styleUrls: ['./form-errors-messages.component.scss'],
  animations: [
    inOut,
    stretch
  ]
})
export class FormErrorsMessagesComponent implements OnInit {
  @Input('fieldName') public fieldName: String = "";
  @Input('fControl') public fControl: FormControl = null;

  constructor(
    public translate: TranslateService
  ) { }

  ngOnInit() {
  }

}
