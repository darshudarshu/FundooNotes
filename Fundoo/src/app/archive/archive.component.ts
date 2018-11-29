declare let require: any;
import { element } from 'protractor';
import { Component, OnInit, OnDestroy, Inject } from '@angular/core';
import {
  NgForm
} from "@angular/forms";
import { NoteserviceService } from "../service/noteservice.service";
import { CookieService } from "angular2-cookie/services/cookies.service";
import { Subscription } from 'rxjs';
import { CommonService } from '../service/common.service';
import { Router } from "@angular/router";
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { EditnotesComponent } from './../editnotes/editnotes.component';
import { ArchiveService } from '../service/archive.service';
import { LabelService } from "../service/label.service";
@Component({
  selector: 'app-archive',
  templateUrl: './archive.component.html',
  styleUrls: ['./archive.component.css']
})
export class ArchiveComponent implements OnInit, OnDestroy {
  /**
   * variable to check whether the error occured or not
   */
  public iserror = false;
  /**
    * variable to store labels
    */
  labels;
  /**
  * variable to toggle between grid and List view 
  */
  public grid: boolean;
  /**
  * variable to hold present time
  */
  public PresentTime;
  /**
 * variable to hold present time
 */
  public otherPresentTime;
  /**
  * to show error message
  */
  public errorMessage = "";
  /**
  * var to hold present time
  */
  public currentDateAndTime = "";
  /**
  * variable which holds the color of note
  */
  public color = "";
  /**
  * variable of type subscription
  */
  private subscription: Subscription;
  /**
  * array to hold user notes data
  */
  model: any = {};
  /**
  * array to users notes
  */
  notes;
  /**
  * variable to hold user email
  */
  email: string = "";

  constructor(private labelservice: LabelService, private archiveService: ArchiveService, public dialog: MatDialog, private router: Router, private notesService: NoteserviceService, private _cookieService: CookieService, private commonService: CommonService) {
    /**
    * subscribing the notifyObservable variable in common service
    */
    this.subscription = this.commonService.notifyObservable$.subscribe((res) => {
      this.grid = res;
    });
    /**
    * method which runs over every 1 second
    */
    setInterval(() => {
      this.remainder();
    }, 9000);
  }
  /**
   * @method remainder()
   * @return void  
   */
  remainder() {
    let dateFormat = require("dateformat");
    this.notes.forEach(element => {
      let now = new Date();
      let currentTime = dateFormat(now, "hh:MM tt");

      let currentDate = dateFormat(now, "dd/mm/yyyy");
      let DateAndTime = currentDate + " " + currentTime;
      this.currentDateAndTime = DateAndTime;
      if (DateAndTime == element.remainder) {
        alert("remainder");
      }
    });
  }
  displayMain = false;
  displayOtherCards = false;
  timer_button = false;
  timer_panel = false;
  other_timer_button = false;
  other_timer_panel = false;
  remainder_id = "";
  note_id = "";
  /**
   * @method ngOnInit()
   * @return void  
   */
  ngOnInit() {
    this.email = this._cookieService.get('email');
    let obs = this.archiveService.fetchArchiveNote(this.email);
    obs.subscribe(
      (res: any) => {
        this.notes = res;
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
      });


    let obss = this.labelservice.fetchLabels(this.email);
    obss.subscribe(
      (res: any) => {
        this.labels = res;
      });
  }

  /**
   * @method ngOnDestroy()
   * @return void
   * @description function which destroy the subscription
   */
  ngOnDestroy() {
    this.subscription.unsubscribe();
  }
  /**
   * @method setColor()
   * @param id
   * @param changecolor
   * @return void
   * @description function to save the color to the database
   */
  setColor(id, changecolor) {
    let obs = this.notesService.colorChange(id, changecolor);
    obs.subscribe(
      (res: any) => { });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.color = changecolor;
      }
    });
  }
  /**
   * @method setColor()
   * @param id
   * @return void
   * @description function to save the color to the database
   */
  setColorToTitle(changecolor) {
    this.color = changecolor;
  }
  /**
   * @method setColor()
   * @param id
   * @return void
   * @description function to open the other time panel
   */
  othertimepanel(id) {
    this.notes.forEach(element => {
      if (element.id == id) {
        this.other_timer_panel = !this.other_timer_panel;
        this.remainder_id = id;
      }
    });
  }
  /**
   * @method setColor()
   * @param id
   * @return void
   * @description function to save the color to the database
   */
  otherSaveTimeDate(id) {
    let dateFormat = require("dateformat");
    let currentDate = dateFormat(this.model.date, "dd/mm/yyyy");
    this.currentDateAndTime = currentDate + " " + this.model.time;
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = this.currentDateAndTime;
        this.otherPresentTime = this.currentDateAndTime;
      }
    });
    if (this.model.date != null && this.model.time != null) {
      let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
      obs.subscribe(
        (res: any) => { });
      this.other_timer_button = true;
      this.other_timer_panel = false;
    }
  }
  /**
  * @method otherClearTimeDate()
  * @return void
  * @param id
  * @description Function to clear the user entered date and time
  */
  otherClearTimeDate(id) {
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = 'undefined';
        this.otherPresentTime = 'undefined';
        this.model.date = null;
        this.model.time = null;
        this.other_timer_button = false;
      }
    });
    let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
    obs.subscribe(
      (res: any) => { });
  }
  /**
   * @method today()
   * @param id
   * @return void
   * @description function to save the color to the database
   */
  today(id) {
    this.other_timer_button = true
    this.notes.forEach(element => {
      if (element.id == id) {
        element.remainder = this.currentDateAndTime;
        this.otherPresentTime = this.currentDateAndTime;
      }
    });
    let obs = this.notesService.dateTimeChange(id, this.otherPresentTime);
    obs.subscribe(
      (res: any) => { });
  }
  /**
   * @method openDialog()
   * @param user
   * @return void
   * @description function to open the dilog box
   */
  openDialog(user): void {
    const dialogRef = this.dialog.open(EditnotesComponent, {
      // width: '200px',height:'200px',
      data: { user: user }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result != undefined) {
        this.notes = result;
      }
    });
  }
  /**
   * @method unArchiveNote()
   * @param id
   * @return void
   * @description function to Unarchive notes
   */
  unArchiveNote(id) {
    let obs = this.archiveService.unArchiveThisNote(id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
          this.notes = res;
        }
      });
  }
  /**
   * @method deleteNote()
   * @param id
   * @return void
   * @description function to delete note
   */

  deleteNote(id) {
    let obs = this.archiveService.deleteArchiveNote(id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
          this.notes = res;
        }
      });
  }
  /**
   * @method setLabel()
   * @param id
   * @param Label
   * @return void
   * @description function to set label
   */
  setLabel(id, Label) {

    let obs = this.notesService.setLabels(id, Label);
    obs.subscribe(
      (res: any) => { });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.label = Label;
      }
    });
  }
  /**
   * @method deleteLabel()
   * @param id
   * @return void
   * @description function to delete Label
   */
  deleteLabel(id) {
    let obs = this.notesService.deleteLabels(id);
    obs.subscribe(
      (res: any) => { });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.label = null;
      }
    });
  }

}
