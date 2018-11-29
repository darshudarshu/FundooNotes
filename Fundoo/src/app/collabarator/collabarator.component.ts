
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { element } from 'protractor';
import { Component, OnInit, OnDestroy, Inject } from '@angular/core';
import { CollabaratorService } from "../service/collabarator.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
@Component({
  selector: 'app-collabarator',
  templateUrl: './collabarator.component.html',
  styleUrls: ['./collabarator.component.css']
})
export class CollabaratorComponent implements OnInit {
  /**
   * variable to hold the email
   */
  email = "";
  /**
   * variable to hold the owner of the colabarator
   */
  owner = "";
  /**
   * variable to hold the all of the colabarator
   */
  collabarators;
  /**
   * variable to hold the owner of the fundoo
   */
  mainOwner = "";
  /**
   * variable to check weather the error accured or not
   */
  errorCheck = false;
  emmail;
  /**
   * variable to check weather the error in response  or not
   */
  public iserror = false;
  /**
   * variable to hold the error massage
   */
  public errorMessage = "";
  constructor(public dialogRef: MatDialogRef<CollabaratorComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any, public dialog: MatDialog, private _cookieService: CookieService, private collabaratorService: CollabaratorService) {
  }
  /**
   * @method ngOnInit()
   * @return void
   * @description Function to fetch the data from source
   */
  ngOnInit() {
    this.mainOwner = this._cookieService.get('email');
    let obs = this.collabaratorService.fetchCollabarators(this.data.user.id, this.data.user.email);
    obs.subscribe(
      (res: any) => {
        this.collabarators = res;
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
    let obss = this.collabaratorService.fetchOwner(this.data.user.id);
    obss.subscribe(
      (res: any) => {
        if (res.owner.owner != undefined) {
          this.owner = res.owner.owner;
        } else {
          this.owner = this._cookieService.get('email');
        }
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
  }
  /**
   * @method addCollabarator()
   * @return void
   * @param id
   * @param email
   * @description Function to fetch the data from source
   */
  addCollabarator(email, id) {
    let obs = this.collabaratorService.addCollabarators(id, email, this.emmail);
    obs.subscribe(
      (res: any) => {
        if (res.status == 300) {
          this.errorCheck = true;
        } else {
          this.collabarators = res;
        }
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });
    this.emmail = null;
  }
  /**
   * @method save()
   * @return void
   * @description Function to fetch the data from source
   */
  save() {
    let obsss = this.collabaratorService.fetchCollabaratorsOfNotes(this.mainOwner);
    obsss.subscribe(
      (res: any) => {
        this.collabarators = res;
        this.dialogRef.close(this.collabarators);
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
   * @param id
   * @param collId
   * @param noteId
   * @param email
   * @param owner
   * @param currentEmail
   * @description Function to delete collabarator
   */
  deleteCollabarator(collId, noteId, email, owner, currentEmail) {
    if (owner == this.mainOwner) {

      let obs = this.collabaratorService.deleteCollabarators(collId, email, currentEmail, noteId);
      obs.subscribe(
        (res: any) => {
          this.collabarators = res;
        }, error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
    }
    else if (currentEmail == this.mainOwner) {
      alert("remove my self");
      let obs = this.collabaratorService.deleteCollabarators(collId, email, currentEmail, noteId);
      obs.subscribe(
        (res: any) => {
          this.collabarators = res;
        }, error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
    }
  }
}
