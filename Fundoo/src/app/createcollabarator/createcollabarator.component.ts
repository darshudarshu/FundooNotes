import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { element } from 'protractor';
import { Component, OnInit, OnDestroy, Inject } from '@angular/core';
import { CollabaratorService } from "../service/collabarator.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
@Component({
  selector: 'app-createcollabarator',
  templateUrl: './createcollabarator.component.html',
  styleUrls: ['./createcollabarator.component.css']
})
export class CreatecollabaratorComponent implements OnInit {
  /**
   * variable to hold the all of the colabarator
   */
  collabarators;
  /**
   * variable to hold the owner of the fundoo
   */
  mainOwner = "";
  /**
   * variable to hold the email
   */
  emmail;
  /**
   * variable to hold the adding email
   */
  addEmail;
  /**
   * variable to check weather the error accured or not
   */
  errorCheck = false;
  /**
   * variable to check weather the error in response  or not
   */
  public iserror = false;
  /**
   * variable to hold the error massage
   */
  public errorMessage = "";
  constructor(public dialogRef: MatDialogRef<CreatecollabaratorComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any, public dialog: MatDialog, private _cookieService: CookieService, private collabaratorService: CollabaratorService) {
  }
  /**
   * @method ngOnInit()
   * @return void
   * @description Function to fetch the data from source
   */
  ngOnInit() {
    this.mainOwner = this._cookieService.get('email');

    let obs = this.collabaratorService.fetchCollabarators(1111, this.mainOwner);
    obs.subscribe(
      (res: any) => {
        this.collabarators = res;
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }
  /**
   * @method addCollabarator()
   * @return void
   * @param id
   * @description Function to fetch the data from source
   */
  addCollabarator(id) {
    console.log(id);
    let obs = this.collabaratorService.addCollabarators(id, this.mainOwner, this.addEmail);
    obs.subscribe(
      (res: any) => {
        if (res.status == 300) {
          this.errorCheck = true;
        } else {
          this.collabarators = res;
          console.log(res);
        }
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
    this.addEmail = null;
  }
  /**
   * @method save()
   * @return void
   * @description Function to fetch the data from source
   */
  save() {
    let obsss = this.collabaratorService.fetchCollabarators(1111, this.mainOwner);
    obsss.subscribe(
      (res: any) => {
        this.collabarators = res;
        if (this.collabarators[0] == undefined) {
          this.dialogRef.close();
        } else {
          this.dialogRef.close(this.collabarators);
        }
      });
  }
  /**
   * @method onClose()
   * @return void
   * @description Function to close the subscription
   */
  onClose() {
    this.dialogRef.close();
  }
  /**
   * @method deleteCollabarator()
   * @return void
   * @param currentEmail
   * @description Function to delete collabarator
   */
  deleteCollabarator(currentEmail) {
    let obs = this.collabaratorService.deleteMainCollabarators(1111, this.mainOwner, currentEmail);
    obs.subscribe(
      (res: any) => {
        this.collabarators = res;

      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }
}
