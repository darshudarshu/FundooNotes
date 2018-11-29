import { element } from 'protractor';
import { Component, OnInit, Inject } from '@angular/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { LabelService } from "../service/label.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
@Component({
  selector: 'app-labels',
  templateUrl: './labels.component.html',
  styleUrls: ['./labels.component.css']
})
export class LabelsComponent implements OnInit {
  /**
   * variable to hold the labels
   */
  labels;
  public edit = false;
  /**
   * variable to hold the labelId
   */
  public labelid = "";
  /**
   * variable to hold the current label
   */
  public currentLabel;
  /**
   * variable to hold the email
   */
  public email;
  constructor(public dialogRef: MatDialogRef<LabelsComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any, public dialog: MatDialog, private labelservice: LabelService, private _cookieService: CookieService) { }
  /**
   * @method ngOnInit()
   * @return void
   * @description Function to fetch the data from source
   */
  ngOnInit() {
    this.email = this._cookieService.get('email');
    let obs = this.labelservice.fetchLabels(this.email);
    obs.subscribe(
      (res: any) => {
        this.labels = res;
      });
  }
  /**
   * @method onClose()
   * @return void
   * @description Function to close the subscription
   */
  onClose() {
    ;
    if (this.currentLabel != undefined && this.currentLabel != "") {
      let obs = this.labelservice.addLabels(this.currentLabel, this.email);
      obs.subscribe(
        (res: any) => {
          ;
          this.dialogRef.close(res);

        });
    }
    this.dialogRef.close(this.labels);
  }
  /**
   * @method nochange()
   * @return void
   * @param id
   * @description Function to change label on no change
   */
  noChange(id) {
    this.labels.forEach(element => {
      if (element.id == id) {
        this.labelid = id;
        this.edit = false;
      }
    });
  }
  /**
   * @method change()
   * @return void
   * @param id
   * @param name
   * @description Function to change label on change
   */
  change(id, name) {
    this.labels.forEach(element => {
      if (element.id == id) {
        this.labelid = id;
        this.edit = true;
        let obs = this.labelservice.changeLabels(id, name, this.email);
        obs.subscribe(
          (res: any) => {
            this.labels = res;
          });
      }
    });
  }
  /**
   * @method delete()
   * @return void
   * @param id
   * @description Function to delete the label 
   */
  delete(id) {
    ;
    let obs = this.labelservice.deleteLabels(id, this.email);
    obs.subscribe(
      (res: any) => {
        this.labels = res;
      });
  }


}
