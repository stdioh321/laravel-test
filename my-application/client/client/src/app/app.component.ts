import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Router, NavigationStart, NavigationEnd, ActivatedRoute } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import { TranslateService } from '@ngx-translate/core';
import { UtilsService } from './services/utils.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class AppComponent implements OnInit {
  // public title = 'client';
  public langs = null;
  public currLang = null;
  public _opened = true;

  constructor(
    public router: Router,
    public aRoute: ActivatedRoute,
    public spinner: NgxSpinnerService,
    public translate: TranslateService,
    public utilsService: UtilsService,
  ) {
    this.langs = this.translate.getLangs();
    this.currLang = this.translate.getDefaultLang();
    // console.log(this.langs);

    // translate.addLangs(['en-us','pt-br']);
    // translate.setDefaultLang('en-us');
    // translate.use('en-us');
  }
  ngOnInit() {
    this.router.events.subscribe(ev => {
      if (ev instanceof NavigationStart) {
        window.scrollTo(0, 0);
      };
      if (ev instanceof NavigationEnd) {
        // let tit = this.router.url.split('/')[1] ? this.router.url.split('/')[1] : "My Application";
        // tit = tit.charAt(0).toUpperCase() + tit.slice(1);
        // this.utilsService.title = tit;


      }

    });
  }
}
