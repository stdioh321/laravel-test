import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { of } from 'rxjs';
import { delay } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {
  public config = null;
  public urls = null;
  constructor(
    public http: HttpClient
  ) { }

  public async initConfigJson() {
    
    this.config = await this.http.get("/assets/config/config.json").toPromise();
    this.urls = await this.http.get("/assets/config/urls.json").toPromise();
  }
}
