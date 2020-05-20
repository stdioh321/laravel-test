import { Injectable } from '@angular/core';
import { CookieService } from 'ngx-cookie-service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    public cookieService: CookieService,
    public router: Router,
  ) {

  }
  get token() {
    return this.cookieService.get('token')
  }
  set token(token: string) {
    if (token)
      this.cookieService.set('token', token, null, '/');
    else
      this.cookieService.delete('token', '/');
  }

  get user() {
    let tmpUser = localStorage.getItem('user');
    if (tmpUser) tmpUser = JSON.parse(tmpUser);
    return tmpUser
  }
  set user(user: {}) {
    console.log('USER UPDATED');

    if (user) {
      localStorage.setItem('user', JSON.stringify(user));
    } else {
      localStorage.removeItem('user');
    }

  }

  checkToken() {
    if (this.token && this.user) return true;
    return false;
  }


  killAll() {
    this.token = null;
    this.user = null;
    this.cookieService.delete('token');
    return this;
  }
  goToLogin() {
    this.router.navigate(['/login']);
    return this;
  }

}
