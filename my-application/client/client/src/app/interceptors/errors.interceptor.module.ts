import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { ToastrService } from 'ngx-toastr';
import { TranslateService } from '@ngx-translate/core';



@Injectable()
export class ErrorsInterceptorService implements HttpInterceptor {
    constructor(
        public toastr: ToastrService,
        public translate: TranslateService,

    ) {

    }
    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        // All HTTP requests are going to go through this method

        return next.handle(req)
            .pipe(catchError((err: HttpErrorResponse) => {
                if (err && err.status !== undefined) {
                    if (err.status == 500) {
                        this.toastr.error(this.translate.instant('common.server_error'));
                    } else if (err.status == 406) {
                        // this.toastr.warning(this.translate.instant('common.nothing-found'));
                    } else if (err.status == 0) {
                        this.toastr.error(this.translate.instant('common.not_communicate_server'));
                    }
                }
                console.log(err);

                return throwError(err);
            }));
    }
}