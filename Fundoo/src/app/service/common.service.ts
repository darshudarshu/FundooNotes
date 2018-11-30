import { Injectable, Inject } from '@angular/core';
import { Subject } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class CommonService {
  /**
    * variable to hold the subject
    */
  private notify = new Subject<any>();
  /**
    * variable to holding the observable type subject
    */
  notifyObservable$ = this.notify.asObservable();
  constructor() { }
  /**
    * @method notifyOther()
    * @description function to add data to subject
    */
  public notifyOther(data: any) {
    this.notify.next(data);
  }

  /**
    * variable to hold the subject
    */
  private searchData = new Subject<any>();
  /**
    * variable to holding the observable type subject
    */
  searchDataObservable$ = this.searchData.asObservable();

  /**
    * @method sendSearchDataToService()
    * @description function to add data to subject
    */
  public sendSearchDataToService(data: any) {

    this.searchData.next(data);
  }
}
