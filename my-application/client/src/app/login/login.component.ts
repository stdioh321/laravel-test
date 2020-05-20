import { Component, OnInit, AfterViewInit, NgZone, ViewChild } from '@angular/core';
import { NgForm, FormControl } from '@angular/forms';
import { inOut } from '../extra/animations';
import { ApiService } from '../services/api.service';
import { TranslateService } from '@ngx-translate/core';
import { CookieService } from 'ngx-cookie-service';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthService } from '../auth.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { ToastrService } from 'ngx-toastr';
import { finalize } from 'rxjs/operators';
import { OauthService } from '../services/oauth.service';


declare var FB;
declare var gapi;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
  animations: [
    inOut
  ]
})
export class LoginComponent implements OnInit, AfterViewInit {
  @ViewChild('f', { static: false }) f: NgForm;
  public msgError = null;



  constructor(
    public apiService: ApiService,
    public translate: TranslateService,
    public cookieService: CookieService,
    public router: Router,
    public aRoute: ActivatedRoute,
    public authService: AuthService,
    public spinner: NgxSpinnerService,
    public toastr: ToastrService,
    public ngZone: NgZone,
    public oauthService: OauthService
  ) { }

  ngOnInit() {
    // console.log(this.router.url);

    if (this.authService.checkToken()) {
      // this.toastr.info(this.translate.instant('login.already_login'));
      // this.router.navigate(['/']);
    }
  }
  ngAfterViewInit() {
    // this.initFacebookSDK();
  }
  onSubmit(f: NgForm) {
    this.msgError = null;
    if (f.invalid) {
      let invalid = document.querySelector('.ng-invalid');
      if (invalid) invalid['focus']();
      return;
    }
    let val = f.value;
    this.spinner.show();
    this.apiService.loginPost(val, false, true)
      .subscribe(res => {
        console.log(this.authService.checkToken());

        this.authService.token = res['token'];
        this.authService.user = res['user'];
        this.spinner.hide();
        setTimeout(() => {
          this.router.navigate(['/items']);
        }, 0);

      }, err => {
        this.spinner.hide();
        // console.log(err);
        if (err.status == 401) {
          this.msgError = this.translate.instant('login.user_pass_invalid');
          this.toastr.warning(
            this.translate.instant('login.user_pass_invalid')
          );
        }
        else if (err.status == 422) {
          this.msgError = this.translate.instant('common.field-validation-error');
        }
        else if (err.status == 0) {
          this.msgError = this.translate.instant('common.not_communicate_server');
        }
        else {
          this.msgError = this.translate.instant('common.server_error');
        }

      });
  }

  loginFacebook() {
    this.spinner.show();
    this.oauthService.signInFacebook()
      .then(res => {
        this.apiService.facebookPost(res, false, true)
          .subscribe(res2 => {
            // console.log(res2);

            this.authService.token = res2['token'];
            this.authService.user = res2['user'];
            this.spinner.hide();
            setTimeout(() => {
              this.router.navigate(['/items']);
            }, 0);

          }, err => {
            // console.log(err);
            setTimeout(() => {
              this.spinner.hide();
            }, 0);
            if (err.status == 403) {
              this.toastr.error(
                this.translate.instant('common.forbidden', { name: '' })
              );
            }

          });
      })
      .catch(err => {
        console.log(err);
        this.spinner.hide();
        // this.msgError = this.translate.instant('common.server_error');
      });
  }
  loginGoogle() {
    this.spinner.show();
    this.oauthService.signInGoogle()
      .then(res => {
        this.apiService.googlePost(res, false, true)
          .subscribe(res2 => {
            // console.log(res2);
            this.authService.token = res2['token'];
            this.authService.user = res2['user'];
            this.spinner.hide();
            setTimeout(() => {
              this.router.navigate(['/items']);
            }, 0);
          }, err => {
            console.log(err);
            setTimeout(() => {
              this.spinner.hide();
            }, 0);
          })

      })
      .catch(err => {
        console.log(err);
        if (err && err.error == 'popup_closed_by_user')
          this.msgError = this.translate.instant('common.server_error');
        setTimeout(() => {
          this.spinner.hide();
        }, 0);
      });

  }
}
