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
import { RemainderService } from '../service/remainder.service';
import { ArchiveService } from '../service/archive.service';
import { LabelService } from "../service/label.service";
import { CommonlabelService } from '../service/commonlabel.service';
import { SelectlabelService } from '../service/selectlabel.service';
@Component({
  selector: 'app-labelcomponent',
  templateUrl: './labelcomponent.component.html',
  styleUrls: ['./labelcomponent.component.css']
})
export class LabelcomponentComponent implements OnInit, OnDestroy {
  public archive = false;
  labels;
  public labelname = null;
  public selectedLabel = "";
  public isArchivedNote = "no";
  /**
   * variable to check whether the error occured or not
   */
  public iserror = false;
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
  private subscriptionLabel: Subscription;
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
  constructor(private selectlabelService: SelectlabelService, private commonlabelService: CommonlabelService, private labelservice: LabelService, private archiveService: ArchiveService, private remainderService: RemainderService, public dialog: MatDialog, private router: Router, private notesService: NoteserviceService, private _cookieService: CookieService, private commonService: CommonService) {
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
    /**
     * for each runs to check wheather the user time matches with current time 
     */
    this.notes.forEach(element => {
      let now = new Date();
      /**
       * formating the current time to the required time format
       */
      let currentTime = dateFormat(now, "hh:MM tt");
      /**
       * formating the current date to the required format
       */
      let currentDate = dateFormat(now, "dd/mm/yyyy");
      let DateAndTime = currentDate + " " + currentTime;
      this.currentDateAndTime = DateAndTime;
      /**
       * compare with present time if equal alert remainder
       */
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
  * @description Function to fetch the data from source
  */
  ngOnInit() {
    this.subscriptionLabel = this.commonlabelService.notifylabelnameObservable$.subscribe((result) => {
      this.selectedLabel = result;
      /**
     * loading notes while refreshing the page
     */
      let obs = this.selectlabelService.fetchRemainderNote(this.selectedLabel, this.email);
      obs.subscribe(
        (res: any) => {
          /**
           * assing response to the user notes
           */
          this.notes = res;
        }, error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
    });
    this.email = this._cookieService.get('email');
    let obss = this.labelservice.fetchLabels(this.email);
    obss.subscribe(
      (res: any) => {
        this.labels = res;
      });
  }
  /**
  * @method saveTimeDate()
  * @return void
  * @description Function to store the user entered date and time
  */
  saveTimeDate() {
    let dateFormat = require("dateformat");
    let currentDate = dateFormat(this.model.date, "dd/mm/yyyy");
    this.currentDateAndTime = currentDate + " " + this.model.time;
    this.PresentTime = this.currentDateAndTime;
    if (this.model.date != null && this.model.time != null) {
      this.timer_button = true;
      this.timer_panel = false;
    }
  }
  /**
  * @method clearTimeDate()
  * @return void
  * @description Function to clear the user entered date and time
  */
  clearTimeDate() {
    this.model.date = null;
    this.model.time = null;
    this.PresentTime = 'undefined';
    this.timer_button = false;
  }
  /**
  * @method displayMethod()
  * @return void
  * @description Function to store the user entered notes data
  */
  displayMethod() {
    this.displayMain = !this.displayMain;
    this.email = this._cookieService.get('email');
    if (this.model.note != null && this.model.title != null && this.model.title != "") {
      /**
      * calling the function and subscribing to its response notedata present in the notesservice and 
      */
      let obs = this.selectlabelService.noteData(this.model, this.email, this.PresentTime, this.color, this.isArchivedNote, this.labelname);
      obs.subscribe(
        (res: any) => {
          /**
           * Checking the authorised user or not
           */
          if (res.error == 404) {
            alert("Unathourized User");
            localStorage.removeItem("token");
            this.router.navigate(['/login'])
          } else {
            this.notes = res;
          }
        },
        error => {
          this.iserror = true;
          this.errorMessage = error.message;
        });
      this.model.title = null;
      this.model.note = null;
      this.labelname = null;
    }
    this.color = null;
    this.isArchivedNote = "no";
  }
  /**
   * @method ngOnDestroy()
   * @return void
   * @description function which destroy the subscription
   */
  ngOnDestroy() {
    this.subscription.unsubscribe();
    this.subscriptionLabel.unsubscribe();
  }

  /**
   * @method setColor()
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
* @method setColorToTitle()
* @return void
* @param changecolor
* @description Function to set colour to title card
*/
  setColorToTitle(changecolor) {
    this.color = changecolor;
  }
 /**
* @method othertimepanel()
* @return void
* @param id
* @description Function to opon time panel card
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
* @method otherClearTimeDate()
* @return void
* @param id
* @description Function to clear the user entered date and time
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
    let obs = this.selectlabelService.dateTimeChange(id, this.otherPresentTime, this.selectedLabel, this.email);
    obs.subscribe(
      (res: any) => {
        console.log(res);
        this.notes = res;
      });
  }
  /**
  * @method today()
  * @return void
  * @param id
  * @description Function to select today
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
  * @return void
  * @param user 
  * @description Function to open the dialogbox of editer component
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
  * @method archiveNote()
  * @return void
  * @param id 
  * @description Function to archive note
  */
  archiveNote(id) {
    this.archive = !this.archive
    let obs = this.archiveService.archiveThisNote(id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
        }
      });
  }
  /**
  * @method unArchiveNote()
  * @return void
  * @param id 
  * @description Function to unArchive note
  */
  unArchiveNote(id) {
    this.archive = !this.archive
    let obs = this.archiveService.unArchiveThisNote(id, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
        }
      });
  }
/**
 * @method deleteNote()
 * @return void
 * @param id
 * @description Function to delete the note
 */
  deleteNote(id) {
    let obs = this.selectlabelService.deleteRemainderNotes(id, this.selectedLabel, this.email);
    obs.subscribe(
      (res: any) => {
        if (res.error == 202) {
          alert("Unknown data");
        }
        else {
          console.log(res);
          this.notes = res;
        }
      });

  }
  /**
  * @method setLabel()
  * @return void
  * @param id 
  * @param Label
  * @description Function to set the label
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
  * @return void
  * @param id
  * @description Function to delete label
  */
  deleteLabel(id, deletelabel) {
    let obs = this.selectlabelService.deleteLabels(id, deletelabel, this.email);
    obs.subscribe(
      (res: any) => {
        this.notes = res;
      });
    this.notes.forEach(element => {
      if (element.id == id) {
        element.label = null;
      }
    });
  }
}
