import { Injectable, Inject } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CommonlabelService {
  /**
    * variable to hold the subject
    */
  private notifylabelname = new Subject<any>();
  /**
    * variable to holding the observable type subject
    */ 
  notifylabelnameObservable$ = this.notifylabelname.asObservable();
  constructor() { }
  /**
    * @method notifyLabel()
    * @description function to add data to subject
    */
  public notifyLabel(labelname: any) {
    this.notifylabelname.next(labelname);
  }
}
