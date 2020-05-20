import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse, HttpHeaders, HttpResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError, tap, finalize, map } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';
import { Router, ActivatedRoute } from '@angular/router';



@Injectable()
export class AuthInterceptorService implements HttpInterceptor {
    public routesSkip = ['login', 'register'];

    constructor(
        public authService: AuthService,
        public toastr: ToastrService,
        public translate: TranslateService,
        public router: Router,
        public aRoute: ActivatedRoute,
    ) { }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        // All HTTP requests are going to go through this method


        let clone = req.clone();
        if (this.authService.checkToken()) {
            clone = clone.clone(
                {
                    headers: req.headers.set('Authorization', "Bearer " + this.authService.token)
                }
            );
        }

        return next.handle(clone)
            .pipe(
                tap((res: HttpResponse<any>) => {
                    // console.log(res);                    
                    if (res instanceof HttpResponse)
                        if (res.headers.get("Refresh-Token")) {
                            this.authService.token = res.headers.get("Refresh-Token");
                        }
                }),
                catchError((err: HttpErrorResponse) => {
                    if (err instanceof HttpErrorResponse)
                        if (err.headers.get("Refresh-Token")) {
                            this.authService.token = err.headers.get("Refresh-Token");
                        }
                    if (err && err.status == 401 && !this.routesSkip.includes(this.router.url.replace(/[^a-zA-Z]/gi, ''))) {
                        this.authService.killAll();
                        this.toastr.info(
                            this.translate.instant('login.auth_necessary')
                        );
                        this.authService.goToLogin();
                    }

                    return throwError(err);
                }));
    }
}