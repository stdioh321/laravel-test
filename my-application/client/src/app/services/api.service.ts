import { Injectable } from '@angular/core';
import { ConfigService } from '../config/config.service';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  public _opened = false;
  constructor(
    public cS: ConfigService,
    public http: HttpClient,
  ) { }

  facebookPost(data = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'loginFacebook', data, headers);
  }
  googlePost(data = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'loginGoogle', data, headers);
  }

  meGet(load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    headers.headers.append('Content-Type', 'text/html');
    return this.http.get(this.cS.urls.urlBase + 'me', headers);
  }
  loginPost(data = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'login', data, headers);
  }
  logoutPost(load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'logout', {}, headers);
  }

  userPost(user = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'user', user, headers);
  }

  userPut(user = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.post(this.cS.urls.urlBase + 'user-update', user, headers);
  }


  itemPost(item = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'item', item, headers);
  }
  itemPut(item = {}, id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.put(this.cS.urls.urlBase + 'item/' + id, item, headers);
  }
  itemDelete(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.delete(this.cS.urls.urlBase + 'item/' + id, headers);
  }
  itemGet(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    if (id)
      return this.http.get(this.cS.urls.urlBase + 'item/' + id, headers);
    return this.http.get(this.cS.urls.urlBase + 'item', headers);
  }
  itemGetPaginate(pageSize = null, page = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.get(this.cS.urls.urlBase + 'item?p=' + pageSize + '&page=' + page, headers);
  }
  brandGet(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    if (id)
      return this.http.get(this.cS.urls.urlBase + 'brand/' + id, headers);
    return this.http.get(this.cS.urls.urlBase + 'brand', headers);
  }
  brandPost(item: {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.post(this.cS.urls.urlBase + 'brand', item, headers);
  }
  brandPut(item: {}, id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.put(this.cS.urls.urlBase + 'brand/' + id, item, headers);
  }
  brandDelete(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);

    return this.http.delete(this.cS.urls.urlBase + 'brand/' + id, headers);
  }

  modelGet(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    if (id)
      return this.http.get(this.cS.urls.urlBase + 'model/' + id, headers);
    return this.http.get(this.cS.urls.urlBase + 'model', headers);
  }
  modelPut(model = {}, id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.put(this.cS.urls.urlBase + 'model/' + id, model, headers);
  }

  modelPost(model = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'model', model, headers);
  }

  partGet(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    if (id)
      return this.http.get(this.cS.urls.urlBase + 'part/' + id, headers);
    return this.http.get(this.cS.urls.urlBase + 'part', headers);
  }
  partPost(part = {}, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.post(this.cS.urls.urlBase + 'part', part, headers);
  }
  partPut(part = {}, id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.put(this.cS.urls.urlBase + 'part/' + id, part, headers);
  }
  partDelete(id = null, load = false, handleErrors = false) {
    let headers = this.generateHeaders(load, handleErrors);
    return this.http.delete(this.cS.urls.urlBase + 'part/' + id, headers);
  }

  generateHeaders(load = false, handleErrors = false) {
    let tmpLoad = load ? 'true' : 'false';
    let tmpHandle = handleErrors ? 'true' : 'false';
    return {
      headers: new HttpHeaders({
        'loading': tmpLoad,
        'handleErros': tmpHandle
      })
    };
  }
}
