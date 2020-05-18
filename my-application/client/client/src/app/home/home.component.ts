import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  public _opened = false;
  constructor(
    public apiService: ApiService,
    public authService: AuthService,
  ) { }

  ngOnInit() {
    // console.log('HomeComponent');
    // this.loadUserData();
  }

  toggleSidebar() {
    this._opened = !this._opened;
  }

  logout() {
    this.apiService.logoutPost(true, true)
      .subscribe(res => {
        this.authService.killAll();
        setTimeout(() => {
          this.authService.goToLogin()
        }, 200);
      }, err => {
        this.authService.killAll();
        setTimeout(() => {
          this.authService.goToLogin()
        }, 200);
      });

  }

  loadUserData() {
    this.apiService.meGet(false, true)
      .subscribe(res => {
        // console.log(res);
      }, err => {
        // console.log(err);
      });
  }
}
