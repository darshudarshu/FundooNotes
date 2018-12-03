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
import { TrashService } from '../service/trash.service';
import { Notes } from "../core/model/note";

@Component({
  selector: 'app-trash',
  templateUrl: './trash.component.html',
  styleUrls: ['./trash.component.css']
})
export class TrashComponent implements OnInit {
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
  /**
  * array to hold user notes data
  */
  model: any = {};
   /**
  * array to users notes
  */
  notes :Notes[]=[];

 
  /**
  * variable to hold user email
  */
  email: string = "";
  constructor(private trashService: TrashService, private archiveService: ArchiveService, public dialog: MatDialog, private router: Router, private notesService: NoteserviceService, private _cookieService: CookieService, private commonService: CommonService) {
    /**
    * subscribing the notifyObservable variable in common service
    */
    this.subscription = this.commonService.notifyObservable$.subscribe((res) => {
      this.grid = res;
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
  * @description Function to fetch data
  */
  ngOnInit() {
    this.email = this._cookieService.get('email');

    let obs = this.trashService.fetchTrashNote(this.email);
    obs.subscribe(
      (res: any) => {
        this.notes = res;
      }, error => {
        this.iserror = true;
        this.errorMessage = error.message;
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
  * @method resatoreNote()
  * @return void
  * @param id
  * @description Function to restore note
  */
  restoreNote(id) {
    let obs = this.trashService.restoreTrashNote(id, this.email);
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
  * @return void
  * @param id
  * @description Function to delete the note permanetly
  */
  deletNote(id) {
    let obs = this.trashService.deletTrashNote(id, this.email);
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


}
