import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'default-list',
  templateUrl: './default-list.component.html',
  styleUrls: ['./default-list.component.scss']
})
export class DefaultListComponent implements OnInit {
  @Input('columns') columns: Array<string> = [];
  @Input('fields') fields: Array<string> = [];
  @Input('data') data: Array<any> = [];

  constructor() { }

  ngOnInit(): void {
  }

}
