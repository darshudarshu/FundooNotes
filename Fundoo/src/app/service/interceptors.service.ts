import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpEvent, HttpHandler, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class InterceptorsService implements HttpInterceptor {
  constructor() { }
  /**
    * @method intercept() 
    * @return data to header through handler
    * @param email 
    * @param id 
    * @description Function to send email and id to server
    */
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = localStorage.getItem("token");
    const authreq = req.clone({
      headers: req.headers.set("Authorization", "Bearer " + token)
    });
    return next.handle(authreq);
  }
}
