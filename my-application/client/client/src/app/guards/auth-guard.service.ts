import { Injectable } from '@angular/core';
import { CanActivate, Router, CanActivateChild } from '@angular/router';
import { AuthService } from '../auth.service';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';

@Injectable({
  providedIn: 'root'
})
export class AuthGuardService implements CanActivate, CanActivateChild {
  private isAuth = false;
  constructor(
    private authService: AuthService,
    private router: Router,
    private toastr: ToastrService,
    private translate: TranslateService,
  ) { }

  canActivateChild() {
    return this.canActivate();
  }
  canActivate() {
    if (this.authService.checkToken()) {
      this.isAuth = true;
    } else {
      this.isAuth = false;
      // this.toastr.info(this.translate.instant('login.auth_necessary'));
      this.authService.killAll().goToLogin();
    }
    return this.isAuth

  }
}
