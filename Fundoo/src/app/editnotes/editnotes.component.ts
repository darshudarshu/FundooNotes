import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { element } from 'protractor';
import { Component, OnInit, OnDestroy, Inject } from '@angular/core';
import {
  NgForm
} from "@angular/forms";
import { NoteserviceService } from "../service/noteservice.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
import { ArchiveService } from '../service/archive.service';
@Component({
  selector: 'app-editnotes',
  templateUrl: './editnotes.component.html',
  styleUrls: ['./editnotes.component.css']
})
export class EditnotesComponent implements OnInit {

  /**
   * variable to current date and time
   */
  public currentDateAndTime = "";

  /**
   * variable to remainder id
   */
  remainder_id = "";
  /**
   * variable to note id
   */
  note_id = "";
  /**
   * variable to emailid
   */
  email = "";
  model: any = {};

  constructor(public dialogRef: MatDialogRef<EditnotesComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any, private _cookieService: CookieService, public dialog: MatDialog, private notesService: NoteserviceService, private archiveService: ArchiveService) {
    setInterval(() => {
      let dateFormat = require("dateformat");
      let now = new Date();
      let currentTime = dateFormat(now, "hh:MM tt");
      let currentDate = dateFormat(now, "dd/mm/yyyy");
      this.currentDateAndTime = currentDate + " " + currentTime;
    }, 1000);
  }
  displayMain = false;
  displayOtherCards = false;
  timer_button = false;
  timer_panel = false;
  other_timer_button = false;
  other_timer_panel = false;
  /**
   * @method ngOnInit()
   * @return void
   * @description Function to fetch the data from source
   */

  ngOnInit() {
    this.email = this._cookieService.get('email');
  }
  /**
   * @method onNoClick()
   * @return void
   * @description Function to close the subscription
   */
  onNoClick(): void {
    this.dialogRef.close();
  }
  /**
  * @method otherClearTimeDate()
  * @return void
  * @param id
  * @description Function to clear the user entered date and time
  */

  otherSaveTimeDate() {
    let dateFormat = require("dateformat");
    let currentDate = dateFormat(this.model.date, "dd/mm/yyyy");
    this.data.user.remainder = currentDate + " " + this.model.time;
    if (this.model.date != null && this.model.time != null) {
      this.other_timer_button = true;
      this.other_timer_panel = false;
    }
  }
  /**
   * @method deleteNote()
   * @return void
   * @description Function to clear the user entered date and time
   */
  deleteNote() {
    let obs = this.notesService.deleteThisNote(this.data.user.id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
          this.dialogRef.close(res);
        }
      });
  }
  /**
  * @method archiveNote()
  * @return void
  * @description Function to edit note
  */
  editNotes() {
    if (this.data.user.notes != null && this.data.user.title != null && this.data.user.title != "") {

      let obs = this.notesService.editedNoteData(this.data.user, this.email);
      obs.subscribe(
        (res: any) => {
        }
      );
      this.dialogRef.close();
    }
  }
  /**
  * @method archiveNote()
  * @return void
  * @param id 
  * @description Function to archive note
  */
  archiveNote(id) {
    let obs = this.archiveService.archiveThisNote(id, this.email);
    obs.subscribe(
      (res: any) => {
      });
  }

}
