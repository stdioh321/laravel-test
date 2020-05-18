import { Injectable } from '@angular/core';

declare var gapi;
declare var FB;

@Injectable({
  providedIn: 'root'
})
export class OauthService {
  public GoogleAuth = null;
  public FB = null;

  constructor() {
    this.initGoogleSdk()
      .then(res => {
        this.GoogleAuth = res;
        // console.log(res);        
      })
      .catch(err => {
        this.GoogleAuth = undefined;
      });
    this.initFacebookSdk()
      .then(res => {
        this.FB = res;
      })
      .catch(err => {
        this.FB = undefined;
      });
  }



  initFacebookSdk() {
    return new Promise((resolve, reject) => {
      let id = 'facebook-jssdk';
      let d = document;
      let s = "script";

      var js, fjs = document.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = document.createElement(s); js.id = id;
      js.src = "https://connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
      js.onerror = (e) => { reject(e) };
      js.onabort = (e) => { reject(e) };
      js.oncancel = (e) => { reject(e) };


      window['fbAsyncInit'] = () => {
        FB.init({
          appId: '2613153008968791',
          cookie: true,
          xfbml: true,
          version: 'v4.0'
        });
        resolve(FB);
      };
    });
  }

  signInFacebook() {
    return new Promise((resolve, reject) => {
      if (!this.FB) reject("FB not loaded");
      this.FB.login((response) => {
        if (response && response.authResponse) {
          resolve(response);
        } else {
          reject(response);
        }
      }, { auth_type: 'rerequest' });
    });
  }


  initGoogleSdk() {
    return new Promise((resolve, reject) => {
      try {
        let apiScript = document.createElement('script');
        document.body.appendChild(apiScript);
        apiScript.setAttribute('src', 'https://apis.google.com/js/api.js');
        apiScript.onerror = (e) => { reject(e) };
        apiScript.onabort = (e) => { reject(e) };
        apiScript.oncancel = (e) => { reject(e) };
        apiScript.onload = (e) => {
          gapi.load('client:auth2', () => {
            gapi.client.init({
              'apiKey': 'AIzaSyARlHsUdL_obs3d3nIboFNiOUfJxOOhCvs',
              'clientId': '1544731958-bklsi6pe96cks604gl13t7n0kmapbvsv.apps.googleusercontent.com',
              'scope': 'https://www.googleapis.com/auth/drive.metadata.readonly https://www.googleapis.com/auth/userinfo.profile',
              'discoveryDocs': ['https://www.googleapis.com/discovery/v1/apis/drive/v3/rest']
            }).then((r) => {
              // this.GoogleAuth = gapi.auth2.getAuthInstance();
              // console.log(r);

              resolve(gapi.auth2.getAuthInstance());
            }).catch(err => {
              reject(e)
            });
          });
        }
      } catch (error) {
        reject(error);
      }
    });
  }



  signInGoogle() {
    return new Promise((resolve, reject) => {
      if (!this.GoogleAuth) reject("GoogleAuth not loaded");
      this.GoogleAuth.signIn()
        .then(res => {
          console.log(res);
          
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });

  }
}
