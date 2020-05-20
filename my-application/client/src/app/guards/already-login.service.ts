import { Injectable } from '@angular/core';
import { AuthService } from '../auth.service';
import { CanActivate, CanActivateChild, Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AlreadyLoginService implements CanActivate, CanActivateChild {
  public isAuth = true;
  constructor(
    public authService: AuthService,
    public router: Router,
  ) { }


  canActivateChild() {
    return this.canActivate();
  }
  canActivate() {
    if (this.authService.checkToken()) {
      // this.isAuth = false;
      // this.authService.goToLogin();
      this.router.navigate(['/items']);
    }
    return this.isAuth

  }
}
